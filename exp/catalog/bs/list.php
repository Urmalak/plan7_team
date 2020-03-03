<div class="ex_rel" style="margin:10px;">
	<?php
	if (isset($HEAD['bs'])) {
		$preview = $H_hos.'/img/photo.png';
		$dir = 'img/img/cat_zk/'.$HEAD['zk']['id'].'/pre/';
		if (is_dir('../../'.$dir)) {
			$file = FromDIR(array('dir'=>'../../'.$dir,'type'=>"file"));
			if (isset($file[0])) {$preview = ImgHTTP($H_hos.'/'.$dir.''.$file[0]);}
			unset($file);
		}
		unset($dir);
		$arr = array();
		foreach($HEAD['bs'] as $i => $v) {
			$data = array();
			$data['img'] = array();
			$data['img']['dir'] = 'img/img/cat_bs/'.$v['id'].'/pre/';
			if (is_dir('../../'.$data['img']['dir'])) {
				$file = FromDIR(array('dir'=>'../../'.$data['img']['dir'],'type'=>"file"));
				if (isset($file[0])) {$data['img']['src'] = ImgHTTP($H_hos.'/'.$data['img']['dir'].''.$file[0]);}
				unset($file);
			}
			$data['info'] = unserialize($v['info']);
			$data['term'] = Term(array('term'=>$v['term'], 'co'=>5));
			$data['term']['text'] = (!isset($data['term']) || $data['term']['E'] == 1 || (isset($v['sdan']) && $v['sdan'] == 'on') ? 'Сдан' : $data['term']['q'].' кв '.$data['term']['Y']);
			$data['lev'] = 0;
			$data['get_ent'] = Get('SELECT * FROM cat_ent WHERE bs="'.$v['id'].'";',0,0);
			foreach($data['get_ent'] as $j => $u) {
				$data['ent'] = array();
				$data['ent']['level'] = (strlen($u['level'])>2 ? explode("," ,$u['level']) : array(0, 0));
				$data['ent']['lev'] = $data['ent']['level'][0] + $data['ent']['level'][1];
				if ($data['ent']['lev'] > $data['lev']) {$data['lev'] = $data['ent']['lev'];}
				unset($data['ent']);
			}
			$data['get_apa'] = Get('SELECT * FROM cat_apa WHERE bs="'.$v['id'].'" && access=1;',0,0);
			$data['rat'] = array('cost'=>0, 'summ'=>0);
			foreach($data['get_apa'] as $j => $u) {
				$data['apa'] = array();
				$data['apa']['sum'] = Summ(array('area'=>$u['area'], 'cost'=>$u['cost'], 'summ'=>$u['summ']));
				if (($data['apa']['sum']['cost'] < $data['rat']['cost'] || $data['rat']['cost'] == 0) && $data['apa']['sum']['cost'] > 2) {
					$data['rat']['cost'] = $data['apa']['sum']['cost'];
				}
				if (($data['apa']['sum']['summ'] < $data['rat']['summ'] || $data['rat']['summ'] == 0) && $data['apa']['sum']['summ'] > 2) {
						$data['rat']['summ'] = $data['apa']['sum']['summ'];
				}
				unset($data['apa']);
			}
			$data['arr'] = array(0=>'Секция', 1=>'БЦ', 2=>'Парковка', 3=>'Секция');
			$data['type'] = $HEAD['type'][(isset($v['type']) ? $v['type'] : 0)];
			$data['padez'] = array($data['type']['name'].''.$data['type'][1], $data['type']['name'].''.$data['type'][2], $data['type']['name'].''.$data['type'][5]);
			$arr[] = '<div class="item ex_curs" style="background:#FFF;">
				<a href="'.$HEAD['pat'].'&page=bs&id='.$v['id'].'" class="ex_fblack ex_decno" title="Блок-секция '.$v['name'].'">
					<div class="ex_rel exp_cat_shadover" style="margin:15px;">
						<div class="ex_rel" style="padding:15px;">
							<span class="ex_f14">'.$data['arr'][(isset($v['type']) ? $v['type'] : 0)].' '.$v['name'].'</span>
							<div class="ex_rel" style="height:5px;"></div>
							<strong class="ex_f24"><span class="ex_fgrey">ЖК </span>'.$HEAD['zk']['name'].'</strong>
							<div class="ex_rel" style="height:5px;"></div>
							<span class="ex_f14 ex_fblack">'.$HEAD['city']['name'].', <span class="ex_fgrey">'.$HEAD['rn']['name'].' р-н'.(isset($HEAD['zk_info']) && isset($HEAD['zk_info']['adres']) ? '</span><span class="ex_fblack">'.(isset($data['info']) && isset($data['info']['adres']) ? ', '.$data['info']['adres'] : '').'</span>' : '').'</span>
							<div class="ex_abs" style="right:0px; top:0px; padding:10px; background:#EEE; border-radius:0 0 0 5px;">
								<span class="ex_f14" style="color:#999;">'.$data['term']['text'].'</span>
							</div>
						</div>
						<div class="ex_rel ex_W" style="padding-top:60%;">
							<div class="ex_abs ex_gab ex_ofh">
								<img src="'.(isset($data['img']['src']) ? $data['img']['src'] : (isset($preview) ? $preview : $H_hos.'/img/svg/photo.svg')).'" class="ex_imgfit" alt="pre" title="'.$HEAD['zk']['name'].'">
							</div>
						</div>
						<div class="ex_rel" style="padding:15px;">
							<table class="ex_cell ex_W">
								<tbody>
									<tr>
										<td><span class="ex_f14 exp_cat_fblue">Свободно '.count($data['get_apa']).' '.Padez($data['padez'],count($data['get_apa'])).'</span></td>
										<td class="ex_vrig"><span class="ex_f14">'.$data['lev'].' '.Padez(array('этаж','этажа','этажей'),$data['lev']).'</span></td>
									</tr>
								</tbody>
							</table>
							<div class="ex_rel" style="height:10px;"></div>
							<div class="ex_rel"><b class="ex_f24">от '.P7_Price(array('num'=>$data['rat']['summ'],'nope'=>2)).' <span class="ruble">р</span></b></div>
							<div class="ex_rel"><span class="ex_f14 ex_fgrey">от '.P7_Price(array('num'=>$data['rat']['cost'],'nope'=>2)).' <span class="ruble">р</span> / м<sup>2</sup></span></div>
						</div>
					</div>
				</a>
			</div>';
			unset($data);
		}
		echo '<div class="exp_cat_flex">'.implode($arr).'</div>';
		unset($arr);
		unset($preview);
	}
	?>
</div>