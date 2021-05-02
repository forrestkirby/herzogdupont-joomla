<?php

/* Herzog Dupont Copyright (C) 2018–2021 Thomas Weidlich GNU GPL v3 */

$el = $this->el('div', [

	'class' => [
		'hd-progess',
	],

]);

?>

<?= $el($props, $attrs) ?>

	<div class="uk-margin"><?= $props['content'] ?></div>

	<div class="uk-margin">
		<progress class="uk-progress" value="<?= $props['value'] ?>" max="<?= $props['max'] ?>" data-stop="<?= $props['stop'] ?>" data-step="<?= $props['animation_step'] ?>" data-speed="<?= $props['animation_speed'] ?>"><?= $props['stop'] ?>/<?= $props['max'] ?></progress>
	</div>

</div>
