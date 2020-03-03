<?php
function CAT_APA_Preview($opt) {
	$div = '<div id="'.$opt['id'].'" class="ex_hid">
		<div class="ex_imgbox ex_vcen ex_shadow '.(isset($opt['apa']) ? 'catapa ex_curs' : '').'" style="background:#FFF; padding:5px;" alt="'.(isset($opt['apa']) ? $opt['apa'] : '').'">
			'.(isset($opt['img']) ? '<div class="ex_rel ex_ofh" style="width:150px; height:150px;"><img src="'.$opt['img'].'" class="ex_imgfit" alt="a"></div>' : '').'
			<div class="ex_rel ex_vlef" style="padding:5px;">
				<div class="ex_rel"><span class="ex_f18 ex_fblack">'.(strlen($opt['room'])>0 ? '<b>'.$opt['room'].'</b> к &#8195; ' : '').'<b>'.number_format($opt['sum']['area'], '2', '.', ' ').'</b> м<sup>2</sup></span></div>
				<div class="ex_rel" style="height:10px;"></div>
				'.(strlen($opt['sum']['summ']) > 2 ? '<div class="ex_rel"><span class="ex_f24"><b class="ex_fblack">'.number_format($opt['sum']['summ'], '0', '.', ' ').' </b><span class="ruble">р</span></span></div>' : '').'
				'.(strlen($opt['sum']['cost']) > 2 ? '<div class="ex_rel"><span class="ex_f14 ex_fblack">'.number_format($opt['sum']['cost'], '0', '.', ' ').' <span class="ruble">р</span>/м<sup>2</sup></span></div>' : '').'
			</div>
			<div class="close ex_abs ex_cro12 ex_bord ex_bgwhite ex_curs" style="right:-12px; top:-12px; width:24px; height:24px;">
				<svg class="svg" viewBox="0 0 400 400"><path d="'.$GLOBALS['SVG']['del'].'" style="fill:#000;"/></svg>
			</div>
		</div>
	</div>';
	return $div;
}

function CAT_APA_Plan($opt) {
	if (!isset($opt['nest'])) {$opt['nest'] = '../../../';}
	$data = array();
	$get = Get('SELECT * FROM cat_apa WHERE id="'.$opt['apa'].'";',1,0);
	$data['apa'] = $get[0];
	unset($get);
	$data['dir'] = 'img/img/cat_pla/'.$data['apa']['pla'];
	$data['src'] = array();
	$arr = array('pla', 'dim', 'meb');
	foreach($arr as $i => $v) {
		if (is_dir($opt['nest'].''.$data['dir'].'/'.$v.'/')) {
			$data['f'] = FromDIR(array('dir'=>$opt['nest'].''.$data['dir'].'/'.$v.'/', 'type'=>"file"));
			if (isset($data['f'][0])) {$data['src'][$v] = $data['dir'].'/'.$v.'/'.$data['f'][0];}
		}
	}
	unset($arr);
	$data['ren'] = array();
	$div = '<div class="ex_rel ex_vcen ex_selno">
		<table class="ex_cell ex_W exp_cat_fblue">
			<tbody>
				<tr class="ex_vcen ex_vmid">
					<td>
						<div class="ex_rel" style="width:20px;"></div>
					</td>
					<td style="padding: 10px;">
						<div class="ex_imgbox exp_cat_fblue ex_cro3 ex_curs" onClick="'.(isset($opt['url']) ? 'document.location=`'.$opt['url'].'`' : 'EXP_CAT_closeBox()').'" style="padding:5px 20px;">
							<div class="ex_imgbox" style="width: 14px; height: 14px; margin-top:2px;">
								<svg class="svg" viewBox="0 0 400 400"><path d="M93 200l190 -190 24 24c-56,55 -111,111 -166,166l166 166 -24 24 -190 -190z"/></svg>
							</div>
							<span style="font-size:16px;">Назад</span>
						</div>
						<div class="ex_imgbox" style="width:20px;"></div>
						<div class="ex_imgbox exp_cat_bblue ex_cro3" style="height:28px; width:28px;" title="Мебель">
							<input type="hidden" name="val" value="meb">
							<input type="hidden" name="tog" value="1">
							<svg class="svg" viewBox="0 0 400 400"><path d="'.$GLOBALS['SVG']['meb'].'"/></svg>
							<div class="ex_abs ex_pos" onClick="EXP_CAT_Tog(this)"></div>
						</div>
						<div class="ex_imgbox" style="width:10px;"></div>
						<div class="ex_imgbox exp_cat_bblue ex_cro3" style="height:28px; width:28px;" title="Размер">
							<input type="hidden" name="val" value="dim">
							<input type="hidden" name="tog" value="1">
							<svg class="svg" viewBox="0 0 400 400"><path d="'.$GLOBALS['SVG']['dim'].'"/></svg>
							<div class="ex_abs ex_pos" onClick="EXP_CAT_Tog(this)"></div>
						</div>
					</td>
					<td>
						<div class="ex_rel" style="width:20px;"></div>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="ex_rel" style="height:20px;"></div>
		<table class="ex_cell ex_W">
			<tbody>
				<tr class="ex_vcen ex_vmid">
					<td class="exp_cat_com ex_rel ex_curs exp_cat_rule" style="width:60px;">
						'.(count($data['ren']) > 0 ? '<input type="hidden" name="val" value="-1">
						<div class="ex_abs" style="left:0px; top:50%; margin-top:-20px; width:60px; height:60px;">
							<svg class="svg" viewBox="0 0 400 400" style="transform: rotate(0deg);">
								<path d="M229 331l-98 -131 98 -131c0,164 0,99 0,262z"/>
							</svg>
						</div>' : '').'
					</td>
					<td>
						<div class="ex_rel ex_vcen" style="max-width:600px; max-height:600px;">
							<div class="ex_rel ex_W" style="padding-top:100%;">
								<div class="ex_abs ex_gab" style="display: flex; align-items: center; justify-content: center;">
									<img src="'.(isset($data['src']['pla']) ? $GLOBALS['H_hos'].'/'.$data['src']['pla'] : $GLOBALS['H_hos'].'/img/photo.svg').'" class="ex_imggab" alt="pla" title="pla">
									'.(isset($data['src']['meb']) ? '<img src="'.$GLOBALS['H_hos'].'/'.$data['src']['meb'].'" class="meb ex_imggab" alt="meb">' : '').'
									'.(isset($data['src']['dim']) ? '<img src="'.$GLOBALS['H_hos'].'/'.$data['src']['dim'].'" class="dim ex_imggab" alt="dim">' : '').'
								</div>
							</div>
						</div>
					</td>
					<td class="exp_cat_com ex_rel ex_curs exp_cat_rule" style="width:60px;">
						'.(count($data['ren']) > 0 ? '<input type="hidden" name="val" value="1">
						<div class="ex_abs" style="left:0px; top:50%; margin-top:-20px; width:60px; height:60px;">
							<svg class="svg" viewBox="0 0 400 400" style="transform: rotate(180deg);">
								<path d="M229 331l-98 -131 98 -131c0,164 0,99 0,262z"/>
							</svg>
						</div>' : '').'
					</td>
				</tr>
			</tbody>
		</table>
		<div class="ex_rel" style="height: 20px;"></div>
		'.(count($data['ren']) > 0 ? '<div class="ex_rel ex_vcen">
			<div class="ex_imgbox ex_bgover ex_curs" style="width: 40px; height: 40px; background: #999;"></div>
		</div>' : '').'
	</div>';
	return $div;
}

function CAT_APA_Parameters($opt) {
	$get = Get('SELECT * FROM cat_apa WHERE id="'.$opt['apa'].'";',1,0);
	$arr = array();
	if (isset($get[0])) {
		$data = array();
		$data['apa'] = $get[0];
		unset($get);
		$get = Get('SELECT * FROM cat_zk WHERE id="'.$data['apa']['zk'].'";',1,0);
		$data['zk'] = $get[0];
		$data['zk_info'] = unserialize($data['zk']['info']);
		unset($get);
		$get = Get('SELECT * FROM cat_bs WHERE id="'.$data['apa']['bs'].'";',1,0);
		$data['bs'] = $get[0];
		unset($get);
		$data['term'] = Term(array('term'=>$data['bs']['term'], 'co'=>5));
		$data['skey'] = Term(array('term'=>$data['bs']['skey'], 'co'=>6));
		$data['type'] = array(0=>'Квартира', 1=>'Офис', 2=>'М/место', 3=>'Кладовая');
		$data['sum'] = Summ(array('area'=>$data['apa']['area'], 'cost'=>$data['apa']['cost'], 'summ'=>$data['apa']['summ']));
		$get = Get('SELECT * FROM cat_apa WHERE pla="'.$data['apa']['pla'].'" && access!=0;',0,0);
		$data['list'] = array('num'=>array(), 'arr'=>array());
		foreach($get as $i => $v) {
			if ($v['level'] != $data['apa']['level'] && !in_array($v['level'], $data['list']['num'])) {
				$sup = Summ(array('area'=>$v['area'], 'cost'=>$v['cost'], 'summ'=>$v['summ']));
				$data['list']['num'][] = $v['level'];
				$data['list']['arr'][] = '<a href="'.$GLOBALS['H_hos'].'/exp/catalog/index.php?zk='.$data['bs']['zk'].'&page=bs&id='.$data['bs']['id'].'&path=lev&lev='.$v['level'].'" class="row ex_f14 ex_fblack ex_decno ex_bgover '.($v['id'] != $_GET['apa'] ? '' : 'ex_bggrey').'">
					<div class="cel" style="padding:4px 12px;"><span class="ex_f14">'.$v['level'].'</span></div>
					<div class="cel" style="padding:4px 12px;"><span class="ex_f14 ex_fgrey">'.$v['area'].'</span></div>
					<div class="cel" style="padding:4px 12px;"><span class="ex_f14">'.($sup['cost'] > 2 && (!isset($data['zk_info']['ot']) || $data['zk_info']['ot'] != 1) ? Price($sup['cost']) : '').'</span></div>
					<div class="cel" style="padding:4px 12px;"><span class="ex_f14">'.($sup['summ'] > 2 && (!isset($data['zk_info']['ot']) || $data['zk_info']['ot'] != 1) ? Price($sup['summ']) : '').'</span></div>
				</a>';
				unset($sup);
			}
		}
		unset($get);
		natsort($data['list']['num']);
		natsort($data['list']['arr']);
		$arr[] = '<h4 style="font-size:27px;">'.$data['type'][(isset($data['apa']['type']) ? $data['apa']['type'] : 0)].' №'.$data['apa']['name'].'</h4>';
		$arr[] = '<div class="ex_rel" style="height: 10px;"></div>';
		$arr[] = '<span class="ex_f16">'.($data['apa']['access'] == 1 ? 'Свободна' : 'Куплена').'</span>';
		$arr[] = '<div class="ex_rel" style="height: 30px;"></div>';
		$arr[] = ($data['apa']['access'] == 1 ? '<div class="ex_rel">
			<span style="font-size:42px;"><strong>'.Price($data['sum']['summ']).' </strong><span class="ruble">р</span></span>
			<div class="ex_rel" style="height:5px;"></div>
			<span class="ex_fgrey" style="font-size:20px;">'.Price($data['sum']['cost']).' <span class="ruble">р</span> / м<sup>2</sup></span>
		</div>
		<div class="ex_rel" style="height:20px;"></div>' : '');
		$arr[] = '<div class="ex_rel" style="height:20px;"></div>';
		$arr[] = '<table class="ex_cell ex_W">
			<tbody>
				<tr>
					<td>
						<span class="ex_f12 ex_fgrey">Комнат</span><br>
						<strong class="ex_f20">'.$data['apa']['room'].'</strong>
					</td>
					<td style="width:40px;"></td>
					<td>
						<span class="ex_f12 ex_fgrey">Площадь</span><br>
						<span class="ex_f20"><strong>'.$data['apa']['area'].'</strong> м<sup>2</sup></span>
					</td>
				</tr>
				<tr><td><div class="ex_rel" style="height:20px;"></div></td></tr>
				<tr>
					<td>
						<span class="ex_f12 ex_fgrey">Блок-секция</span><br>
						<span class="ex_f20"><strong>'.$data['bs']['name'].'</strong></span>
					</td>
					<td style="width:40px;"></td>
					<td>
						<span class="ex_f12 ex_fgrey">'.(isset($data['skey']) && $data['skey']['E'] != 1 ? 'Выдача ключей' : 'Срок сдачи').'</span><br>
						<span class="ex_f20"><strong>'.(isset($data['skey']) && $data['skey']['E'] != 1 ? CMon(array($data['skey']['q'],0,0)).' '.$data['skey']['Y'] : (isset($data['bs']['sdan']) && $data['bs']['sdan'] == "on" ? 'Сдан' : (isset($data['term']) && $data['term']['E'] != 1 ? $data['term']['q'].' кв '.$data['term']['Y'] : 'Сдан'))).'</strong></span>
					</td>
				</tr>
			</tbody>
		</table>';
		$arr[] = '<div class="ex_rel" style="height:20px;"></div>';
		$arr[] = '<div class="ex_rel">
			<span class="ex_f12 ex_fgrey">Этаж</span><br>
			<table class="ex_cell" style="max-width:100%;">
				<tbody>
					<tr class="ex_vlef ex_vmid">
						<td style="width:40px;">
							<strong class="ex_f20">'.$data['apa']['level'].'</strong>
						<td>
						<td>
							<div class="imgbox ex_ofh" style="max-width:120px;">
								<span class="ex_f20 ex_fgrey ex_wrap">'.implode(', ',$data['list']['num']).'</span>
							</div>
						</td>
						<td style="width:20px;"></td>
						'.(count($data['list']['num']) > 0 ? '<td class="exp_cat_bgrey ex_cro3 ex_vcen" style="height:28px; width:28px;" title="Показать этажи подробно">
							<input type="hidden" name="val" value="lev">
							<input type="hidden" name="tog" value="0">
							<div class="ex_imgbox" style="height:20px; width:20px;">
								<svg class="svg" viewBox="0 0 400 400" style="transform: rotate(-90deg);">
									<path d="M305 350c-70,-50 -118,-85 -210,-150l210 -150 0 300z"/>
								</svg>
							</div>
							<div class="ex_abs ex_pos" onClick="EXP_CAT_Tog(this)"></div>
						</td>' : '').'
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>';
		$arr[] = '<div class="ex_rel" style="height:20px;"></div>';
		$arr[] = '<div class="lev ex_rel ex_table ex_hid">
			<div class="row">
				<div class="cel ex_vcen"><span class="ex_f12 ex_fgrey">Этаж</span></div>
				<div class="cel ex_vcen"><span class="ex_f12 ex_fgrey">М<sup>2</sup></span></div>
				<div class="cel ex_vcen"><span class="ex_f12 ex_fgrey"><span class="ruble">р</span> за М</span></div>
				<div class="cel ex_vcen"><span class="ex_f12 ex_fgrey">Цена</div>
			</div>
			'.implode($data['list']['arr']).'
		</div>';
		unset($data);
	}
	return '<div class="ex_rel">'.implode($arr).'</div>';
}
?>