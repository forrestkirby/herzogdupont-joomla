<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019–2022 Thomas Weidlich GNU GPL v3 */

if ($props['path']) : ?>
<?php
	$uniqid = uniqid('hd-');
	$loop = $props['loop'] == true ? true : false;
	$path = $props['path'];
?>
<?php if ($props['link']) : ?>
<a href="<?= $props['link'] ?>">
<?php endif ?>
	<div id="<?= $uniqid ?>"></div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.2/lottie.min.js" integrity="sha512-R47oG09eydaf225nXyDdSWJ8frKwxkC7QIHXdPpbUx9KaAiC6akjpWxTBw1hb7whk7P2sJNuRhS2ljSBegnIPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php if ($props['link']) : ?>
</a>
<?php endif ?>
<script>
lottie.loadAnimation({
	container: document.getElementById('<?= $uniqid ?>'),
	renderer: 'svg',
	loop: <?= $loop ?>,
	autoplay: true,
	path: <?= "'" . $path . "'" ?>
});
</script>
<?php endif ?>
