<?php

/* Herzog Dupont Copyright (C) 2018–2021 Thomas Weidlich GNU GPL v3 */

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

	'class' => [
		'uk-{btn_style: link-(muted|text)}',
		'uk-button uk-button-{!btn_style: |link-muted|link-text} [uk-button-{btn_size}] [uk-width-1-1 {@btn_fullwidth}]',
	],

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

?>

<?= $el($props, $attrs) ?>

	<?php if ($props['content']) : ?>
		<div class="uk-margin"><?= $props['content'] ?></div>
	<?php endif ?>
	
	<div class="uk-margin">

		<?= $button($props) ?>

			<?php if ($props['icon_align'] == 'left' && $props['icon']) : ?>
				<span uk-icon="<?= $props['icon'] ?>"></span>
			<?php endif ?>

			<span class="uk-text-middle"><?= $props['btn_label'] ?></span>

			<?php if ($props['icon_align'] == 'right' && $props['icon']) : ?>
				<span uk-icon="<?= $props['icon'] ?>"></span>
			<?php endif ?>

		<?= $button->end() ?>

	</div>

	<?php if ($props['content2']) : ?>
		<div <?= ($uniqid != '') ? 'id="' . $uniqid . '"' : '' ?> class="uk-margin" <?= $ishidden; ?>><?= $props['content2'] ?></div>
	<?php endif ?>

</div>
