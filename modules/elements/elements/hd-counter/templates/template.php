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

// Prepare number and unit parts - Refactored
$number_html = $props['number'] ? $numberEl($props, $props['number']) : '';
$unit_html = $props['unit'] ? $unitEl($props, $props['unit']) : '';
$number_unit_output = '';
$use_space = !empty($props['unit_space']); // Check the new option (assuming it's boolean)

if ($props['unit_position_before'] && $unit_html) {
    // Unit first
    $number_unit_output = $unit_html;
    if ($number_html) {
        $number_unit_output .= ($use_space ? ' ' : '') . $number_html;
    }
} elseif ($number_html) {
    // Number first
    $number_unit_output = $number_html;
    if ($unit_html) {
        $number_unit_output .= ($use_space ? ' ' : '') . $unit_html;
    }
} elseif ($unit_html) {
    // Only unit
    $number_unit_output = $unit_html;
}

// Prepare text part
$text_output = $props['text'] ? $textEl($props) . '<br>' . $props['text'] . '</span>' : '';

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
                echo $number_unit_output;
                ?>
                <?php if ($text_output) : ?><?= $text_output ?><?php endif ?>
            </div>

        </div>

    <?php else : ?>

        <div>
            <?php // Conditionally render unit and number based on unit_position_before
            echo $number_unit_output;
            ?>
            <?php if ($text_output) : ?><?= $text_output ?><?php endif ?>
        </div>

    <?php endif; ?>

</div>