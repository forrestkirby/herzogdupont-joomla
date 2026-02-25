<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2026 Thomas Weidlich GNU GPL v3 */

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.13.0/lottie.min.js" integrity="sha512-uOtp2vx2X/5+tLBEf5UoQyqwAkFZJBM5XwGa7BfXDnWR+wdpRvlSVzaIVcRe3tGNsStu6UMDCeXKEnr4IBT8gA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
