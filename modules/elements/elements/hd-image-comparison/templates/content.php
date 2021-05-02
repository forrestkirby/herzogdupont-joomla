<?php

/* Herzog Dupont Copyright (C) 2020–2021 Thomas Weidlich GNU GPL v3 */

if ($props['image_before']) : ?>
<img src="<?= $props['image_before'] ?>" alt="<?= $props['image_before_alt'] ?>">
<?php endif ?>
<?php if ($props['image_after']) : ?>
<img src="<?= $props['image_after'] ?>" alt="<?= $props['image_after_alt'] ?>">
<?php endif ?>