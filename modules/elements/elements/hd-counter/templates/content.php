<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2023 Thomas Weidlich GNU GPL v3 */

if ($props['number']) : ?>
<div>
    <?= $props['number'] ?><?= $props['unit'] ? ' ' . $props['unit'] : '' ?><?= $props['text'] ? ' ' . $props['text'] : '' ?>
</div>
<?php endif ?>
