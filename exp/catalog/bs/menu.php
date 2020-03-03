<div class="ex_rel ex_vlef" style="padding:0px <?php echo ($HEAD['mobile']->isMobile() ? 25 : 58); ?>px;">
	<?php
		$arr = array();
		if ($HEAD['n_bs']['type'] != 2) {$arr[] = array('pat'=>'che', 'title'=>'Шахматка', 'svg'=>'cell');}
		$arr[] = array('pat'=>'apa', 'title'=>'Список', 'svg'=>'list');
		$arr[] = array('pat'=>'lev', 'title'=>'Этажи', 'svg'=>'flat');
		if ($HEAD['n_bs']['type'] != 2) {$arr[] = array('pat'=>'fas', 'title'=>'Фасады', 'svg'=>'zk');}
		foreach($arr as $i => $v) {
			echo '<div class="'.(isset($_GET['path']) && $_GET['path'] == $v['pat'] ? '' : 'menu_loc').' ex_imgbox ex_vcen '.(isset($_GET['path']) && $_GET['path'] == $v['pat'] ? 'exp_cat_bblue' : 'exp_cat_bgrey').'" style="margin:10px 8px 0 0; min-width:56px; box-shadow:none; background:none;">
				<input type="hidden" class="loc" value="'.$HEAD['pat'].'&page=bs&id='.$_GET['id'].'&path='.$v['pat'].'">
				<div class="ex_imgbox" style="width:40px; height:40px;">
					<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG[$v['svg']].'"/></svg>
				</div>
				<div class="ex_rel ex_vcen"><span class="ex_f14">'.$v['title'].'</span></div>
			</div>';
		}
		unset($arr);
	?>
</div>