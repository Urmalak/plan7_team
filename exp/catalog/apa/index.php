<div class="ex_rel" style="margin:20px 0;">
	<?php
	if (isset($_GET['apa'])) {
		require_once('apa/page.php');
	} else {
		require_once('apa/list.php');
	}
	?>
</div>