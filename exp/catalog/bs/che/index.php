<script src="bs/che/script.js"></script>
<div class="ex_rel" style="margin:25px;">
	<?php
		$data = array();
		$data['get_ent'] = Get('SELECT * FROM cat_ent WHERE bs="'.$HEAD['n_bs']['id'].'";',0,0);
		$data['menu'] = array();
		$data['mode'] = array();
		$data['arr'] = array();
		$data['arr'][] = array('val'=>'name', 'title'=>'Номер');
		$data['arr'][] = array('val'=>'area', 'title'=>'Площадь');
		$data['arr'][] = array('val'=>'cost', 'title'=>'Цена за м');
		$data['arr'][] = array('val'=>'summ', 'title'=>'Стоимость');
		foreach($data['arr'] as $i => $v) {
			$data['mode'][] = '<div class="mode ex_imgbox ex_a '.(!$HEAD['mobile']->isMobile() && $v['val'] == 'summ' ? 'exp_cat_fblue' : 'ex_fgrey').'" style="margin:10px 15px 0 0;" alt="'.$v['val'].'"><span class="ex_f14">'.$v['title'].'</span></div>';
		}
		unset($data['arr']);
		$data['level'] = array();
		foreach($data['get_ent'] as $i => $v) {
			$data['ent'] = array();
			$data['ent']['id'] = 'ent_'.$v['id'];
			if (count($data['get_ent']) > 1) {
				$data['menu'][] = '<div class="entmenu ex_imgbox ex_cro5 '.($i == 0 ? 'exp_cat_bblue' : 'exp_cat_bempt').'" style="padding:8px 10px; margin:4px 4px 0 0;" alt="'.$data['ent']['id'].'"><span class="ex_f18">Подъезд '.$v['name'].'</span></div>';
			}
			$data['ent']['level'] = (strlen($v['level'])>2 ? explode("," ,$v['level']) : array(0, 0));
			$data['ent']['apa'] = array();
			for ($k = round($data['ent']['level'][1]); $k > (0 - round($data['ent']['level'][0])); $k--) {
				$data['ent']['apa'][$k] = array();
				$get = Get('SELECT * FROM cat_apa WHERE ent="'.$v['id'].'" && level="'.$k.'" ORDER BY ord, id ASC;',0,0);
				foreach($get as $j => $u) {
					$data['apa'] = array();
					$data['apa']['id'] = 'apadiv_'.$u['id'];
					$data['apa']['img'] = array();
					$data['apa']['img']['dir'] = 'img/img/cat_pla/'.$u['pla'].'/a/';
					if (is_dir('../../'.$data['apa']['img']['dir'])) {
						$data['apa']['img']['files'] = FromDIR(array('dir'=>'../../'.$data['apa']['img']['dir'],'exclude'=>array(),'type'=>"file"));
						if (isset($data['apa']['img']['files'][0])) {$data['apa']['img']['src'] = $H_hos.'/'.$data['apa']['img']['dir'].''.$data['apa']['img']['files'][0];}
					}
					$data['apa']['src'] = (isset($data['apa']['img']['src']) ? $data['apa']['img']['src'] : $H_hos.'/img/svg/photo.svg');
					$data['apa']['sum'] = Summ(array('area'=>$u['area'], 'cost'=>$u['cost'], 'summ'=>$u['summ']));
					$data['ent']['apa'][$k][] = '<td class="'.($u['access'] == 1 ? 'exp_cat_bches' : 'exp_cat_bgrey').'">
						<table class="ex_cell ex_pos">
							<tbody>
							<tr>
							<td class="ex_vmid '.($u['access'] == 1 ? 'chesscat exp_cat_chess' : 'ex_fgreyl').'">
								<div class="ex_imgbox" style="padding:4px 9px;">
									<span class="ex_f18">'.$u['room'].'</span>
								</div>
							</td>
							<td>
								'.($u['access'] == 1 ? '<div class="che ex_rel ex_vcen ex_hid" style="padding:2px;">
									<input type="hidden" name="che[name]">
									<span class="ex_f12 exp_cat_fgrey">№'.$u['name'].'</span>
								</div>
								<div class="che ex_rel '.($HEAD['mobile']->isMobile() ? 'ex_hid' : '').'" style="padding:2px 4px 2px 8px;">
									<input type="hidden" name="che[summ]">
									<span class="ex_f18 '.($u['access'] == 1 ? 'ex_fblack' : 'ex_fgrey').' ex_wrap"><b>'.(strlen($data['apa']['sum']['summ']) > 2 ? number_format($data['apa']['sum']['summ'], '0', '.', ' ').'</b> <span class="ruble">р</span>' : '').'</span>
								</div>
								<div class="che ex_rel ex_hid" style="padding:2px 4px 2px 8px;">
									<input type="hidden" name="che[area]">
									<span class="ex_f14 '.($u['access'] == 1 ? 'ex_fblack' : 'ex_fgrey').' ex_wrap">'.number_format($data['apa']['sum']['area'], '2', '.', ' ').' м<sup>2</sup></span>
								</div>
								<div class="che ex_rel ex_hid" style="padding:2px 4px 2px 8px;">
									<input type="hidden" name="che[cost]">
									<span class="ex_f14 '.($u['access'] == 1 ? 'ex_fgreyd' : 'ex_fgrey').' ex_wrap">'.(strlen($data['apa']['sum']['cost']) > 2 ? number_format($data['apa']['sum']['cost'], '0', '.', ' ').' <span class="ruble">р</span>/м<sup>2</sup>' : '').'</span>
								</div>' : '<div class="che ex_rel '.($HEAD['mobile']->isMobile() ? 'ex_hid' : '').'" style="padding:2px 4px 2px 8px;">
									<input type="hidden" name="che[summ]">
									<span class="ex_f14" style="color:#CCC;">Продано</span>
								</div>').'
							</td>
							</tr>
							</tbody>
						</table>
						'.($u['access'] == 1 ? CAT_APA_Preview(array('apa'=>$u['id'],'id'=>$data['apa']['id'],'img'=>$data['apa']['src'],'room'=>$u['room'],'sum'=>$data['apa']['sum'])) : '').'
						<div class="'.($u['access'] == 1 ? 'catpage area_ches' : '').' ex_abs ex_pos ex_curs" alt="'.$data['apa']['id'].'">
							<input type="hidden" name="apa" value="'.$u['id'].'">
							<input type="hidden" name="zk" value="'.$HEAD['zk']['id'].'">
						</div>
					</td>';
					unset($data['apa']);
				}
				unset($get);
			}
			$data['ent']['tr'] = array();
			foreach($data['ent']['apa'] as $j => $u) {
				$data['ent']['tr'][] = '<tr>
					<td class="ex_vrig ex_selno" style="width:15px;" title="'.$j.'-й этаж"><b class="ex_f12 ex_fblack">'.$j.'</b>&nbsp;</td>
					'.(count($u) > 0 ? implode($u) : '<td style="height:26px; border:#EEE 1px dashed;"></td>').'
				</tr>';
			}
			$data['level'][] = '<table id="'.$data['ent']['id'].'" class="entdiv '.($i == 0 ? '' : 'ex_hid').'" style="border-spacing:8px; max-width:800px; margin:20px 0 0 0;">
				<tbody>'.implode($data['ent']['tr']).'</tbody>
			</table>';
			unset($data['ent']);
		}
		echo '<div class="ex_rel" style="padding:10px 0 0 33px;">'.implode($data['menu']).'</div>';
		echo '<div class="ex_rel" style="padding:10px 0 0 33px;">
			<div class="mode ex_imgbox ex_curs ex_cro16 exp_cat_bempt" style="width:32px; height:32px; margin:3px 15px 0 0;" alt="0">
				<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['eye'].'"/></svg>
			</div>
			'.implode($data['mode']).'
		</div>';
		echo '<div class="ex_rel">'.implode($data['level']).'</div>';
		unset($data);
	?>
</div>