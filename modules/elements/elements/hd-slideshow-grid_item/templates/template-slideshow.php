<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2024 YOOtheme GmbH, 2021-2024 Thomas Weidlich GNU GPL v3 */

$has_image = $props['image_1'] || $props['image_2'] || $props['image_3'] || $props['video_1'] || $props['video_2'] || $props['video_3'];

// Slideshow
if ($has_image) {

    $el = $this->el('div', [

        'class' => [
            'uk-margin[-{image_margin}]-top {@!image_margin: remove}' => $element['image_align'] == 'between' || ($element['image_align'] == 'bottom' && !($element['panel_style'] && $element['panel_image_no_padding'])),
        ],

        'uk-slideshow' => $this->expr([
            'ratio: {slideshow_ratio};',
            'minHeight: {slideshow_min_height};',
            'maxHeight: {slideshow_max_height};',
            'animation: {slideshow_animation};',
            'velocity: {slideshow_velocity};',
            'autoplay: {slideshow_autoplay}; [pauseOnHover: false; {!slideshow_autoplay_pause}; ] [autoplayInterval: {slideshow_autoplay_interval}000;]',
        ], $element) ?: true,

    ]);

    // Container
    $container = $this->el('div', [

        'class' => [
            'uk-position-relative',
            'uk-visible-toggle {@slidenav} {@slidenav_hover}',
        ],

        'tabindex' => ['-1 {@slidenav} {@slidenav_hover}'],

    ]);

    // Items
    $items = $this->el('ul', [

        'class' => [
            'uk-slideshow-items',
            'uk-box-shadow-{image_box_shadow} {@!panel_style}',
        ],

    ]);

    // Extra effect for pull/push
    $opacity = $element['text_color'] === 'light' ? '0.5' : '0.2';

    $pull_push = $this->el('div', [

        'class' => [
            'uk-position-cover',
        ],

        'uk-slideshow-parallax' => $element['slideshow_animation'] == 'push'
            ? 'scale: 1.2,1.2,1'
            : 'scale: 1,1.2,1.2',
    ]);

    // Kenburns
    $kenburns_alternate = [
        'center-left',
        'top-right',
        'bottom-left',
        'top-center',
        '', // center-center
        'bottom-right',
    ];

    $kenburns = $this->el('div', [

        'class' => [
            'uk-position-cover uk-animation-kenburns uk-animation-reverse',
            'uk-transform-origin-{0}' => $element['slideshow_kenburns'] == 'alternate'
                ? $kenburns_alternate[$i % count($kenburns_alternate)]
                : ($element['slideshow_kenburns'] == 'center-center'
                    ? ''
                    : $element['slideshow_kenburns']),
        ],

        'style' => [
            '-webkit-animation-duration: {slideshow_kenburns_duration}s;',
            'animation-duration: {slideshow_kenburns_duration}s;',
        ],

    ]);

    // Image 1
    $image_1 = $this->el('image', [

        'class' => [
            'el-image',
        ],

        'src' => $props['image_1'],
        'alt' => $props['image_1_alt'],
        'loading' => $element['image_loading'] ? false : null,
        'width' => $element['image_width'],
        'height' => $element['image_height'],
        'focal_point' => $props['image_1_focal_point'],
        'uk-cover' => true,
        'thumbnail' => true,
    ]);

    // Video 1
    if ($iframe = $this->iframeVideo($props['video_1'])) {

        $video_1 = $this->el('iframe', [

            'class' => [
                'uk-disabled',
            ],

            'src' => $iframe,
            'frameborder' => '0',

        ]);

    } else {

        $video_1 = $this->el('video', [

            'src' => $props['video_1'],
            'controls' => false,
            'loop' => true,
            'autoplay' => true,
            'muted' => true,
            'playsinline' => true,

        ]);

    }

    $video_1->attr([

        'width' => $element['image_width'],
        'height' => $element['image_height'],

        'class' => ['el-image'],

        'uk-cover' => true,

    ]);

    // Image 2
    $image_2 = $this->el('image', [

        'class' => [
            'el-image',
        ],

        'src' => $props['image_2'],
        'alt' => $props['image_2_alt'],
        'loading' => $element['image_loading'] ? false : null,
        'width' => $element['image_width'],
        'height' => $element['image_height'],
        'focal_point' => $props['image_2_focal_point'],
        'uk-cover' => true,
        'thumbnail' => true,
    ]);

    // Video 2
    if ($iframe = $this->iframeVideo($props['video_2'])) {

        $video_2 = $this->el('iframe', [

            'class' => [
                'uk-disabled',
            ],

            'src' => $iframe,
            'frameborder' => '0',

        ]);

    } else {

        $video_2 = $this->el('video', [

            'src' => $props['video_2'],
            'controls' => false,
            'loop' => true,
            'autoplay' => true,
            'muted' => true,
            'playsinline' => true,

        ]);

    }

    $video_2->attr([

        'width' => $element['image_width'],
        'height' => $element['image_height'],

        'class' => ['el-image'],

        'uk-cover' => true,

    ]);

    // Image 3
    $image_3 = $this->el('image', [

        'class' => [
            'el-image',
        ],

        'src' => $props['image_3'],
        'alt' => $props['image_3_alt'],
        'loading' => $element['image_loading'] ? false : null,
        'width' => $element['image_width'],
        'height' => $element['image_height'],
        'focal_point' => $props['image_3_focal_point'],
        'uk-cover' => true,
        'thumbnail' => true,
    ]);

    // Video 3
    if ($iframe = $this->iframeVideo($props['video_3'])) {

        $video_3 = $this->el('iframe', [

            'class' => [
                'uk-disabled',
            ],

            'src' => $iframe,
            'frameborder' => '0',

        ]);

    } else {

        $video_3 = $this->el('video', [

            'src' => $props['video_3'],
            'controls' => false,
            'loop' => true,
            'autoplay' => true,
            'muted' => true,
            'playsinline' => true,

        ]);

    }

    $video_3->attr([

        'width' => $element['image_width'],
        'height' => $element['image_height'],

        'class' => ['el-image'],

        'uk-cover' => true,

    ]);

    // Image 4
    $image_4 = $this->el('image', [

        'class' => [
            'el-image',
        ],

        'src' => $props['image_4'],
        'alt' => $props['image_4_alt'],
        'loading' => $element['image_loading'] ? false : null,
        'width' => $element['image_width'],
        'height' => $element['image_height'],
        'focal_point' => $props['image_4_focal_point'],
        'uk-cover' => true,
        'thumbnail' => true,
    ]);

    // Video 4
    if ($iframe = $this->iframeVideo($props['video_4'])) {

        $video_4 = $this->el('iframe', [

            'class' => [
                'uk-disabled',
            ],

            'src' => $iframe,
            'frameborder' => '0',

        ]);

    } else {

        $video_4 = $this->el('video', [

            'src' => $props['video_4'],
            'controls' => false,
            'loop' => true,
            'autoplay' => true,
            'muted' => true,
            'playsinline' => true,

        ]);

    }

    $video_4->attr([

        'width' => $element['image_width'],
        'height' => $element['image_height'],

        'class' => ['el-image'],

        'uk-cover' => true,

    ]);

}

?>

<?php if ($has_image) : ?>

<?= $el($element) ?>

    <?= $container($element) ?>

            <?= $items($element) ?>

                <?php if ($props['image_1'] || $props['video_1']) : ?>
                <li>

                    <?php if (in_array($element['slideshow_animation'], ['push', 'pull'])) : ?>
                    <?= $pull_push($element) ?>
                    <?php endif ?>

                        <?php if ($element['slideshow_kenburns']) : ?>
                        <?= $kenburns($element) ?>
                        <?php endif ?>

                            <?= $props['image_1'] ? $image_1() : '' ?>
                            <?= $props['video_1'] && !$props['image_1'] ? $video_1([], '') : '' ?>

                        <?php if ($element['slideshow_kenburns']) : ?>
                        </div>
                        <?php endif ?>

                    <?php if (in_array($element['slideshow_animation'], ['push', 'pull'])) : ?>
                    </div>
                    <?php endif ?>

                </li>
                <?php endif ?>

                <?php if ($props['image_2'] || $props['video_2']) : ?>
                <li>
                    
                    <?php if (in_array($element['slideshow_animation'], ['push', 'pull'])) : ?>
                    <?= $pull_push($element) ?>
                    <?php endif ?>

                        <?php if ($element['slideshow_kenburns']) : ?>
                        <?= $kenburns($element) ?>
                        <?php endif ?>

                            <?= $props['image_2'] ? $image_2() : '' ?>
                            <?= $props['video_2'] && !$props['image_2'] ? $video_2([], '') : '' ?>

                        <?php if ($element['slideshow_kenburns']) : ?>
                        </div>
                        <?php endif ?>

                    <?php if (in_array($element['slideshow_animation'], ['push', 'pull'])) : ?>
                    </div>
                    <?php endif ?>

                </li>
                <?php endif ?>

                <?php if ($props['image_3'] || $props['video_3']) : ?>
                <li>
                    
                    <?php if (in_array($element['slideshow_animation'], ['push', 'pull'])) : ?>
                    <?= $pull_push($element) ?>
                    <?php endif ?>

                        <?php if ($element['slideshow_kenburns']) : ?>
                        <?= $kenburns($element) ?>
                        <?php endif ?>

                            <?= $props['image_3'] ? $image_3() : '' ?>
                            <?= $props['video_3'] && !$props['image_3'] ? $video_3([], '') : '' ?>

                        <?php if ($element['slideshow_kenburns']) : ?>
                        </div>
                        <?php endif ?>

                    <?php if (in_array($element['slideshow_animation'], ['push', 'pull'])) : ?>
                    </div>
                    <?php endif ?>

                </li>
                <?php endif ?>

                <?php if ($props['image_4'] || $props['video_4']) : ?>
                <li>
                    
                    <?php if (in_array($element['slideshow_animation'], ['push', 'pull'])) : ?>
                    <?= $pull_push($element) ?>
                    <?php endif ?>

                        <?php if ($element['slideshow_kenburns']) : ?>
                        <?= $kenburns($element) ?>
                        <?php endif ?>

                            <?= $props['image_4'] ? $image_4() : '' ?>
                            <?= $props['video_4'] && !$props['image_4'] ? $video_4([], '') : '' ?>

                        <?php if ($element['slideshow_kenburns']) : ?>
                        </div>
                        <?php endif ?>

                    <?php if (in_array($element['slideshow_animation'], ['push', 'pull'])) : ?>
                    </div>
                    <?php endif ?>

                </li>
                <?php endif ?>

            </ul>

        <?php if ($element['slidenav']) : ?>
        <?= $this->render("{$__dir}/template-slidenav") ?>
        <?php endif ?>

        <?php if ($element['nav'] && !$element['nav_below']) : ?>
        <?= $this->render("{$__dir}/template-nav") ?>
        <?php endif ?>

    </div>

    <?php if ($element['nav'] && $element['nav_below']): ?>
    <?= $this->render("{$__dir}/template-nav") ?>
    <?php endif ?>

</div>

<?php endif ?>
