<?php

// Timeline icon
if ($props['timeline_icon']) {

    $timeline_icon = $this->el('span', [

        'class' => [
            'el-timeline-icon',
            'uk-text-{timeline_icon_color}',
        ],

        'uk-icon' => [
            'icon: {0};' => $props['timeline_icon'],
            'width: {timeline_icon_width};',
            'height: {timeline_icon_width};',
        ],

        'style' => [
            'background-color: {timeline_icon_background};',
            'border-color: {timeline_icon_border};',
        ],

    ]);

    echo $timeline_icon($element, '');

} else {

    $timeline_icon = $this->el('span', [

        'class' => [
            'el-timeline-icon',
            'uk-text-{timeline_icon_color}',
            'timeline-icon-default',
        ],

        'style' => [
            'background-color: {timeline_icon_background};',
            'border-color: {timeline_icon_border};',
        ],

    ]);

    echo $timeline_icon($element, '');

}
