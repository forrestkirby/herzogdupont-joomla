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

// Define Start Unit Element (Renamed from unitEl)
$startUnitEl = $this->el('span', [

    'class' => [
        'el-unit el-unit-start',
        'uk-{number_size} {@unit_start_style: number-size}',
        'uk-{unit_start_style} {@!unit_start_style: number-size}',
        'uk-text-{number_color}',
    ],

]);

$endUnitEl = $this->el('span', [
    'class' => [
        'el-unit el-unit-end',
        'uk-{number_size} {@unit_end_style: number-size}',
        'uk-{unit_end_style} {@!unit_end_style: number-size}',
        'uk-text-{number_color}',
    ],
]);

// Prepare number and unit parts - Refactored for Start and End Units
$number_html = $props['number'] ? $numberEl($props, $props['number']) : '';
$start_unit_html = $props['unit_start'] ? $startUnitEl($props, $props['unit_start']) : '';
$end_unit_html = $props['unit_end'] ? $endUnitEl($props, $props['unit_end']) : '';

$use_start_space = !empty($props['unit_start_space']);
$use_end_space = !empty($props['unit_end_space']);

$output_parts = [];

// Build output: Start Unit -> Number -> End Unit

// Add Start Unit
if ($start_unit_html) {
    $output_parts[] = $start_unit_html;
}

// Add Number
if ($number_html) {
    // Add space before number only if start unit exists AND space is enabled
    if (!empty($output_parts) && $use_start_space) {
        $output_parts[] = ' ';
    }
    $output_parts[] = $number_html;
}

// Add End Unit
if ($end_unit_html) {
    // Add space before end unit only if preceding content exists (start unit or number) AND space is enabled
    if (!empty($output_parts) && $use_end_space) {
        $output_parts[] = ' ';
    }
    $output_parts[] = $end_unit_html;
}

$number_unit_output = implode('', $output_parts);

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
                <?php // Start Unit -> Number -> End Unit
                echo $number_unit_output;
                ?>
                <?php if ($text_output) : ?><?= $text_output ?><?php endif ?>
            </div>

        </div>

    <?php else : ?>

        <div>
            <?php // Start Unit -> Number -> End Unit
            echo $number_unit_output;
            ?>
            <?php if ($text_output) : ?><?= $text_output ?><?php endif ?>
        </div>

    <?php endif; ?>

</div>