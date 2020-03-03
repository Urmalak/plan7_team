<?php
	$data = array();
	$data['get_lev'] = Get('SELECT * FROM cat_lev WHERE bs="'.$HEAD['n_bs']['id'].'" ORDER BY ord, id DESC;',0,0);
	$data['get_ent'] = Get('SELECT * FROM cat_ent WHERE bs="'.$HEAD['n_bs']['id'].'";',0,0);
	$data['levmax'] = array(0, 0);
	$data['term'] = (strlen($HEAD['n_bs']['term'])==5 ? array('q'=>substr($HEAD['n_bs']['term'],4,1), 'Y'=>substr($HEAD['n_bs']['term'],0,4)) : array('q'=>0, 'Y'=>0));
	$data['term']['text'] = $data['term']['q'].' КВ '.$data['term']['Y'];			
	foreach($data['get_ent'] as $i => $v) {
		$data['ent'] = array();
		$data['ent']['level'] = (strlen($v['level'])>2 ? explode("," ,$v['level']) : array(0, 0));
		if ($data['levmax'][0] < $data['ent']['level'][0]) {$data['levmax'][0] = round($data['ent']['level'][0]);}
		if ($data['levmax'][1] < $data['ent']['level'][1]) {$data['levmax'][1] = round($data['ent']['level'][1]);}
		unset($data['ent']);
	}
	$data['level'] = array();
	for ($k = (1 - $data['levmax'][0]); $k <= $data['levmax'][1]; $k++) {
		$data['gel'] = array();
		foreach($data['get_lev'] as $i => $v) {
			$level = explode(',',$v['level']);
			if (in_array($k, $level)) {$data['gel']['lev'] = $v;}
			unset($level);
		}
		if (isset($data['gel']['lev'])) {$data['level'][$k] = $data['gel']['lev'];}
		unset($data['gel']);
	}
	ksort($data['level']);
	$data['set'] = NULL;
	$data['arr'] = array();
	for ($k = (1 - $data['levmax'][0]); $k <= $data['levmax'][1]; $k++) {
		if (isset($data['level'][$k])) {
			$data['gel'] = array();
			$data['gel']['area'] = unserialize($data['level'][$k]['area']);
			$data['gel']['img'] = array();
			$data['gel']['img']['dir'] = 'img/img/cat_lev/'.$data['level'][$k]['id'].'/pla/';
			if (is_dir('../../'.$data['gel']['img']['dir'])) {
				$data['gel']['img']['files'] = FromDIR(array('dir'=>'../../'.$data['gel']['img']['dir'],'exclude'=>array(),'type'=>"file"));
				if (isset($data['gel']['img']['files'][0])) {
					$data['gel']['img']['src'] = $H_hos.'/'.$data['gel']['img']['dir'].''.$data['gel']['img']['files'][0];
				}
			}
			$data['gel']['path'] = array();
			$data['gel']['divs'] = array();
			$data['gel']['have'] = false;
			if (isset($data['gel']['area']) && is_array($data['gel']['area'])) {
				foreach($data['gel']['area'] as $j => $u) {
					$data['apa'] = array();
					$data['apa']['id'] = 'aparea_'.$data['level'][$k]['id'].'_'.$k.'_'.$j;
					$data['apa']['get'] = Get('SELECT * FROM cat_apa WHERE id IN ('.(is_array($u['obj']) ? implode(',',$u['obj']) : '').') && level="'.$k.'" ORDER BY ord;',1,0);
					$data['apa']['access'] = (isset($data['apa']['get'][0]) ? $data['apa']['get'][0]['access'] : 0);
					if ($data['apa']['access'] == 1) {
						$data['gel']['have'] = true;
					}
					$data['gel']['path'][] = '<path d="M'.$u['dot'].'z" class="area_para cat_zone '.($data['apa']['access'] == 1 ? 'exp_svg_zone' : 'exp_svg_sold').' print_s" alt="'.$data['apa']['get'][0]['id'].'" />';
					unset($data['apa']);
				}
			}
			$data['gel']['set'] = ((isset($_GET['lev']) && $_GET['lev'] == $k) || (!isset($_GET['lev']) && !$data['set']) ? true : NULL);
			if ($data['gel']['have'] == true) {
				$data['lev'][] = '<div class="ex_imgbox" style="margin:2px;">
					<div class="levcat ex_flex_container ex_flex_center '.(isset($data['gel']['set']) ? 'exp_cat_bblue' : 'exp_cat_bempt').'" style="width:28px; height:28px; border-radius:14px;" alt="'.$k.'">
						<input type="hidden" name="level" value="'.$k.'">
						<span>'.$k.'</span>
					</div>
				</div>';
			} else {
				$data['lev'][] = '<div class="ex_imgbox" style="margin:2px;">
					<div class="ex_flex_container ex_flex_center" style="width:28px; height:28px; color:#CCC;" alt="'.$k.'">
						<span>'.$k.'</span>
					</div>
				</div>';
			}
			$data['arr'][] = '<div class="levdiv ex_rel '.(isset($data['gel']['set']) ? '' : 'ex_hid').'" style="max-width:100%; margin-top:40px;">
				<input type="hidden" name="level" value="'.$k.'">
				<div class="print_h ex_rel ex_vcen ex_hid" style="padding:20px;">
					<h2>ЖК '.$HEAD['zk']['name'].'</h2>
					<h3>Секция '.$HEAD['n_bs']['name'].'&#8195; Этаж '.$k.'&#8195; срок сдачи '.$data['term']['text'].'</h3>
				</div>
				<div class="ex_imgbox">
					<img src="'.(isset($data['gel']['img']['src']) ? $data['gel']['img']['src'] : $H_hos.'/img/svg/photo.svg').'" class="area_svg" style="max-width:100%;" alt="fas">
					<svg class="ex_abs ex_pos">'.implode($data['gel']['path']).'</svg>
					<div class="ex_hid">'.implode($data['gel']['divs']).'</div>
				</div>
			</div>';
			if (!isset($_GET['lev']) && !$data['set']) {$data['set'] = true;}
			unset($data['gel']);
		} else {
			$data['lev'][] = '<div class="ex_imgbox" style="margin:2px;">
				<div class="ex_flex_container ex_flex_center" style="width:28px; height:28px; color:#CCC;" alt="'.$k.'">
					<span>'.$k.'</span>
				</div>
			</div>';
		}
	}
	echo '<div class="ex_rel ex_vcen">
		<div class="ex_imgbox ex_selno">
			<h4 class="ex_f12 ex_fgrey">Этажи</h4>
			<table class="ex_cell">
				<tbody>
					<tr>
						<td style="width:10px;">
							<div class="levnext exp_cat_rule ex_imgbox levno ex_curs" style="width:24px; height:24px; margin:-2px 10px 0px 0px;">
								<input type="hidden" name="val" value="-1">
								<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['arol'].'"/></svg>
							</div>
						</td>
						<td id="lev_td">'.implode($data['lev']).'</td>
						<td style="width:10px;">
							<div class="levnext exp_cat_rule ex_imgbox levno ex_curs" style="width:24px; height:24px; margin:-2px 10px 0px 0px;">
								<input type="hidden" name="val" value="1">
								<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['aror'].'"/></svg>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="ex_rel ex_vcen ex_selno">
		<div class="ex_imgbox" style="max-width:100%;">
		<table class="ex_cell ex_W">
			<tbody>
				<tr class="ex_vcen ex_vmid">
					<td class="levnext exp_cat_com ex_rel ex_curs exp_cat_rule" style="width:60px;">
						<input type="hidden" name="val" value="-1">
						<div class="ex_abs" style="left:0px; top:50%; margin-top:-20px; width:60px; height:60px;">
							<svg class="svg" viewBox="0 0 400 400" style="transform: rotate(0deg);">
								<path d="M229 331l-98 -131 98 -131c0,164 0,99 0,262z"/>
							</svg>
						</div>
					</td>
					<td>
						<div id="print_elem" class="ex_imgbox ex_vcen">'.implode($data['arr']).'</div>
					</td>
					<td class="levnext exp_cat_com ex_rel ex_curs exp_cat_rule" style="width:60px;">
						<input type="hidden" name="val" value="1">
						<div class="ex_abs" style="left:0px; top:50%; margin-top:-20px; width:60px; height:60px;">
							<svg class="svg" viewBox="0 0 400 400" style="transform: rotate(180deg);">
								<path d="M229 331l-98 -131 98 -131c0,164 0,99 0,262z"/>
							</svg>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
	</div>
	<div class="ex_rel" style="height: 40px;"></div>
	<div class="ex_rel ex_vcen">
	<div class="printcat ex_imgbox exp_cat_bgrey ex_cro3" style="height: 40px; padding:0px 20px;" alt="print_elem">
		<table class="ex_cell ex_rel ex_pos">
			<tbody>
				<tr class="ex_vcen ex_vmid">
					<td></td>
						<td class="ex_vrig">
							<div class="ex_imgbox" style="width:32px; height:32px;">
								<svg class="svg" viewBox="0 0 400 400">
									<path d="'.$SVG['print'].'" />
								</svg>
							</div>
						</td>
						<td style="width:10px;"></td>
						<td class="ex_vlef"><span class="ex_f16">Печать</span></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
	</div>';
	unset($data);
?>