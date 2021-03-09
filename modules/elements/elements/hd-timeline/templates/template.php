<?php

// Resets
if ($props['panel_link']) {
    $props['title_link'] = '';
    $props['image_link'] = '';
}

$el = $this->el('div', [

    'class' => [
        'timeline-container',
        'timeline-align-{align_default}',
        'timeline-align-{align_small}@s',
        'timeline-align-{align_medium}@m',
        'timeline-align-{align_large}@l',
        'timeline-align-{align_xlarge}@xl',
    ]

]);

$line = $this->el('div', [

    'class' => [
        'timeline-line',
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
