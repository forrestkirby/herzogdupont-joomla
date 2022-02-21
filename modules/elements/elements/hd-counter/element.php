<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019–2022 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [

	'transforms' => [

		'render' => function ($node) {

			/**
			 * @var Metadata $metadata
			 */
			$metadata = app(Metadata::class);

			$metadata->set('style:builder-hd-counter', ['href' => Path::get('./css/hd-counter.css')]);
			$metadata->set('script:builder-hd-counter', ['src' => Path::get('./js/hd-counter.js'), 'defer' => true]);

            // Don't render element if content fields are empty
            return Str::length($node->props['text']) || $node->props['number'] || ($node->props['percentage'] && $node->props['duration']);

		},

	],

	'updates' => [

        '2.0.9' => function ($node) {

            if (!isset($node->props['separator_locale'])) {
                $node->props['separator_locale'] = "";
            }

        }

	],

];
