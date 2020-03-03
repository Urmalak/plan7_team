<div class="ex_rel <?php echo ($HEAD['mobile']->isMobile() ? 'ex_vlef' : 'ex_vrig'); ?>" style="padding:<?php echo ($HEAD['mobile']->isMobile() ? '20px 0px 10px 23px' : '20px 25px 10px 25px'); ?>;">
	<?php
		$arr = array();
		$arr[] = array('page'=>false, 'svg'=>'zk', 'title'=>'Фасады', 'co'=>1, 'loc'=>'');
		$arr[] = array('page'=>'apa', 'svg'=>'list', 'title'=>'Цены', 'co'=>count($HEAD['apa']), 'loc'=>'&page=apa');
		$arr[] = array('page'=>'bs', 'svg'=>'build', 'title'=>'Секции', 'co'=>count($HEAD['bs']), 'loc'=>'&page=bs');
		unset($co);
		foreach($arr as $i => $v) {
			$here = ((isset($_GET['page']) && $_GET['page'] == $v['page'] && !isset($_GET['id']) && !isset($_GET['apa'])) || ($v['page'] == false && !isset($_GET['page'])) ? true : false);
			echo '<div class="'.($here == true ? '' : 'menu_loc').' ex_imgbox ex_bord ex_curs ex_cro5 '.($here == true ? 'exp_cat_bblue' : 'exp_cat_bgrey').'" style="padding:5px; margin:2px;">
				<input type="hidden" class="loc" value="'.$HEAD['pat'].''.$v['loc'].'">
				<table class="ex_cell">
					<tbody>
						<tr>
							<td>
								<div class="ex_imgbox" style="width:24px; height:24px;">
									<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG[$v['svg']].'"/></svg>
								</div>
							</td>
							<td style="width:5px;"></td><td><span>'.$v['title'].'</span></td>
							<td style="width:6px;"></td>
							'.(isset($v['co']) && !$HEAD['mobile']->isMobile() ? '<td>
								<div class="ex_imgbox ex_cro12 ex_vcen" style="background:rgba(0,0,0,0.15);">
									<span class="ex_imgbox ex_fwhite ex_f14" style="margin-top:4px;">'.$v['co'].'</span>
								</div>
							</td>' : '').'
						</tr>
					</tbody>
				</table>
			</div>';
		}
		unset($arr);
	?>
</div>