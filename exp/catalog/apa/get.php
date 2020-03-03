<?php
$nest = '../../../';
include_once($nest.'connect.php');
include_once($nest.'host.php');
include_once($nest.'svg.php');
include_once($nest.'function.php');
include_once('../function.php');

if (isset($_GET['set_apa'])) {
	$json = array();
	$json['data'] = CAT_APA_Plan(array('apa'=>$_GET['apa']));
	echo json_encode($json);
} else if (isset($_GET['get_par'])) {
	$json = CAT_APA_Parameters(array('apa'=>$_GET['apa']));
	echo json_encode($json);
} else if (isset($_GET['get_apa'])) {
	$json = array();
	$data = array();
	$get = Get('SELECT * FROM cat_apa WHERE id="'.$_GET['apa'].'";',1,0);
	$data['get_bs'] = Get('SELECT * FROM cat_bs WHERE id="'.$get[0]['bs'].'";',1,0);
	$data['get_zk'] = Get('SELECT * FROM cat_zk WHERE id="'.$get[0]['zk'].'";',1,0);
	$data['term'] = (strlen($data['get_bs'][0]['term'])==5 ? array('q'=>substr($data['get_bs'][0]['term'],4,1), 'Y'=>substr($data['get_bs'][0]['term'],0,4)) : array('q'=>0, 'Y'=>0));
	$data['term']['text'] = $data['term']['q'].' кв '.$data['term']['Y'];
	$sum = Summ(array('area'=>$get[0]['area'], 'cost'=>$get[0]['cost'], 'summ'=>$get[0]['summ']));
	$img = array();
	$img['dir'] = 'img/img/cat_pla/'.$get[0]['pla'];
	$img['src'] = array();
	$arr = array('pla', 'dim', 'meb');
	foreach($arr as $i => $v) {
		if (is_dir($nest.''.$img['dir'].'/'.$v.'/')) {
			$img['files'] = FromDIR(array('dir'=>$nest.''.$img['dir'].'/'.$v.'/', 'exclude'=>array(), 'type'=>"file"));
			if (isset($img['files'][0])) {$img['src'][$v] = $H_hos.'/'.$img['dir'].'/'.$v.'/'.$img['files'][0];}
		}
	}
	unset($arr);
	$data['get_apa'] = Get('SELECT * FROM cat_apa WHERE pla="'.$get[0]['pla'].'" && access!=0;',0,0);
	$data['list'] = array();
	foreach($data['get_apa'] as $i => $v) {
		$sup = Summ(array('area'=>$v['area'], 'cost'=>$v['cost'], 'summ'=>$v['summ']));
		$data['list'][] = '<a href="'.$H_hos.'/exp/catalog/index.php?zk='.$data['get_zk'][0]['id'].'&page=bs&id='.$data['get_bs'][0]['id'].'&path=lev&lev='.$v['level'].'" class="row ex_f14 ex_fblack ex_decno ex_bgover '.($v['id'] != $_GET['apa'] ? '' : 'ex_bggrey').'">
			<div class="cel" style="padding:4px 12px;"><span class="ex_f14">'.$v['level'].'</span></div>
			<div class="cel" style="padding:4px 12px;"><span class="ex_f14 ex_fgrey">'.$v['area'].'</span></div>
			<div class="cel" style="padding:4px 12px;"><span class="ex_f14">'.($sup['cost'] > 2 && (!isset($H_zk_info['ot']) || $H_zk_info['ot'] != 1) ? Price($sup['cost']) : '').'</span></div>
			<div class="cel" style="padding:4px 12px;"><span class="ex_f14">'.($sup['summ'] > 2 && (!isset($H_zk_info['ot']) || $H_zk_info['ot'] != 1) ? Price($sup['summ']) : '').'</span></div>
		</a>';
		unset($sup);
	}
	natsort($data['list']);
	$data['type'] = array(0=>'Квартира', 1=>'Офис', 2=>'М/место', 3=>'Кладовая');
	$json['data'] = '<div class="ex_pos" style="display:flex; align-items:center; justify-content:center;">
		<div class="ex_abs ex_pos" onClick="EXP_CAT_CloseMOD()" style="background:rgba(0,0,0,0.75); z-index:1;"></div>
		<div id="print_apa" class="ex_rel ex_W ex_vcen" style="overflow:auto; background:#FFF; z-index:2;">
			<div class="ex_imgbox ex_vlef ex_bgwhite ex_H">
					<table class="ex_cell ex_rel ex_W" style="height:50px;">
						<tbody>
							<tr>
								<td style="width:20px;"></td>
								<td class="ex_vlef">
									<span class="ex_f18 ex_fgrey">'.$data['type'][(isset($get[0]['type']) ? $get[0]['type'] : 0)].' <b class="ex_fblack">'.$get[0]['name'].'</b></span>
								</td>
								<td></td>
								<td class="ex_vrig">
									<div class="ex_imgbox ex_curs ex_vrig" onClick="EXP_CAT_CloseMOD()" style="width:50px; height:50px;">
										<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['del'].'" style="fill:#000;"/></svg>
									</div>
								</td>
								<td style="width:10px;"></td>
							</tr>
						</tbody>
					</table>
					<div class="ex_rel exp_cat_bfill" style="height:4px;"></div>
					<div class="ex_imgbox" style="padding:20px;" title="Планировка #'.$get[0]['pla'].'">
						<div class="ex_imgbox ex_ofh" style="max-width:500px; z-index:1;" >
							<img id="plaimg" src="'.(isset($img['src']['pla']) ? $img['src']['pla'] : $H_hos.'/img/svg/photo.svg').'" style="max-width:100%; max-height:100%;" alt="pla">
							'.(isset($img['src']['meb']) ? '<img src="'.$img['src']['meb'].'" class="ex_abs ex_pos" alt="meb">' : '').'
							'.(isset($img['src']['dim']) ? '<img src="'.$img['src']['dim'].'" class="ex_abs ex_pos" alt="dim">' : '').'
						</div>
					</div>
					<div class="ex_imgbox" style="padding:40px 0 0 60px; min-width:240px; z-index:1;">
						<div class="ex_rel"><span class="ex_f24 ex_fblack">'.(strlen($get[0]['room'])>0 ? '<b>'.$get[0]['room'].'</b> к &#8195; ' : '').'<b>'.number_format($sum['area'], '2', '.', ' ').'</b> м<sup>2</sup></span></div>
						<div class="ex_rel" style="height:10px;"></div>
						'.(strlen($sum['summ']) > 2 ? '<div class="ex_rel"><span class="ex_f32"><b class="ex_fblack">'.number_format($sum['summ'], '0', '.', ' ').' </b><span class="ruble">р</span></span></div><div class="ex_rel" style="height:10px;"></div>' : '').'
						'.(strlen($sum['cost']) > 2 ? '<div class="ex_rel"><span class="ex_f18 ex_fblack">'.number_format($sum['cost'], '0', '.', ' ').' <span class="ruble">р</span>/м<sup>2</sup></span></div>' : '').'
						<div class="ex_rel" style="margin-top:20px;">
							<div class="callcat ex_imgbox exp_cat_bhave ex_f14 ex_cro3 ex_W ex_vcen ex_bobo" style="padding:9px;">
								<input type="hidden" name="print[zk]" value="'.$get[0]['zk'].'">
								<input type="hidden" name="print[apa]" value="'.$get[0]['id'].'">
								<span>Заказать звонок</span>
							</div>
						</div>
						<div class="ex_rel" style="margin-top:20px;">
							<span class="ex_f14">Секция <b class="ex_f18">'.$data['get_bs'][0]['name'].'</b>&#8195; Этаж <b class="ex_f18">'.$get[0]['level'].'</b></span><br>
							<span class="ex_f14"><span class="ex_fgrey">срок сдачи</span> <span class="ex_f18">'.$data['term']['text'].'</span></span>
						</div>
						<div class="ex_rel ex_table" style="margin-top:20px;">
							<div class="row">
								<div class="cel ex_vcen"><span class="ex_f12 ex_fgrey">Этаж</span></div>
								<div class="cel ex_vcen"><span class="ex_f12 ex_fgrey">М<sup>2</sup></span></div>
								<div class="cel ex_vcen"><span class="ex_f12 ex_fgrey"><span class="ruble">р</span> за М</span></div>
								<div class="cel ex_vcen"><span class="ex_f12 ex_fgrey">Цена</div>
							</div>
							'.implode($data['list']).'
						</div>
						<div class="ex_rel">
							<div class="print_s ex_imgbox">
								<div class="ex_rel" style="height:20px;"></div>
								<div class="printcat ex_imgbox exp_cat_bgrey ex_cro3" alt="print_apa">
									<table class="ex_cell">
										<tbody>
											<tr>
												<td style="width:10px;"></td>
												<td>
													<div class="ex_imgbox" style="width:32px; height:32px;">
														<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['print'].'"/></svg>
													</div>
												</td>
												<td style="width:10px;"></td>
												<td><span class="ex_f14">Печать</span></td>
												<td style="width:20px;"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							'.($_GET['user'] == 7 ? '<div class="email_s ex_imgbox">
								<div class="ex_rel" style="height:20px;"></div>
								<div class="emailcat ex_imgbox exp_cat_bgrey ex_cro3" alt="email_apa">
									<table class="ex_cell">
										<tbody>
											<tr>
												<td style="width:10px;"></td>
												<td>
													<div class="ex_imgbox" style="width:32px; height:32px;">
														<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['mail'].'"/></svg>
													</div>
												</td>
												<td style="width:10px;"></td>
												<td><span class="ex_f14">Отослать</span></td>
												<td style="width:20px;"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>' : '').'
						</div>
					</div>
					<div class="ex_rel" style="height:40px;"></div>
			</div>
		</div>
	</div>';
	unset($data);
	echo json_encode($json);
}

include_once($nest.'close.php');
?>