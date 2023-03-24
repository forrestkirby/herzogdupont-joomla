<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2022 Thomas Weidlich GNU GPL v3 */

if ($props['number']) : ?>
<div>
    <?= $props['prefix'] ? $props['prefix'] : '' ?><?= !$props['prefix_space_remove'] ? '&#x00A0;' : '' ?><?= $props['number'] ?><?= !$props['unit_space_remove'] ? '&#x00A0;' : '' ?><?= $props['unit'] ? $props['unit'] : '' ?><?= $props['text'] ? ' ' . $props['text'] : '' ?>
</div>
<?php endif ?>
