<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2025 YOOtheme GmbH, 2019-2025 Thomas Weidlich GNU GPL v3 */

if ($props['image']) : ?>
<img src="<?= $props['image'] ?>" alt="<?= $props['image_alt'] ?>">
<?php endif ?>

<?php if ($props['title']) : ?>
<<?= $element['title_element'] ?>><?= $props['title'] ?></<?= $element['title_element'] ?>>
<?php endif ?>

<?php if ($props['meta']) : ?>
<p><?= $props['meta'] ?></p>
<?php endif ?>

<?php if ($props['content']) : ?>
<div><?= $props['content'] ?></div>
<?php endif ?>

<?php if ($props['link']) : ?>
<p><a href="<?= $props['link'] ?>"><?= $props['link_text'] ?: $element['link_text'] ?></a></p>
<?php endif ?>