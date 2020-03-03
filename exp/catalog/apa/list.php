<?php
	$data = array();
	$data['arr'] = array();
	$data['C'] = (isset($_COOKIE['cat_find']) ? json_decode($_COOKIE['cat_find'], true) : NULL);
	$data['co'] = 0;
	if (isset($HEAD['apa'])) {
		foreach($HEAD['apa'] as $i => $v) {
			if ((!isset($HEAD['n_bs']) && isset($HEAD['bs'][$v['bs']])) || (isset($HEAD['n_bs']) && $v['bs'] == $HEAD['n_bs']['id'])) {
				$data['sum'] = Summ(array('area'=>$v['area'], 'cost'=>$v['cost'], 'summ'=>$v['summ']));
				$data['hid'] = true;
				if (!isset($data['C']) || 
					(
						(!isset($data['C']['type']) || !is_array($data['C']['type']) || !in_array(true, $data['C']['type']) || 
						(isset($data['C']['type'][$v['type']]) && $data['C']['type'][$v['type']] == true) || 
						(!isset($HEAD['typs']) || count($HEAD['typs']) == 0) || !isset($v['type'])
						) && 
						(!isset($data['C']['room']) || !is_array($data['C']['room']) || !in_array(true, $data['C']['room']) || 
						(isset($data['C']['room'][($v['room']-1)]) && $data['C']['room'][($v['room']-1)] == true)
						) && 
						(!isset($data['C']['area']) || !is_array($data['C']['area']) || 
						(
							($data['C']['area'][0] == false || strlen($data['C']['area'][0]) <= 0 || $data['C']['area'][0] <= $v['area']) && 
							($data['C']['area'][1] == false || strlen($data['C']['area'][1]) <= 0 || $data['C']['area'][1] >= $v['area']))) && 
							(!is_array($data['C']['summ']) || $data['sum']['summ'] == 0 || 
							(
								($data['C']['summ'][0] == false || strlen($data['C']['summ'][0]) <= 0 ||
									$data['C']['summ'][0] <= $data['sum']['summ']) && 
								($data['C']['summ'][1] == false || strlen($data['C']['summ'][1]) <= 0 ||
									$data['C']['summ'][1] >= $data['sum']['summ'])
							)
						)
					)
				) {
					$data['hid'] = false;
					$data['co']++;
				}
				if ($data['hid'] != true) {
					$data['img'] = array();
					$data['img']['src'] = $H_hos.'/img/photo.svg';
					if (isset($v['pla']) && $v['pla'] > 0) {
						$data['img']['dir'] = 'img/img/cat_pla/'.$v['pla'].'/a/';
						if (is_dir('../../'.$data['img']['dir'])) {
							$data['img']['files'] = FromDIR(array('dir'=>'../../'.$data['img']['dir'],'exclude'=>array(),'type'=>"file"));
							if (isset($data['img']['files'][0])) {$data['img']['src'] = $H_hos.'/'.$data['img']['dir'].''.$data['img']['files'][0];}
						}
					}
					$data['bs'] = (isset($HEAD['bs'][$v['bs']]) ? $HEAD['bs'][$v['bs']] : NULL);
					$data['term'] = array();
					$data['term'] = (strlen($data['bs']['term'])==5 ? array('q'=>substr($data['bs']['term'],4,1), 'Y'=>substr($data['bs']['term'],0,4)) : array('q'=>0, 'Y'=>0));
					$data['term']['text'] = $data['term']['q'].' КВ '.$data['term']['Y'];
					$data['arr'][] = '<tr class="sortir catpage ex_rel ex_curs ex_bgover ex_vcen ex_vmid" alt="'.$v['id'].'">
						<td class="ex_vcen" style="padding:5px;">
							<input type="hidden" name="apa" value="'.$v['id'].'">
							<input type="hidden" name="zk" value="'.$HEAD['zk']['id'].'">
							<div class="ex_imgbox" style="width:75px; height:75px;">
								<img src="'.$data['img']['src'].'" class="ex_imgfit" alt="plan" title="Планировка #'.$v['pla'].'">
							</div>
						</td>
						'.($HEAD['n_bs']['type'] != 2 ? '<td style="padding:5px;">
							<span class="ex_f18">'.($v['room'] > 0 ? $v['room'] : '').'</span>
							<input type="hidden" class="by_room" value="'.$v['room'].'">
						</td>' : '').'
						<td style="padding:5px;">
							<span class="ex_f18">'.number_format($data['sum']['area'], '2', '.', ' ').'</span>
							<input type="hidden" class="by_area" value="'.$data['sum']['area'].'">
						</td>
						<td class="exp_cat_com" style="padding:5px;">
							<span class="ex_f18 ex_wrap">'.number_format($data['sum']['cost'], '0', '.', ' ').'</span>
							<input type="hidden" class="by_cost" value="'.$data['sum']['cost'].'">
						</td>
						<td style="padding:5px;">
							<span class="ex_f18 ex_wrap">'.number_format($data['sum']['summ'], '0', '.', ' ').'</span>
							<input type="hidden" class="by_summ" value="'.$data['sum']['summ'].'">
						</td>
						<td class="exp_cat_com" style="padding:5px;">
							<span class="ex_f14 ex_fgrey">'.(isset($data['bs']) ? $data['bs']['name'] : 0).'</span>
							<input type="hidden" class="by_bs" value="'.(isset($data['bs']) ? $data['bs']['name'] : 0).'">
						</td>
						<td class="exp_cat_com" style="padding:5px;">
							<span class="ex_f18 ex_fgrey">'.$v['level'].'</span>
							<input type="hidden" class="by_lev" value="'.$v['level'].'">
						</td>
						<td class="exp_cat_com" style="padding:5px;">
							<span class="ex_f14 ex_fgrey">'.$data['term']['text'].'</span>
							<input type="hidden" class="by_term" value="'.round($data['term']['Y'].''.$data['term']['q']).'">
						</td>
					</tr>';
				}
			}
		}
		$data['sarr'] = array();
		$data['sarr'][] = array('val'=>NULL, 'name'=>"План", 'W'=>8);
		if ($HEAD['n_bs']['type'] != 2) {$data['sarr'][] = array('val'=>"room", 'name'=>'Комнат', 'W'=>12);}
		$data['sarr'][] = array('val'=>"area", 'name'=>'Площадь'.($HEAD['mobile']->isMobile() ? '' : ' м<sup>2</sup>'), 'W'=>15);
		$data['sarr'][] = array('val'=>"cost", 'name'=>'Цена <span class="ruble">р</span> м<sup>2</sup>', 'W'=>15);
		$data['sarr'][] = array('val'=>"summ", 'name'=>'Стоимость <span class="ruble">р</span>', 'W'=>16);
		$data['sarr'][] = array('val'=>"bs", 'name'=>'БС', 'W'=>13);
		$data['sarr'][] = array('val'=>"lev", 'name'=>'Этаж', 'W'=>8);
		$data['sarr'][] = array('val'=>"term", 'name'=>'Срок сдачи', 'W'=>13);
		$data['sort'] = array();
		foreach($data['sarr'] as $i => $v) {
			if (isset($v['val'])) {
				$data['sort'][] = '<td class="sortcat ex_curs ex_in '.($v['val'] == 'room' || $v['val'] == 'area' || $v['val'] == 'summ' ? '' : 'exp_cat_com').'" style="width:'.$v['W'].'%; padding:10px 0;" alt="'.$v['val'].'"><b class="arrow ex_hid ex_fgrey">&#9660;</b>&nbsp;<span class="ex_dash">'.$v['name'].'</span></td>';
			} else {
				$data['sort'][] = '<td style="width:'.$v['W'].'%; padding:20px 0;"><span>'.$v['name'].'</span></td>';
			}
		}
	}
	$data['type'] = (isset($HEAD['n_bs']['type']) ? $HEAD['type'][$HEAD['n_bs']['type']] : NULL);
	$data['padez'] = ($data['type'] ? array($data['type']['name'].''.$data['type'][1], $data['type']['name'].''.$data['type'][2], $data['type']['name'].''.$data['type'][5]) : array('помещение','помещения','помещений'));
?>
<div class="ex_rel" style="padding:10px <?php echo ($HEAD['mobile']->isMobile() ? 25 : 58); ?>px;">
	<span class="ex_f16 ex_fgrey ex_wrap">С текущими параметрами </span>
	<span class="ex_f16 ex_wrap">найдено <?php echo $data['co'].' '.Padez($data['padez'], $data['co']); ?></span>
</div>
<div class="ex_rel" style="max-width:1200px; <?php echo ($HEAD['mobile']->isMobile() ? '' : 'padding-left:25px;'); ?>">
	<table class="ex_cell ex_W">
		<thead><tr class="ex_f12 ex_fgrey ex_vcen ex_vmid" style="border-bottom:#EEE 1px solid;"><?php echo implode($data['sort']); ?></tr></thead>
		<tbody><?php echo implode($data['arr']); ?></tbody>
	</table>
</div>
<?php
unset($data);
?>