<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2026 Thomas Weidlich GNU GPL v3 */

if ($props['link']) : ?>
<a href="<?= $this->e($props['link']) ?>"><?= $this->e($props['path'] ?: $props['link']) ?></a>
<?php endif ?>
