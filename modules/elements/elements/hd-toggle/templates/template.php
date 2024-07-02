<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2018-2024 Thomas Weidlich GNU GPL v3 */

$el = $this->el('div', [

    //

]);

if ($props['content2'] || $props['target'] == 'false' || $props['target'] == '') {
    $uniqid = uniqid('toggle-');
    $props['target'] = '#' . $uniqid;
} else {
    $uniqid = '';
}

$ishidden = $props['hidden'] ? 'hidden' : '' ;

$props['cls'] = ( $props['hidden'] && $props['content2'] || $props['cls'] == '' ) ? 'false' : $props['cls'];

if ($props['toggle_animation_use_advanced']) {
    $props['toggle_animation'] = $props['toggle_animation_advanced'];
} elseif ($props['toggle_animation'] == 'false') {
    $props['toggle_animation'] = $props['toggle_animation'];
} else {
    $props['toggle_animation'] = 'uk-animation-' . $props['toggle_animation'];
}

$props['queued'] = $props['queued'] ? true : false;

$button = $this->el('a', [

    'class' => $this->expr([
        'uk-width-1-1 {@btn_fullwidth}',
        'uk-{btn_style: link-\w+}' => ['btn_style' => $props['btn_style']],
        'uk-button uk-button-{!btn_style: |link-\w+} [uk-button-{btn_size}]' => ['btn_style' => $props['btn_style']],
        'uk-flex-inline uk-flex-center uk-flex-middle' => $props['btn_label'] && $props['icon'],
    ], $props),

    'uk-toggle' => [
        'target: {target};',
        'mode: {mode};',
        'cls: {cls};',
        'media: {media};',
        'animation: {toggle_animation};',
        'duration: {duration};',
        'queued: {queued};',
    ],

]);

// Icon
$icon = $this->el('span', [

    'class' => [
        'uk-margin-small-right' => $props['btn_label'] && $props['icon_align'] == 'left',
        'uk-margin-small-left' => $props['btn_label'] && $props['icon_align'] == 'right',
    ],
    'uk-icon' => $props['icon'],

]);

?>

<?= $el($props, $attrs) ?>

    <?php if ($props['content']) : ?>
        <div class="uk-margin"><?= $props['content'] ?></div>
    <?php endif ?>
    
    <div class="uk-margin">

        <?= $button($props) ?>

            <?php if ($props['icon'] && $props['icon_align'] == 'left') : ?>
            <?= $icon($props, '') ?>
            <?php endif ?>

            <?php if ($props['btn_label']) : ?>
            <?= $props['btn_label'] ?>
            <?php endif ?>

            <?php if ($props['icon'] && $props['icon_align'] == 'right') : ?>
            <?= $icon($props, '') ?>
            <?php endif ?>

        <?= $button->end() ?>

    </div>

    <?php if ($props['content2']) : ?>
        <div <?= ($uniqid != '') ? 'id="' . $uniqid . '"' : '' ?> class="uk-margin" <?= $ishidden; ?>><?= $props['content2'] ?></div>
    <?php endif ?>

</div>
