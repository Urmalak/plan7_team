<?php
	if (isset($_GET['id'])) {
		include_once('bs/page.php');
	} else {
		include_once('bs/list.php');
	}
?>