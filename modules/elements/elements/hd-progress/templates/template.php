<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2018–2022 Thomas Weidlich GNU GPL v3 */

$uniqid = false;

if ($props['progress_value_color'] || $props['progress_background_color'])
	$uniqid = uniqid('hd-progress-');

$el = $this->el('div', [

	'class' => [
		'hd-progess',
	],

]);

$progress = $this->el('progress', [

	'id' => [
		$uniqid => $uniqid,
	],

	'class' => [
		'uk-progress',
	],

	'value' => [
		'{start}',
	],

	'max' => [
		'{max}',
	],

	'data-stop' => [
		'{stop}',
	],

	'data-step' => [
		'{animation_step}',
	],

	'data-speed' => [
		'{animation_speed}',
	]

]);

?>

<?= $el($props, $attrs) ?>

	<? if ($uniqid) : ?>
	<style>
	<? if ($props['progress_value_color']) : ?>
	#<?= $uniqid ?>.uk-progress::-webkit-progress-value {
		background-color: <?= $props['progress_value_color'] ?>;
	}

	#<?= $uniqid ?>.uk-progress::-moz-progress-bar {
		background-color: <?= $props['progress_value_color'] ?>;
	}

	#<?= $uniqid ?>.uk-progress::-ms-fill {
		background-color: <?= $props['progress_value_color'] ?>;
	}
	<? endif ?>

	<? if ($props['progress_background_color']) : ?>
	#<?= $uniqid ?>.uk-progress {
		background-color: <?= $props['progress_background_color'] ?>;
	}

	#<?= $uniqid ?>.uk-progress::-webkit-progress-bar {
		background-color: <?= $props['progress_background_color'] ?>;
	}
	<? endif ?>
	</style>
	<? endif ?>

	<? if ($props['content']) : ?>
	<div><?= $props['content'] ?></div>
	<? endif ?>

	<?= $progress($props) ?>
		<?= $props['stop'] ?>/<?= $props['max'] ?>
	<?= $progress->end() ?>

</div>
