<?php if ($props['number']) : ?>
<div>
	<?= $props['number'] ?><?= $props['unit'] ? ' ' . $props['unit'] : '' ?><?= $props['text'] ? ' ' . $props['text'] : '' ?>
</div>
<?php endif ?>
