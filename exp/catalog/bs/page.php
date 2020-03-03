<?php
	$get = Get('SELECT * FROM cat_bs WHERE id="'.$_GET['id'].'";',1,0);
	if (isset($get[0])) {
		$HEAD['n_bs'] = $get[0];
	}
	unset($get);
	if (isset($HEAD['n_bs'])) {
		if (!isset($_GET['path'])) {
			$_GET['path'] = ($HEAD['n_bs']['type'] == 2 ? 'apa' : 'lev');
		}
		$arr = array(0=>'Блок-секция', 1=>'Офисы', 2=>'Парковка');
		echo '<div class="ex_rel" style="height:20px;"></div>
		<div class="ex_rel" style="margin-left:'.($HEAD['mobile']->isMobile() ? 25 : 58).'px;">
			<h2>'.$arr[(isset($HEAD['n_bs']['type']) ? $HEAD['n_bs']['type'] : 0)].' '.$HEAD['n_bs']['name'].'</h2>
		</div>';
		unset($arr);
		include_once('bs/menu.php');
		if (is_file('bs/'.$_GET['path'].'/index.php')) {
			include_once('bs/'.$_GET['path'].'/index.php');
		}
	}
?>