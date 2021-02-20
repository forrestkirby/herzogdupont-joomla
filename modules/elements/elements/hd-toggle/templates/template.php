<?php

$el = $this->el('div', [

	//

]);

if ($props['content2'] || $props['target'] == 'false' || $props['target'] == '') {
	$uniqid = uniqid('toggle-');
	$target = '#' . $uniqid;
} else {
	$uniqid = '';
	$target = $props['target'];
}
$ishidden = $props['hidden'] ? 'hidden' : '' ;
$cls = ( $props['hidden'] && $props['content2'] || $props['cls'] == '' ) ? 'false' : $props['cls'];
if ($props['toggle_animation_use_advanced']) {
	$animation = $props['toggle_animation_advanced'];
} elseif ($props['toggle_animation'] == 'false') {
	$animation = $props['toggle_animation'];
} else {
	$animation = 'uk-animation-' . $props['toggle_animation'];
}
($props['queued']) ? $queued = 'true' : $queued = 'false';

?>

<?= $el($props, $attrs) ?>

	<?php if ($props['content']) : ?>
		<div class="uk-margin"><?= $props['content'] ?></div>
	<?php endif ?>
	<div class="uk-margin">
		<button class="uk-button <?= $props['btn_style'] ?> <?= $props['btn_size'] ?>" type="button" uk-toggle="target: <?= $target ?>; mode: <?= $props['mode'] ?>; cls: <?= $cls; ?>; media: <?= $props['media'] ?>; animation: <?= $animation ?>; duration: <?= $props['duration'] ?>; queued: <?= $queued ?>">

			<?php if ($props['icon_align'] == 'left' && $props['icon']) : ?>
				<span uk-icon="<?= $props['icon'] ?>"></span>
			<?php endif ?>

			<span class="uk-text-middle"><?= $props['btn_label'] ?></span>

			<?php if ($props['icon_align'] == 'right' && $props['icon']) : ?>
				<span uk-icon="<?= $props['icon'] ?>"></span>
			<?php endif ?>

			</button>
	</div>
	<?php if ($props['content2']) : ?>
		<div <?= ($uniqid != '') ? 'id="' . $uniqid . '"' : '' ?> class="uk-margin" <?= $ishidden; ?>><?= $props['content2'] ?></div>
	<?php endif ?>

</div>
