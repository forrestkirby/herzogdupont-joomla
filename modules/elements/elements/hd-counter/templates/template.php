<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2025 Thomas Weidlich GNU GPL v3 */

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

$textEl = $this->el('span', [

    'class' => [
        'el-text',
        'uk-{text_style}',
        'uk-text-{text_color}',
    ],

]);

$numberEl = $this->el('span', [

    'class' => [
        'el-number',
        'uk-{number_size}',
        'uk-text-{number_color}',
    ],

]);

$unitEl = $this->el('span', [

    'class' => [
        'el-unit',
        'uk-{number_size} {@unit_size: number-size}',
        'uk-{unit_size} {@!unit_size: number-size}',
        'uk-text-{number_color}',
    ],

]);

// Prepare number and unit parts
$number_part = $props['number'] ? $numberEl($props, $props['number']) : '';
$unit_part = $props['unit'] ? $unitEl($props, ' ' . $props['unit']) : ''; // Add space conditionally later

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

            <div class="uk-position-center uk-overlay">
                <?php // Conditionally render unit and number based on unit_position_before
                if ($props['unit_position_before'] && $props['unit']) {
                    echo $unitEl($props, $props['unit']); // Unit first, no space
                    echo $number_part;
                } elseif ($props['number']) {
                    echo $number_part;
                    if ($props['unit']) {
                        echo $unitEl($props, ' ' . $props['unit']); // Number first, add space before unit
                    }
                }
                ?>
                <?php if ($props['text']) : ?><?= $textEl($props) ?><?= '<br>' ?><?= $props['text'] ?></span><?php endif ?>
            </div>

        </div>

    <?php else : ?>

        <div>
            <?php // Conditionally render unit and number based on unit_position_before
            if ($props['unit_position_before'] && $props['unit']) {
                echo $unitEl($props, $props['unit'] . ' '); // Unit first, add space after
                echo $number_part;
            } elseif ($props['number']) {
                echo $number_part;
                if ($props['unit']) {
                    echo $unitEl($props, ' ' . $props['unit']); // Number first, add space before unit
                }
            }
            ?>
            <?php if ($props['text']) : ?><?= $textEl($props) ?><?= '<br>' ?><?= $props['text'] ?></span><?php endif ?>
        </div>

    <?php endif; ?>

</div>