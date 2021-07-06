<?php

/* Herzog Dupont Copyright (C) 2019–2021 Thomas Weidlich GNU GPL v3 */

if ($props['number']) : ?>
<div>
	<?= $props['number'] ?><?= $props['unit'] ? ' ' . $props['unit'] : '' ?><?= $props['text'] ? ' ' . $props['text'] : '' ?>
</div>
<?php endif ?>
