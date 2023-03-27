<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2022 Thomas Weidlich GNU GPL v3 */

$cx = $cy = $props['circle_radius'] * 1.1;
$circleWidth = $circleHeight = $cx * 2;
$viewBox = '0 0 ' . $circleWidth . ' ' . $circleWidth;
$uniqid = uniqid('counter-');
$dashOffsetStart = 2 * M_PI * $props['circle_radius'];
$dashOffsetEnd = 2 * M_PI * $props['circle_radius'] * (1 - intval($props['percentage']) / 100);

$el = $this->el('div', [

    'class' => [
        'counter-container',
    ],

    'data-number' => [
        '{number}',
    ],

    'data-separator-locale' => [
        '{separator_locale}',
    ],

    'data-percentage' => [
        '{percentage}',
    ],

    'data-radius' => [
        '{circle_radius}',
    ],

    'data-duration' => [
        '{duration}',
    ],

    'data-uniqid' => [
        $uniqid,
    ],

]);

$svg = $this->el('svg', [

    'class' => [
        'el-circle',
    ],

    'width' => [
        $circleWidth,
    ],

    'height' => [
        $circleHeight,
    ],

    'viewBox' => [
        $viewBox,
    ],

]);

$textEl = $this->el('div', [

    'class' => [
        'el-text',
        'uk-{text_style}',
        'uk-text-{text_color}',
        'uk-margin-remove',
    ],

]);

$prefixEl = $this->el('div', [

    'class' => [
        'el-prefix',
        'uk-{number_size} {@prefix_size: number-size}',
        'uk-{prefix_size} {@!prefix_size: number-size}',
        'uk-text-{number_color}',
        'uk-margin-remove',
    ],

]);

$numberEl = $this->el('div', [

    'class' => [
        'el-number',
        'uk-{number_size}',
        'uk-text-{number_color}',
        'uk-margin-remove',
    ],

]);

$unitEl = $this->el('div', [

    'class' => [
        'el-unit',
        'uk-{number_size} {@unit_size: number-size}',
        'uk-{unit_size} {@!unit_size: number-size}',
        'uk-text-{number_color}',
        'uk-margin-remove',
    ],

]);

?>
<?= $el($props, $attrs) ?>

    <style>
    #<?= $uniqid ?> .counter-value {
        animation: <?= $uniqid ?> <?= $props['duration'] ?>ms;
    }

    @keyframes <?= $uniqid ?> {
        from {
            stroke-dashoffset: <?= $dashOffsetStart ?>;
        }

        to {
            stroke-dashoffset: <?= $dashOffsetEnd ?>;
        }
    }
    </style>

    <?php if($props['show_circle']) : ?>

        <div class="uk-inline">

            <?= $svg($props) ?>
                <circle class="counter-meter" cx="<?= $cx ?>" cy="<?= $cy ?>" r="<?= $props['circle_radius'] ?>" stroke-width="<?= $props['circle_stroke_width'] ?>" fill="none" />
                <circle class="counter-value" cx="<?= $cx ?>" cy="<?= $cy ?>" r="<?= $props['circle_radius'] ?>" stroke="<?= $props['circle_color'] ?>" stroke-width="<?= $props['circle_stroke_width'] ?>" fill="none" />
            </svg>

            <div class="uk-position-center uk-overlay uk-flex">
                <?php if ($props['prefix']) : ?><?= $prefixEl($props) ?><?= $props['prefix'] ?><?= !$props['prefix_space_remove'] ? '&#x00A0;' : '' ?></div><?php endif ?>
                <?php if ($props['number']) : ?><?= $numberEl($props) ?><?= $props['number'] ?></div><?php endif ?>
                <?php if ($props['unit']) : ?><?= $unitEl($props) ?><?= !$props['unit_space_remove'] ? '&#x00A0;' : '' ?><?= $props['unit'] ?></div><?php endif ?>
                <?php if ($props['text']) : ?><?= $textEl($props) ?><?= '<br>' ?><?= $props['text'] ?></div><?php endif ?>
            </div>

        </div>

    <?php else : ?>

        <div class="uk-flex">
            <?php if ($props['prefix']) : ?><?= $prefixEl($props) ?><?= $props['prefix'] ?><?= !$props['prefix_space_remove'] ? '&#x00A0;' : '' ?></div><?php endif ?>
            <?php if ($props['number']) : ?><?= $numberEl($props) ?><?= $props['number'] ?></div><?php endif ?>
            <?php if ($props['unit']) : ?><?= $unitEl($props) ?><?= !$props['unit_space_remove'] ? '&#x00A0;' : '' ?><?= $props['unit'] ?></div><?php endif ?>
            <?php if ($props['text']) : ?><?= $textEl($props) ?><?= '<br>' ?><?= $props['text'] ?></div><?php endif ?>
        </div>

    <?php endif; ?>

</div>
