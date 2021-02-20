<?php if ($props['image'] || $props['title'] || $props['meta'] || $props['content'] || $props['link']) : ?>
<div>

    <?php if ($props['image']) : ?>
    <img src="<?= $props['image'] ?>" alt="<?= $props['image_alt'] ?>">
    <?php endif ?>

    <?php if ($props['title']) : ?>
    <<?= $props['title_element'] ?>><?= $props['title'] ?></<?= $props['title_element'] ?>>
    <?php endif ?>

    <?php if ($props['meta']) : ?>
    <p><?= $props['meta'] ?></p>
    <?php endif ?>

    <?php if ($props['content']) : ?>
    <div><?= $props['content'] ?></div>
    <?php endif ?>

    <?php if ($props['link_text']) : ?>
    <p><?= $props['link_text'] ?></p>
    <?php endif ?>

</div>
<?php endif ?>

<?php if ($props['image_back'] || $props['title_back'] || $props['meta_back'] || $props['content_back'] || $props['link_back']) : ?>
<div>

    <?php if ($props['image_back']) : ?>
    <img src="<?= $props['image_back'] ?>" alt="<?= $props['image_back_alt'] ?>">
    <?php endif ?>

    <?php if ($props['title_back']) : ?>
    <<?= $props['title_back_element'] ?>><?= $props['title_back'] ?></<?= $props['title_back_element'] ?>>
    <?php endif ?>

    <?php if ($props['meta_back']) : ?>
    <p><?= $props['meta_back'] ?></p>
    <?php endif ?>

    <?php if ($props['content_back']) : ?>
    <div><?= $props['content_back'] ?></div>
    <?php endif ?>

    <?php if ($props['link_back']) : ?>
    <p><a href="<?= $props['link_back'] ?>"><?= $props['link_back_text'] ?></a></p>
    <?php endif ?>

</div>
<?php endif ?>
