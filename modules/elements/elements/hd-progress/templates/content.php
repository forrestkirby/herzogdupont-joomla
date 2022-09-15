<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2018–2022 Thomas Weidlich GNU GPL v3 */

if ($props['content']) : ?>
<div><?= $props['content'] ?></div>
<?php endif ?>
<progress value="<?= $props['stop'] ?>" max="<?= $props['max'] ?>"><?= $props['stop'] ?>/<?= $props['max'] ?></progress>
