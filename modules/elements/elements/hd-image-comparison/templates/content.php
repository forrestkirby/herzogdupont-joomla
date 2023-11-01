<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2020-2023 Thomas Weidlich GNU GPL v3 */

if ($props['image_before']) : ?>
<figure>
	<img src="<?= $props['image_before'] ?>" alt="<?= $props['image_before_alt'] ?>">
	<figcaption><?= $props['$image_before_label'] ?></figcaption>
</figure>
<?php endif ?>
<?php if ($props['image_after']) : ?>
<figure>
	<img src="<?= $props['image_after'] ?>" alt="<?= $props['image_after_alt'] ?>">
	<figcaption><?= $props['$image_after_label'] ?></figcaption>
</figure>
<?php endif ?>