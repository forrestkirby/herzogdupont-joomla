<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2025 YOOtheme GmbH, 2019-2025 Thomas Weidlich GNU GPL v3 */

// Resets
if ($props['panel_link']) {
    $props['title_link'] = '';
    $props['image_link'] = '';
}

$el = $this->el('div', [

    'class' => [
        'hd-timeline-container',
        'hd-timeline-align-{align_default}',
        'hd-timeline-align-{align_small}@s',
        'hd-timeline-align-{align_medium}@m',
        'hd-timeline-align-{align_large}@l',
        'hd-timeline-align-{align_xlarge}@xl',
    ],

]);

$line = $this->el('div', [

    'class' => [
        'hd-timeline-line',
    ],

    'style' => [
        'background-color: {line_color};',
    ],

]);

?>

<?= $el($props, $attrs) ?>

    <?= $line($props) ?></div>

    <?php foreach ($children as $child) : ?>
    <div><?= $builder->render($child, ['element' => $props]) ?></div>
    <?php endforeach ?>

</div>
