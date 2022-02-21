<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019–2022 Thomas Weidlich GNU GPL v3 */

if ($props['path']) : ?>
<?php
	$uniqid = uniqid('hd-');
	$loop = $props['loop'] == true ? true : false;
	$path = isset($props['path']) ? $props['path'] : 'http://localhost/fuse/plugins/system/herzogdupont/modules/elements/elements/hd-lottie/assets/demo.json';
?>
<?php if ($props['link']) : ?>
<a href="<?= $props['link'] ?>">
<?php endif ?>
	<div id="<?= $uniqid ?>"></div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.13/lottie.min.js" integrity="sha512-srGxQe2w7s50+5/nNgEVKYtBm15zRylJwdjxYnGEZr3mmHFJKFjA/ImA2OKizVzoIDX8XISMHDI1+az9pnumbQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
