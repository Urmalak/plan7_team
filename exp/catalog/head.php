<?php
if (!isset($_GET['zk']) || strlen($_GET['zk']) == 0) {$_GET['zk'] = 1;}
	$HEAD = array();
	require_once('../../js/addon/Mobile_Detect.php');
	$HEAD['mobile'] = new Mobile_Detect;
	$get = Get('SELECT * FROM cat_zk WHERE id="'.(isset($_GET['zk']) ? $_GET['zk'] : 1).'";',1,0);
	if (isset($get[0])) {
		$HEAD['zk'] = $get[0];
		$HEAD['zk_info'] = unserialize($HEAD['zk']['info']);
		$HEAD['type'] = array();
		$HEAD['type'][0] = array('name'=>'Квартир', 1=>'а', 2=>'ы', 5=>'', 'many'=>'ы');
		$HEAD['type'][1] = array('name'=>'Офис', 1=>'', 2=>'а', 5=>'ов', 'many'=>'ы');
		$HEAD['type'][2] = array('name'=>'М/мест', 1=>'о', 2=>'а', 5=>'', 'many'=>'а');
		$HEAD['type'][3] = array('name'=>'Кладов', 1=>'ая', 2=>'ые', 5=>'ых', 'many'=>'ые');
		$HEAD['style'] = array();
		$HEAD['style']['999'] = array('b'=>'777', 'f'=>'888');
		$HEAD['style']['090'] = array('b'=>'379833', 'f'=>'3E9B39');
		$HEAD['style']['00C'] = array('b'=>'57B', 'f'=>'69C');
		$HEAD['style']['C00'] = array('b'=>'C50', 'f'=>'E60');
		$HEAD['style']['F90'] = array('b'=>'F90', 'f'=>'FB0');
		$HEAD['sty'] = (isset($HEAD['zk_info']['style']) && isset($HEAD['style'][$HEAD['zk_info']['style'].""]) ? $HEAD['style'][$HEAD['zk_info']['style']] : $HEAD['style']['00C']);
		$HEAD['pat'] = $H_hos.'/exp/catalog/index.php?zk='.$_GET['zk'];
		$get = Get('SELECT * FROM p7_city WHERE id="'.$HEAD['zk']['city'].'";',1,0);
		$HEAD['city'] = $get[0];
		$HEAD['rn'] = "";
		$HEAD['rn_uns'] = unserialize($HEAD['city']['rn']);
		foreach($HEAD['rn_uns'] as $i => $v) {if ($v['id'] == $HEAD['zk']['rn']) {$HEAD['rn'] = $v;}}
		unset($get);
		$get = Get('SELECT * FROM cat_sk WHERE id="'.$HEAD['zk']['sk'].'";',1,0);
		$HEAD['sk'] = $get[0];
		unset($get);
		$HEAD['user'] = 0;
		if (isset($_COOKIE['cat_log']) && isset($_COOKIE['cat_pas'])) {
			$HEAD['user'] = 2;
			if ($_COOKIE['cat_log'] == $HEAD['sk']['log'] && $_COOKIE['cat_pas'] == $HEAD['sk']['pas']) {
				$HEAD['user'] = 7;
			}
		}
		echo '<input type="hidden" name="head[user]" value="'.$HEAD['user'].'">';
		$get = Get('SELECT * FROM cat_bs WHERE zk="'.$HEAD['zk']['id'].'" && access=1 ORDER BY id;',0,0);
		$HEAD['bs'] = array();
		foreach($get as $i => $v) {
			$HEAD['bs'][$v['id']] = $v;
		}
		unset($get);
		$get = Get('SELECT * FROM cat_apa WHERE zk="'.$HEAD['zk']['id'].'" && access=1 ORDER BY ord, id ASC;',0,0);
		$HEAD['apa'] = array();
		$HEAD['typs'] = array();
		foreach($get as $i => $v) {
			if (!in_array($v['type'], $HEAD['typs'])) {$HEAD['typs'][] = $v['type'];}
			$HEAD['apa'][$v['id']] = $v;
		}
		unset($get);
	}
	unset($get);
?>