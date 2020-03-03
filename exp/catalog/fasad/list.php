<?php
		$data = array();
		if (!isset($data['get'][0])) {
			if (isset($HEAD['n_bs'])) {
				$data['get'] = Get('SELECT * FROM cat_fas WHERE zk="'.$HEAD['zk']['id'].'" && bs=0 ORDER BY ord, id DESC;',0,0);
			} else {
				$data['get'] = Get('SELECT * FROM cat_fas WHERE zk="'.$HEAD['zk']['id'].'" ORDER BY ord, id DESC;',1,0);
			}
		} else if (isset($HEAD['n_bs'])) {
			$data['get'] = Get('SELECT * FROM cat_fas WHERE bs="'.$HEAD['n_bs']['id'].'" ORDER BY ord, id DESC;',0,0);
		} else {
			$data['get'] = Get('SELECT * FROM cat_fas WHERE zk="'.$HEAD['zk']['id'].'" && bs=0 ORDER BY ord, id DESC;',1,0);
		}
		if (isset($data['get'][0])) {
			$data['fas'] = $data['get'][0];
			$data['dir'] = 'img/img/cat_fas';
			$data['img'] = array();
			$data['img']['dir'] = $data['dir'].'/'.$data['fas']['id'].'/pla/';
			if (is_dir('../../'.$data['img']['dir'])) {
				$data['img']['files'] = FromDIR(array('dir'=>'../../'.$data['img']['dir'],'exclude'=>array(),'type'=>"file"));
				if ($data['img']['files'][0]) {$data['img']['src'] = $H_hos.'/'.$data['img']['dir'].''.$data['img']['files'][0];}
			}
			$data['area'] = unserialize($data['fas']['area']);
			if (!is_array($data['area'])) {$data['area'] = array();}
			$data['path'] = array();
			$data['divs'] = array();
			foreach($data['area'] as $i => $v) {
				$data['id'] = 'area_'.$i;
				if (isset($v['bs']) && isset($v['lev']) && is_array($v['lev'])) {
					$data['get_bs'] = Get('SELECT * FROM cat_bs WHERE id="'.$v['bs'].'";',1,0);
					$data['get_apa'] = Get('SELECT * FROM cat_apa WHERE bs="'.$v['bs'].'" && level IN ('.implode(',', $v['lev']).') && access=1;',0,0);
					sort($v['lev']);
					$data['let'] = array();
					$data['lar'] = array('co'=>$v['lev'][0], 'now'=>$v['lev'][0], 'last'=>$v['lev'][0]);
					foreach($v['lev'] as $j => $u) {
						if ($data['lar']['co'] < $u) {
							$data['let'][] = ($data['lar']['now'] == $data['lar']['last'] ? $data['lar']['now'] : $data['lar']['last'].'-'.$data['lar']['now']);
							$data['lar']['last'] = $u;
							$data['lar']['co'] = $u;
						}
						if ($j >= count($v['lev']) - 1) {
							$data['let'][] = ($u == $data['lar']['last'] ? $u : $data['lar']['last'].'-'.$u);
						}
						$data['lar']['now'] = $u;
						$data['lar']['co']++;
					}
					unset($data['lar']);
					$data['lev'] = implode(', ',$data['let']).' Этаж'.(count($v['lev'])>1 ? 'и' : '');
					$data['path'][] = '<path d="M'.$v['dot'].'z" class="area_pat area_ches exp_svg_area" alt="'.$data['id'].'" />';
					$data['divs'][] = '<div id="'.$data['id'].'">
						<div class="ex_imgbox ex_vcen ex_bord" style="background:#FFF; padding:6px 12px;">
							<span class="ex_f18 exp_cat_fblue">Секция '.$data['get_bs'][0]['name'].'</span><br><br>
							<a href="'.$HEAD['pat'].'&page=bs&id='.$v['bs'].'&path=lev&lev='.$v['lev'][0].'" class="exp_cat_bblue ex_cro5" style="padding:4px 12px;">'.$data['lev'].'</a><br><br>
							<span class="ex_f14">Свободно <b>'.count($data['get_apa']).'</b> '.Padez(array('квартира','квартиры','квартир'), count($data['get_apa'])).'</span>
							<div class="close ex_abs ex_cro12 ex_bord ex_bgwhite ex_curs" style="right:-12px; top:-12px; width:24px; height:24px;">
								<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['del'].'" style="fill:#000;"/></svg>
							</div>
						</div>
					</div>';
				} else {
					$data['path'][] = '<path d="M'.$v['dot'].'z" class="area_pat area_ches exp_svg_grey" alt="'.$data['id'].'" />';
					$data['divs'][] = '<div id="'.$data['id'].'">
						<div class="ex_imgbox ex_vcen ex_bord" style="background:#FFF; padding:6px 12px;">
							<span class="ex_f18 exp_cat_fblue">'.$data['lev'].'</span>
							<div class="close ex_abs ex_cro12 ex_bord ex_bgwhite ex_curs" style="right:-12px; top:-12px; width:24px; height:24px;">
								<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['del'].'" style="fill:#000;"/></svg>
							</div>
						</div>
					</div>';
				}
				unset($data['id']);
			}
			echo '<div class="ex_imgbox ex_vcen" style="max-width:100%;">
				<img src="'.(isset($data['img']['src']) ? $data['img']['src'] : $H_hos.'/img/photo.svg').'" class="area_svg" style="max-width:100%;" alt="fas">
				<svg class="ex_abs ex_pos" preserveAspectRatio="none">'.implode($data['path']).'</svg>
				<div class="ex_hid">'.implode($data['divs']).'</div>
			</div>';
			unset($data);
		}
?>