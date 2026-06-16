# Code Review — Herzog Dupont for YOOtheme Pro (Joomla System Plugin)

**Scope reviewed:** entire repository at `1.9.3`
**Review focus (priority order):** plugin-specific security → code quality / maintainability → Joomla 6 plugin best practices → YOOtheme Pro best practices → testing / CI / ops.

This review respects the stated trust boundary: builder content is authored by authenticated users through YOOtheme Pro / Joomla ACL, and output escaping for standard builder text/HTML fields is delegated to YOOtheme. Unescaped `<?= $props['content'] ?>`‑style output that mirrors YOOtheme core elements is **not** reported as a vulnerability. Only risks this plugin itself introduces are flagged.

---

## 0. Executive summary

The plugin is a small, well‑factored set of YOOtheme Pro builder elements with a thin Joomla system‑plugin shim. The element transforms and templates closely mirror YOOtheme core (Grid / Panel / Slideshow), which keeps the security surface small and the escaping responsibilities delegated correctly.

There are **no Critical or High plugin‑specific security findings.** The most material items are:

- **Medium:** `hd-lottie/templates/content.php` loads `lottie` from a remote CDN at render time and interpolates the authored `path` raw into an inline `<script>` (script‑context injection + supply‑chain dependency that diverges from the bundled, SRI‑pinned production path).
- **Medium (correctness/portability):** `hd-progress/templates/template.php` uses PHP short open tags (`<? … ?>`), which break when `short_open_tag=Off`.
- **Medium (Joomla 6 readiness):** the plugin still uses the legacy `plgSystemHerzogdupont extends CMSPlugin` + `onAfterInitialise()` pattern. Legacy `on*` listener methods are removed in Joomla 6; the plugin must migrate to `SubscriberInterface` + PSR‑4 `src/Extension/` + `services/provider.php`.

Everything else is Low / Informational or accepted risk. Detailed findings follow.

---

## 1. Security — plugin‑specific surface

### 1.1 Plugin bootstrap & early exit — `herzogdupont.php` — **Informational (good)**

```16:28:herzogdupont.php
class plgSystemHerzogdupont extends CMSPlugin
{
    public function onAfterInitialise()
    {
        // Check if YOOtheme Pro is loaded
        if (!class_exists(Application::class, false)) {
            return;
        }

        // Load all modules
        $app = Application::getInstance();
        $app->load(__DIR__ . '/modules/*/bootstrap.php');
   }
}
```

- The early `class_exists(Application::class, false)` guard (with `$autoload = false`) is correct and cheap: it does **not** trigger autoloading, so when YOOtheme Pro is not present the plugin bails immediately with essentially no work. Good.
- The only per‑request cost when YOOtheme *is* loaded is a glob (`/modules/*/bootstrap.php`) inside `Application::load()`. Acceptable; YOOtheme caches its container. No finding.
- Minor: `onAfterInitialise` runs on **every** request including admin and API. The work is gated by YOOtheme presence so it is fine, but see §3.1 — the event itself fires very early and the modern equivalent is a typed subscriber.

**Verdict:** Safe. No early‑exit gap.

### 1.2 Filesystem / path handling — `hd-lottie/templates/template.php` — **Low / Accepted**

```19:20:modules/elements/elements/hd-lottie/templates/template.php
    'data-name' => $props['animation-name'] ?? uniqid('hd-'),
    'data-animation-path' => realpath($props['path']) ? '/' . $props['path'] : $props['path'],
```

- `$props['path']` is a YOOtheme `link` field (`"type": "link", "source": true`) authored by a privileged user. It is emitted as a `data-*` attribute through `$this->el()`, which HTML‑escapes attribute values — so there is **no attribute‑injection** here.
- The animation is fetched **client‑side** by `lottie.loadAnimation({ path })`. There is no server‑side fetch, so this is **not SSRF**. A privileged author can already point it at an arbitrary URL by design (the field literally invites a URL).
- `realpath()` is used only as a boolean test ("does this resolve to a local file?") to decide whether to prefix `/`. Two concerns, both Low:
  1. `realpath()` resolves relative to the PHP **CWD**, which in Joomla is normally the site root but is not contractually guaranteed; the `/`‑prefix heuristic can produce a wrong root‑relative URL in atypical setups.
  2. It performs a filesystem `stat` on every render of every lottie element. Negligible, but it is logic YOOtheme core media handling does not need.

**Exploit scenario:** none beyond what an authorized author can already do (load a chosen JSON URL). 
**Recommended fix (optional):** mirror YOOtheme's own media/URL resolution helper instead of `realpath()` + manual `/` prefixing, or at minimum compute against `JPATH_ROOT` rather than CWD. Mark as **accepted risk** otherwise.

### 1.3 Remote CDN script + raw path in inline `<script>` — `hd-lottie/templates/content.php` — **Medium**

```16:28:modules/elements/elements/hd-lottie/templates/content.php
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.13.0/lottie.min.js" integrity="sha512-…" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
…
<script>
lottie.loadAnimation({
    container: document.getElementById('<?= $uniqid ?>'),
    renderer: 'svg',
    loop: <?= $loop ?>,
    autoplay: true,
    path: <?= "'" . $path . "'" ?>
});
</script>
```

The `content` template is used when the element renders **outside** the live builder (e.g. content/source rendering), so this is not purely an editor preview. Two issues:

1. **Supply chain / inconsistency.** This path pulls `lottie` from `cdnjs` at runtime, while the production `render` template (`element.php`) ships the **bundled** `app/lottie.min.js` (also 5.13.0) via `Metadata`. The CDN load: (a) introduces a third‑party runtime dependency and external request the bundled path deliberately avoids, (b) can drift out of sync with the bundled version, and (c) is governed only by SRI — if cdnjs is blocked or the file is pulled, the element silently fails. There is an SRI `integrity` hash (good), but the cleaner answer is to **not** depend on a CDN at all and reuse the bundled asset.
2. **Script‑context interpolation.** `path: '<?= $path ?>'` injects the authored value directly inside a `<script>` string literal with single quotes and no encoding. A `'`, newline, or `</script>` in the path breaks out of the string / element. Because the value is author‑controlled this is at most **self‑XSS / breakage** within the author's own context, but it is a *novel, plugin‑specific* sink (the production template avoids it entirely by using `data-*` attributes consumed by `hd-lottie.js`). It should be encoded with `json_encode()` (which also removes the manual quote concatenation).

**Recommended fix:**
- Drop the CDN `<script>` and reuse the bundled `app/lottie.min.js` (register via `Metadata` as the `render` template does), or at least keep the CDN version pinned identically to the bundle.
- Replace `path: <?= "'" . $path . "'" ?>` with `path: <?= json_encode($path) ?>` and `loop: <?= json_encode($loop) ?>`.

### 1.4 Tag → `uk-filter-control` selector — `hd-slideshow-grid` — **Informational (good)**

```17:23:modules/elements/elements/hd-slideshow-grid/element.php
                    foreach (explode(',', $child->props['tags']) as $tag) {
                        // Strip tags as precaution if tags are mapped dynamically
                        $tag = strip_tags($tag);
                        if ($key = str_replace(' ', '-', trim($tag))) {
                            $child->tags[$key] = trim($tag);
                        }
                    }
```

```51:55:modules/elements/elements/hd-slideshow-grid/templates/template-nav.php
    <?php foreach ($tags as $tag => $name) : ?>
    <?php $selector = htmlspecialchars("[data-tag~='" . str_replace("'", "\'", $tag) . "']", ENT_QUOTES, null, false) ?>
    <li … uk-filter-control="<?= $selector ?>">
        <a href="#"><?= $name ?></a>
    </li>
```

- The selector built into the `uk-filter-control` attribute is `htmlspecialchars(…, ENT_QUOTES)`‑encoded, so HTML‑attribute breakout is prevented. The tag itself is `strip_tags()`‑ed in the transform. This is the **same pattern YOOtheme core uses** for its Grid filter UI.
- `<?= $name ?>` (the visible label) is emitted unescaped in element text context, but it has been `strip_tags()`‑ed, so no `<` survives — consistent with core behavior. Not a finding.

**One minor note (Low):** `str_replace("'", "\'", $tag)` injects a literal backslash before `htmlspecialchars`, so a tag containing `'` becomes `\&#039;` inside the attribute — cosmetically odd and the backslash is unnecessary (the `htmlspecialchars`/`ENT_QUOTES` already neutralizes the quote). Harmless, but the `str_replace` can be dropped for clarity.

**Verdict:** No injection. Mirrors core. Accepted.

### 1.5 JS runtime safety — custom `.js` — **Low**

- `hd-counter.js` writes `el.innerHTML = value…` where `value` is a `Math.round()` number (and a locale string from `toLocaleString`). No user string reaches `innerHTML`. Acceptable per scope.
- **Uncleaned listeners (memory/perf, not security):**
  - `hd-lottie.js` `case 'scroll'` adds a `window.scroll` listener that is **never removed** and runs `UIkit.util.scrolledOver` + `goToAndStop` on every scroll event, unthrottled, for every scroll‑triggered lottie on the page. On SPA/AJAX navigation (YOOtheme/Joomla can swap content) these accumulate. Recommend `passive: true` + throttling (e.g. `requestAnimationFrame`) and storing the handler so it can be removed.
  - `hd-lottie.js` bottom adds a `window.resize` listener per canvas element, never removed.
  - `hd-flipcard.js` registers global `window.load`/`resize` → `setBackSize` and re‑queries the whole document each time; fine for static pages, but again unthrottled.
  - `hd-image-comparison.js` adds `window.resize` + `orientationchange` per element, never removed.
- These are **not exploitable**; they are leak/perf smells flagged under code quality (§2.3). No external script loading in these files (lottie vendor excluded), no `eval`/dynamic code execution.

**Verdict:** No security finding; tracked as quality.

### 1.6 Third‑party JS supply chain — `hd-lottie/app/lottie.min.js` — **Low / Informational**

- Bundled `lottie-web` is **5.13.0** (confirmed in the file and matching the CDN reference in `content.php`). It is vendored with its MIT `LICENSE.md` (good).
- There is no manifest pinning the version (no `package.json`), so updates are manual and invisible to Dependabot (which is configured for `npm` but the repo has no `npm` manifest — see §5.3). Recommend recording the pinned version (e.g. a comment header or a `package.json`/lockfile) and tracking `lottie-web` advisories. No known critical CVE is being asserted here, but the update policy is undocumented.

### 1.7 Installer / DB — `script.php` — **Low**

```75:93:script.php
    private function enablePlugin()
    {
        try
        {
            $db    = Factory::getDbo();
            $query = $db->getQuery(true)
                        ->update($db->qn('#__extensions'))
                        ->set($db->qn('enabled') . ' = ' . $db->q(1))
                        ->where('type = ' . $db->q('plugin'))
                        ->where('folder = ' . $db->q('system'))
                        ->where('element = ' . $db->q('herzogdupont'));
            $db->setQuery($query);
            $db->execute();
        }
        catch (\Exception $e) { return; }
    }
```

- **Query parameterization:** values are passed through `$db->q()`/`$db->qn()` with constant inputs — no injection. Could be modernized to bound parameters, but not required.
- **Silent exception swallowing (Low):** `catch (\Exception $e) { return; }` hides DB failures. If auto‑enable fails the admin gets no signal. Prefer logging via `Log::add(...)` so failures are diagnosable. Self‑enabling a plugin on install is itself a slightly unusual UX choice (Joomla normally lets the admin enable), but it is intentional here and within the admin's own install action — acceptable.

```58:66:script.php
        $yoothemeManifest = simplexml_load_file(JPATH_SITE . '/templates/yootheme/templateDetails.xml');
        if (!$yoothemeManifest or !version_compare((string) $yoothemeManifest->version, $this->minimumYOOthemeVersion, '>='))
```

- **File read without existence check (Low):** if YOOtheme is not installed, `simplexml_load_file()` emits a PHP **warning** before returning `false`. Guard with `is_file()` first and emit a clear, actionable message ("YOOtheme Pro template not found"). Functionally the `!$yoothemeManifest` branch still rejects install, but the raw warning is poor UX and can surface in logs/output.
- **Preflight error UX (Low):** failures use `Log::add(..., 'jerror')`. On modern Joomla, `Factory::getApplication()->enqueueMessage(..., 'warning')` is the more visible, user‑facing channel for install errors.

### 1.8 Direct access guards — **Informational (good, with one nuance)**

- Every PHP entry/source file checks `defined('_JEXEC') or die;` — `herzogdupont.php`, `script.php`, `modules/elements/bootstrap.php`, `src/SettingsListener.php`, `src/StyleListener.php`. Good.
- The per‑element `element.php` / `templates/*.php` files do **not** carry `_JEXEC` guards. This matches YOOtheme convention (they are only ever `include`d through the YOOtheme builder pipeline, never web‑routed) and they contain no standalone side effects, so direct execution would do nothing useful. Combined with the missing per‑directory `index.html` (see §3.3) this is a **defense‑in‑depth** note, not a vulnerability.

### 1.9 Privilege boundaries — **Informational (confirmed: no extra surface)**

- The plugin exposes **no** admin UI, no controllers, no API/AJAX endpoints, no config storage of its own, and no editor/content‑type registration. Element enablement is stored in YOOtheme's own theme config (`~theme.hd.elements`) and edited only through the YOOtheme customizer (`SettingsListener` → `customizer.json`), which is already behind YOOtheme/Joomla ACL.
- Asset loading happens only as a side effect of an element being rendered (via `Metadata` in each `render` transform), so there is no way to load these assets or enable elements outside the normal builder/ACL path. **Expected answer confirmed: no privilege‑boundary bypass.**

---

## 2. Code quality & maintainability

### 2.1 PHP modernization

- **`declare(strict_types=1)` — absent everywhere (Low).** Appropriate to add to the first‑party PHP that is plain classes/functions: `herzogdupont.php` (post‑migration class), `script.php`, `src/SettingsListener.php`, `src/StyleListener.php`. **Be cautious** with the YOOtheme element `element.php` / `template.php` files: they rely heavily on PHP's loose truthiness (`$props['x'] != ''`, `$props['number']`, array/`ArrayAccess` juggling) and are executed inside YOOtheme's render context — adding `strict_types` there risks `TypeError`s for little benefit. Recommend strict types only for the standalone first‑party files.
- **Namespace split is intentional and correct (Informational).** Listener/bootstrap code uses `HerzogDupont\…`; element transforms use `namespace YOOtheme;`. The latter is **required** so transforms can call YOOtheme helpers (`app()`, `Arr`, `Metadata`, `Path`) unqualified — this is the documented YOOtheme element pattern, not an inconsistency. Keep as‑is.
- **`include_once` vs autoloading (Low).** `bootstrap.php` does `include_once __DIR__ . '/src/SettingsListener.php'` etc. For two files this is fine and idiomatic for YOOtheme modules. If the `src/` set grows, register a small PSR‑4 prefix instead. Not worth over‑engineering now.
- **Empty lifecycle methods in `script.php` (Low).** `uninstall()`, `update()`, `postflight()` are empty stubs. Either remove them (the installer works without them) or implement real cleanup. At minimum, `uninstall()` should remove the plugin's persisted theme config keys (`~theme.hd.elements`, `~theme.hd.recompile-style`) so an uninstall/reinstall is clean — currently those keys linger in YOOtheme config after uninstall.

### 2.2 DRY / duplication — `template-link.php` family

Three near‑identical link builders exist, plus the `_back` variant:

- `hd-timeline_item/templates/template-link.php` (87 lines)
- `hd-slideshow-grid_item/templates/template-link.php` (37 lines — a reduced subset)
- `hd-flipcard/templates/template-link.php` (24 lines — minimal) and `hd-flipcard/templates/template-link_back.php` (81 lines — full duplicate of timeline's logic with `_back` suffixes)

**Quantified overlap:** the timeline_item and flipcard `_back` link builders are ~80% identical (panel‑link toggle, `striptags` of title/meta/content, title hover‑style wrapping, image link wrapping, the shared `el-link` / `uk-button …` class expression). The slideshow‑grid_item version is the same shape with a subset of branches. The `uk-button uk-button-{!link_style: |link-muted|link-text} [uk-button-{link_size}] [uk-width-1-1 {@link_fullwidth}]` class string is repeated verbatim in **all four** files.

**Recommendation:** extract a shared partial (e.g. `modules/elements/src/partials/link.php` rendered via `$this->render(...)`) that accepts the field‑name prefix (`''` vs `'_back'`) and the `$props`/`$element` pair, returning the configured `$this->el('a'|'div'|'p')`. This collapses four files to one parameterized helper and removes the verbatim class‑string duplication. The `_back` variant is literally the front variant with a suffix, which is the strongest signal that a prefix parameter is the right abstraction. Keep behavior identical (the partials already follow YOOtheme's own link/title patterns, so this stays "core‑aligned").

### 2.3 Element registry vs hardcoded child items — `bootstrap.php` — **Low**

```42:55:modules/elements/bootstrap.php
        Builder::class => function (Builder $builder, $app) {
            if (is_null($app->config->get('~theme.hd.elements'))) {
                $builder->addTypePath(Path::get('./elements/*/element.json'));
            } else {
                foreach ($app->config->get('~theme.hd.elements') as $key => $value) {
                    if ($value === true) {
                        $builder->addTypePath(Path::get('./elements/' . $key . '/element.json'));
                        if ($key === 'hd-timeline' || $key === 'hd-slideshow-grid') {
                            $builder->addTypePath(Path::get('./elements/' . $key . '_item/element.json'));
                        }
                    }
                }
            }
        }
```

- The parent→child relationship (`hd-timeline` → `hd-timeline_item`, `hd-slideshow-grid` → `hd-slideshow-grid_item`) is hardcoded with a string `if`. Adding another container element means editing this `if`.
- **Recommendation:** drive children from a small map, e.g. `$children = ['hd-timeline' => ['hd-timeline_item'], 'hd-slideshow-grid' => ['hd-slideshow-grid_item']];` and register `$children[$key] ?? []`. Or, better, auto‑discover: register `*_item/element.json` whenever its parent is enabled by convention (`"{$key}_item"`). Either removes the magic strings and scales cleanly.
- Also note the customizer panel (`customizer.json`) lists the 8 toggles and the `default: true` per element; the `is_null(...)` branch (register all) handles the pre‑config state. That dual source of truth (customizer field list vs this loop) is another reason to centralize the element registry in one PHP array consumed by both the loop and, ideally, the panel generation.

### 2.4 JavaScript quality

- **Style inconsistency (Informational):** ES `class` is used in `hd-lottie.js` and `hd-image-comparison.js`, but `hd-counter.js` uses a `function countUp` and `hd-progress.js` / `hd-flipcard.js` use bare IIFE‑style `UIkit.util.ready` blocks. Not wrong, but standardizing on one pattern (classes, or small modules) aids maintenance.
- **Selector API inconsistency (Low):** mix of `UIkit.util.$$('.sel')` (lottie, progress, flipcard, image‑comparison) and `document.querySelectorAll('.sel')` (counter). Pick one; `UIkit.util.$$` is fine since UIkit is a hard dependency.
- **Listener cleanup / throttling (Low):** see §1.5 — scroll/resize handlers in `hd-lottie.js`, `hd-image-comparison.js`, `hd-flipcard.js` are added globally and never removed, and the lottie scroll handler is unthrottled. Add `{ passive: true }` to scroll/touch listeners and throttle scroll work via `requestAnimationFrame`.
- **Good:** `IntersectionObserver` usage in `hd-counter.js` and `hd-lottie.js` (`inview`) is the modern, correct approach and a clear improvement over the old `isVisible`/`isInView` polling noted in the changelog.
- **Minor bug smell (`hd-image-comparison.js`):** `parseInt(this.slider.getAttribute('uk-icon').split('height: ')[1])` parses the icon size out of the rendered `uk-icon` attribute string. This is brittle — it depends on the exact attribute serialization (`width: x; height: x`). If YOOtheme ever reorders/normalizes the attribute it breaks. Prefer reading the dedicated `data-width` attribute the template already emits (`'data-width' => ['{icon_width}']`).

### 2.5 Element migration `updates` blocks — **Informational (good)**

- `updates` keys are version strings and YOOtheme applies them in version order, so the descending order in the files is cosmetic. The transforms use `Arr::updateKeys`, `Arr::get`, and guarded `isset`/`empty` checks consistently — they look correct and defensive (e.g. timeline `2.0.0-beta.9.1` iterating children by reference). No correctness issue found.
- Two slideshow‑grid `updates` (`2.7.3.1`, `2.7.0-beta.0.5`, etc.) are **identical** to the timeline ones — another candidate for a shared migration helper if you extract panel logic (§2.2), though migration code is usually fine to leave duplicated since it is frozen history.

---

## 3. Joomla 6 plugin best practices

### 3.1 Modern plugin architecture — **Medium (migration required for Joomla 6)**

Current code is the pre‑Joomla‑6 legacy form:

```16:28:herzogdupont.php
class plgSystemHerzogdupont extends CMSPlugin
{
    public function onAfterInitialise()
    { … }
}
```

Joomla 6 removes magic discovery of `on*` methods; plugins must implement `SubscriberInterface`. Concrete, behavior‑preserving migration path:

1. **PSR‑4 layout.** Move the class to `src/Extension/Herzogdupont.php` with namespace `HerzogDupont\Plugin\System\Herzogdupont\Extension` (pick a vendor segment and keep it consistent with the manifest `namespace`). Class name `Herzogdupont`.
2. **SubscriberInterface.**
   ```php
   use Joomla\Event\SubscriberInterface;
   final class Herzogdupont extends CMSPlugin implements SubscriberInterface
   {
       protected $allowLegacyListeners = false; // skip reflection-based discovery
       public static function getSubscribedEvents(): array
       {
           return ['onAfterInitialise' => 'bootstrapYootheme'];
       }
       public function bootstrapYootheme(\Joomla\Event\Event $event): void
       {
           if (!class_exists(\YOOtheme\Application::class, false)) { return; }
           \YOOtheme\Application::getInstance()->load(JPATH_PLUGINS . '/system/herzogdupont/modules/*/bootstrap.php');
       }
   }
   ```
   The listener takes a single typed `Event`; no return value is needed for `onAfterInitialise`.
3. **`services/provider.php`.** Add a DI service provider that registers the plugin via `PluginInterface`/`ServiceProviderInterface` (the standard Joomla 5/6 boilerplate using `MVCFactory`/`PluginHelper`). This replaces the `<filename plugin="herzogdupont">` discovery.
4. **Manifest `<namespace>`.** Add `<namespace path="src">HerzogDupont\Plugin\System\Herzogdupont</namespace>` and drop the `plugin="herzogdupont"` attribute on the old root file once the class moves.
5. **`$allowLegacyListeners = false`** for performance (avoids reflection scanning).

This is the single most important modernization for "Joomla 6 readiness." It does not change runtime behavior — `onAfterInitialise` still fires; only the wiring changes.

### 3.2 Manifest & installer — `herzogdupont.xml` / `script.php` — **Low**

- **No `<minimumPhp>` / `<minimumJoomla>` in the manifest.** Today the version gating lives only in `script.php::preflight()`. Joomla can enforce these declaratively in the manifest (and shows nicer errors). Add them and target Joomla 6.x; then the duplicated string checks in `preflight()` become redundant for PHP/Joomla (keep only the YOOtheme check, which Joomla cannot express). Currently `minimumJoomlaVersion = '5.0.0'` while the brief targets Joomla 6 — decide and align the floor.
- **No `<namespace>` element** (see §3.1).
- **No `targetplatform`** declared for Joomla 6.
- **YOOtheme detection UX** when the template is absent: see §1.7 (guard `simplexml_load_file`, use `enqueueMessage`).
- **Lifecycle completeness**: implement or remove the empty `uninstall/update/postflight` (see §2.1).

### 3.3 Other Joomla 6 conventions

- **Language files (Low):** only `.sys.ini` exist (`en-GB`, `de-DE`). That is correct *because* the plugin has zero runtime/admin‑facing strings of its own (all element labels live in YOOtheme `element.json`). No runtime `.ini` is needed — confirm and keep. If §3.2's `enqueueMessage` install errors are added, consider moving those literals into the `.sys.ini` for translation.
- **`index.html` directory guards (Low):** only the root `index.html` exists. The many `modules/.../elements/*/...` directories have none. Modern Joomla relies on web‑server rules and `_JEXEC`, so this is defense‑in‑depth only, but adding empty `index.html` files (or relying on the packaged `web.config`/`.htaccess`) is the conventional belt‑and‑braces. Low priority.
- **GPL license headers (Informational):** headers are consistent across PHP/JS/LESS (GPL v3), with correct dual attribution to YOOtheme GmbH on the Grid/Panel/Slideshow‑derived files. The manifest/README/`.sys.ini` say "version 3" while some headers say "version 3 or later" — harmonize the wording (the project clearly intends GPLv3‑or‑later per README).
- **No plugin `config` fields (Informational):** intentional — element on/off lives in the YOOtheme customizer, so a zero‑config Joomla plugin is the right call. Confirmed.

---

## 4. YOOtheme Pro extension best practices

- **`bootstrap.php` return structure (good).** The `theme` / `events` / `extend` array and `Path::get(...)` usage are idiomatic. `customizer.init` and `StylerConfig` event wiring follow YOOtheme conventions. The `Builder::class` extender correctly registers element JSON paths.
- **`element.json` schemas (good).** Fields use `enable`/`show` expressions, sensible `defaults`, `${builder.*}` references for shared field groups, and `updates` for migrations. Validation/defaults look complete; deprecated props are handled via `updates`.
- **Render guards (good, consistent).** Every element's `render` transform returns a boolean "has content" check (e.g. lottie `path != ''`, counter text/number/percentage, slideshow‑grid_item display gating). Empty‑state handling is consistent across all 8 elements.
- **Asset registration via `Metadata` (good, minor note).** Scripts/styles are registered in the `render` transform with stable keys (`script:builder-hd-…`), so multiple instances on one page **dedupe** correctly (keyed `set`, not append). `defer => true` is set on scripts. Styles are registered without `defer` (correct for CSS). One inconsistency: the lottie **`content.php`** path bypasses `Metadata` entirely and inlines a CDN `<script>` (see §1.3) — align it with the `render` path.
- **Customizer / Styler integration (good).** `SettingsListener` adds `customizer.json`; `StyleListener` flips a `recompile-style` flag once to force LESS recompilation on install. The `hd-timeline.less` integrates with the style customizer via `@hd-timeline-*` variable groups declared in `customizer.json` → `styler.components`. Coherent.
- **Core alignment (good).** Timeline/flipcard/slideshow‑grid templates reuse the YOOtheme Grid/Panel/Slideshow link/lightbox/image patterns (`$this->el('image', …)`, `striptags`, `uk-link-toggle`, focal point, `uk-scroll`/`uk-toggle` for modals). Deviations are limited to genuinely new behavior (timeline line/icon CSS, flipcard flip JS, image‑comparison slider, lottie). No incorrect divergence from core escaping/link patterns found.

---

## 5. Testing, CI & operational hygiene

### 5.1 No automated tests — **Low (recommend)**

Highest‑value, lowest‑friction targets (pure functions, no Joomla/YOOtheme runtime needed if lightly refactored):

1. **Slideshow‑grid tag parsing** (`element.php` render transform): given `props['tags']`, assert dedupe, `strip_tags`, space→dash slug, `natsort`, and `filter_reverse`. This is the most logic‑dense first‑party transform.
2. **Lottie path handling** (`template.php` `realpath`/prefix decision) — extract the "compute data‑animation‑path" into a testable helper and unit‑test local vs URL vs missing.
3. **Bootstrap early‑exit / element registry** (`bootstrap.php` extend closure): with a fake config, assert which `element.json` paths are registered (all‑on default vs partial selection vs parent→child mapping).
4. **JS:** the `countUp` math and `slideOnMousemove` ratio math are unit‑testable with jsdom.

### 5.2 Static analysis — **Low (recommend)**

- **PHP:** add PHPStan (or Psalm) — even level 4–5 would catch the `array` vs `ArrayAccess` prop access and undefined‑key risks in templates. Add PHPCS with the **Joomla Coding Standards** ruleset; it would have flagged the short‑open‑tags in `hd-progress/template.php` (§1.3/code‑quality) and brace/spacing inconsistencies.
- **CodeQL** currently scans **JavaScript only**. Add the `php` language to the matrix (CodeQL supports PHP) for first‑party PHP coverage.

### 5.3 CI workflow & Dependabot — **Low**

```40:59:.github/workflows/codeql-analysis.yml
    - uses: actions/checkout@v3
    - uses: github/codeql-action/init@v2
    …
    - uses: github/codeql-action/autobuild@v2
```

- **Dated action versions.** `actions/checkout@v3` → `@v4`, `github/codeql-action/*@v2` → `@v3` (v2 is deprecated on GitHub‑hosted runners). Bump these.
- **`autobuild` is pointless** for an interpreted (JS/PHP) project — remove the Autobuild step.
- **Dependabot is misconfigured (`dependabot.yml`):** it watches the `npm` ecosystem in `/`, but there is **no `package.json`** in the repo, so it does nothing. Either (a) add a `package.json`/lockfile that pins `lottie-web` (then Dependabot actually tracks the vendored dependency — ties into §1.6) and/or (b) add a `github-actions` ecosystem entry so the workflow action versions above get automatic update PRs.

### 5.4 `SECURITY.md` vs current version — **Low**

```7:10:SECURITY.md
| Version | Supported          |
| 1.8.x   | :white_check_mark: |
| < 1.8   | :x:                |
```

Current release is **1.9.3**, but the policy still lists `1.8.x` as the supported line and does not mention `1.9.x`. Update the supported‑versions table to reflect `1.9.x` (and whatever the maintained floor is).

---

## 6. Findings index (by severity)

| # | Severity | Area | File | Summary |
|---|----------|------|------|---------|
| 1.3 | **Medium** | Security / supply chain | `hd-lottie/templates/content.php` | Remote CDN `lottie` load + raw `path` interpolated into inline `<script>`; diverges from bundled/SRI‑pinned render path. Use bundled asset + `json_encode`. |
| 1.3b | **Medium** | Correctness/portability | `hd-progress/templates/template.php` | Uses PHP short open tags `<? … ?>` (8 occurrences); breaks when `short_open_tag=Off`. Convert to `<?php`. |
| 3.1 | **Medium** | Joomla 6 readiness | `herzogdupont.php` + manifest | Legacy `CMSPlugin`/`onAfterInitialise`; migrate to `SubscriberInterface` + `src/Extension/` + `services/provider.php` + `$allowLegacyListeners=false` + manifest `<namespace>`. |
| 1.2 | Low / Accepted | Security (path) | `hd-lottie/templates/template.php` | `realpath()` truthiness + `/` prefix uses CWD; client‑side fetch only. Author‑controlled by design. |
| 1.5 / 2.4 | Low | JS leaks/perf | lottie / image‑comparison / flipcard JS | Uncleaned, unthrottled scroll/resize listeners; add `passive`/`rAF`, store handlers. |
| 1.6 | Low | Supply chain | `hd-lottie/app/lottie.min.js` | `lottie-web` 5.13.0 vendored without manifest pin; document update policy. |
| 1.7 | Low | Installer | `script.php` | Silent `catch`/swallow on auto‑enable; `simplexml_load_file` without `is_file`; `Log::add` vs `enqueueMessage`. |
| 2.1 | Low | PHP modernization | first‑party PHP | Add `declare(strict_types=1)` to non‑element files; fill or drop empty lifecycle stubs (esp. `uninstall` config cleanup). |
| 2.2 | Low | DRY | `template-link*.php` ×4 | ~80% duplicate link builders; extract one prefix‑parameterized partial. |
| 2.3 | Low | Maintainability | `bootstrap.php` | Hardcoded `hd-timeline`/`hd-slideshow-grid` child registration; use a registry/convention. |
| 2.4 | Low | JS robustness | `hd-image-comparison.js` | Brittle `uk-icon` string parse; read `data-width` instead. |
| 3.2 | Low | Manifest | `herzogdupont.xml` | Add `minimumPhp`/`minimumJoomla`/`namespace`/`targetplatform`; align JVERSION floor with Joomla 6 target. |
| 3.3 | Low | Joomla hygiene | repo | Missing per‑dir `index.html`; harmonize GPL header wording. |
| 5.1–5.3 | Low | CI/tests | workflows / dependabot | Add PHP CodeQL + PHPStan/PHPCS; bump `checkout@v4`/`codeql-action@v3`; drop `autobuild`; fix Dependabot (no `package.json`; add `github-actions`). |
| 5.4 | Low | Ops | `SECURITY.md` | Supported versions list (1.8.x) is stale vs 1.9.3. |
| 1.1 / 1.4 / 1.8 / 1.9 | Informational | Security | bootstrap / slideshow‑grid / guards / privilege | Early‑exit correct; filter selector escaping mirrors core; `_JEXEC` coverage adequate; no extra privilege surface. Confirmed safe. |

---

## 7. Suggested remediation order

1. **`hd-progress/template.php` short tags → `<?php`** (trivial, prevents hard failures on `short_open_tag=Off`).
2. **`hd-lottie/content.php`**: drop CDN, reuse bundled asset, `json_encode($path)`/`json_encode($loop)`.
3. **Joomla 6 plugin migration** (`SubscriberInterface` + PSR‑4 + `services/provider.php` + manifest `namespace`/minimums). Behavior‑preserving.
4. **Installer hardening** (`is_file` guard, log instead of swallow, `enqueueMessage`, `uninstall` cleanup).
5. **DRY pass** on `template-link*.php` and the `bootstrap.php` child registry.
6. **JS listener hygiene** (passive/throttled, removable handlers; `data-width` in image‑comparison).
7. **CI/ops**: PHP static analysis + CodeQL PHP, action version bumps, Dependabot fix, `SECURITY.md` refresh, `package.json` pin for `lottie-web`.

> Items 1, 2, 4, 6, 7 are low‑risk and independently shippable. Item 3 is the largest change but is purely structural (no runtime behavior change) and is the key gate for Joomla 6.
