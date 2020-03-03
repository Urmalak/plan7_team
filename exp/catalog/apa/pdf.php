<?php
$nest = '../../../';
require_once($nest.'connect.php');
require_once($nest.'host.php');
require_once($nest.'function.php');

if (isset($_GET['pdf_apa'])) {
	$data = array();
	$get = Get('SELECT * FROM cat_apa WHERE id="'.$_GET['apa'].'";',1,0);
	$data['apa'] = $get[0];
	unset($get);
	$get = Get('SELECT * FROM cat_bs WHERE id="'.$data['apa']['bs'].'";',1,0);
	$data['bs'] = $get[0];
	unset($get);
	if (isset($data['bs'])) {
		$get = Get('SELECT * FROM cat_lev WHERE bs="'.$data['bs']['id'].'" ORDER BY ord, id DESC;',0,0);
		foreach($get as $i => $v) {
			$area = unserialize($v['area']);
			if (is_array($area)) {
				foreach($area as $j => $u) {
					if (is_array($u['obj']) && in_array($data['apa']['id'], $u['obj'])) {
						$data['lev'] = array('id'=>$v['id'], 'dot'=>$u['dot']);
					}
				}
			}
			unset($area);
		}
		unset($get);
		$get = Get('SELECT * FROM cat_ent WHERE bs="'.$data['bs']['id'].'";',0,0);
		$data['levmax'] = array(0, 0);
		foreach($get as $i => $v) {
			$ent = array();
			$ent['level'] = (strlen($v['level'])>2 ? explode("," ,$v['level']) : array(0, 0));
			if ($data['levmax'][0] < $ent['level'][0]) {$data['levmax'][0] = round($ent['level'][0]);}
			if ($data['levmax'][1] < $ent['level'][1]) {$data['levmax'][1] = round($ent['level'][1]);}
			unset($ent);
		}
		unset($get);
	}
	$get = Get('SELECT * FROM cat_zk WHERE id="'.$data['apa']['zk'].'";',1,0);
	$data['zk'] = $get[0];
	$data['zk_info'] = unserialize($data['zk']['info']);
	unset($get);
	$get = Get('SELECT * FROM cat_sk WHERE id="'.$data['zk']['sk'].'";',1,0);
	$data['sk'] = $get[0];
	$data['sk_info'] = unserialize($data['sk']['info']);
	unset($get);
	$get = Get('SELECT * FROM p7_city WHERE id="'.$data['zk']['city'].'";',1,0);
	$data['city'] = $get[0];
	$data['city_rn'] = unserialize($data['city']['rn']);
	unset($get);
	$data['get_apa'] = Get('SELECT * FROM cat_apa WHERE bs="'.$data['bs']['id'].'" && access=1;',0,0);
	$data['mix'] = array('min'=>0, 'max'=>0);
	foreach($data['get_apa'] as $i => $v) {
		if ($data['mix']['min'] == 0 || $data['mix']['min'] > $v['area']) {$data['mix']['min'] = $v['area'];}
		if ($data['mix']['max'] < $v['area']) {$data['mix']['max'] = $v['area'];}
	}
	$data['sum'] = Summ(array('area'=>$data['apa']['area'],'cost'=>$data['apa']['cost'],'summ'=>$data['apa']['summ']));
	$term = Term(array('term'=>$data['bs']['term'], 'co'=>5));
	$data['rn'] = '';
	foreach($data['city_rn'] as $i => $v) {
		if ($v['id'] == $data['zk']['rn']) {$data['rn'] = $v['name'].' р-н,';}
	}
	$data['lay'] = array('pla', 'meb', 'dim');
	$data['img'] = array();
	$data['dir'] = 'img/img/cat_pla/'.$data['apa']['pla'];
	if (strlen($data['apa']['pla']) > 0) {
		foreach($data['lay'] as $i => $v) {
			if (is_dir($nest.''.$data['dir'].'/'.$v.'/')) {
				$data['f'] = FromDIR(array('dir'=>$nest.''.$data['dir'].'/'.$v.'/','type'=>"file"));
				if (isset($data['f'][0])) {
					$data['img'][$v] = $v.'/'.$data['f'][0];
				}
			}
		}
	}
	$dir = 'img/img/cat_zk/'.$data['zk']['id'].'/pre/';
	if (is_dir($nest.''.$dir)) {
		$data['f'] = FromDIR(array('dir'=>$nest.''.$dir,'type'=>"file"));
		if (isset($data['f'][0])) {
			$data['img']['zk'] = $H_hos.'/'.$dir.''.$data['f'][0];
		}
	}
	unset($dir);
	$dir = 'img/img/cat_sk/'.$data['sk']['id'].'/logo/';
	if (is_dir($nest.''.$dir)) {
		$data['f'] = FromDIR(array('dir'=>$nest.''.$dir,'type'=>"file"));
		if (isset($data['f'][0])) {
			$data['img']['sk'] = $H_hos.'/'.$dir.''.$data['f'][0];
		}
	}
	unset($dir);
	$dir = 'img/img/cat_lev/'.$data['lev']['id'].'/pla/';
	if (is_dir($nest.''.$dir)) {
		$data['f'] = FromDIR(array('dir'=>$nest.''.$dir,'type'=>"file"));
		if (isset($data['f'][0])) {
			$data['img']['lev'] = $dir.''.$data['f'][0];
		}
	}
	unset($dir);
	require_once($nest.'ad/lib/FPDF/fpdf.php');
	define('FPDF_FONTPATH',$nest.'ad/lib/FPDF/font/');
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->AddFont('Arial','','arial.php');
	$pdf->AddFont('Arialbd','B','arialbd.php');
	$data['spa'] = array('W'=>$pdf->GetPageWidth(), 'H'=>$pdf->GetPageHeight());
	$data['W'] = $pdf->GetPageWidth();
	$data['H'] = $pdf->GetPageHeight();
	$pdf->Ln(5);
	$pdf->SetFont('Arial', '', '10');
	$pdf->Cell(2, 0, '');
	$pdf->Cell(32, 0, '');
	$pdf->Cell(32, 0, iconv('utf-8', 'windows-1251', 'площадь'));
	$pdf->Cell(28, 0, iconv('utf-8', 'windows-1251', 'этаж'));
	if (strlen($data['sum']['cost']) > 2) {
		$pdf->Cell(38, 0, iconv('utf-8', 'windows-1251', 'цена за метр'));
	}
	if (strlen($data['sum']['summ']) > 2) {
		$pdf->Cell(38, 0, iconv('utf-8', 'windows-1251', 'стоимость'));
	}
	$pdf->Cell(20, 0, iconv('utf-8', 'windows-1251', 'квартира'));
	$pdf->Ln(5);
	$pdf->SetFont('Arial', '', '28');
	$pdf->Cell(2, 0, '');
	$pdf->Cell(32, -3, iconv('utf-8', 'windows-1251', $data['apa']['room'].'к'));
	$pdf->SetFont('Arialbd', 'B', '12');
	$pdf->Cell(32, 0, $data['apa']['area']);
	$pdf->Cell(28, 0, $data['apa']['level']);
	if (strlen($data['sum']['cost']) > 2) {
		$pdf->Cell(38, 0, number_format($data['sum']['cost'], 0, '.', ' '));
	}
	if (strlen($data['sum']['summ']) > 2) {
		$pdf->Cell(38, 0, number_format($data['sum']['summ'], 0, '.', ' '));
	}
	$pdf->Cell(20, 0, iconv('utf-8', 'windows-1251', '№ '.$data['apa']['name']));
	$pdf->Line(10, 26, $data['spa']['W'] - 10, 26);
	$data['box'] = 120;
	$data['gab'] = array('W'=>0, 'H'=>0, 'L'=>0);
	if (isset($data['img']['pla'])) {
		$data['sim'] = getimagesize($nest.''.$data['dir'].'/'.$data['img']['pla']);
		if ($data['sim'][0] > $data['sim'][1]) {
			$data['gab']['W'] = $data['box'];
			$data['gab']['H'] = round($data['sim'][1] * ($data['gab']['W'] / $data['sim'][0]));
		} else {
			$data['gab']['H'] = $data['box'];
			$data['gab']['W'] = round($data['sim'][0] * ($data['gab']['H'] / $data['sim'][1]));
		}
		$data['gab']['L'] = round(($data['spa']['W'] - $data['gab']['W']) * 0.5);
	}
	foreach($data['lay'] as $i => $v) {
		if (isset($data['img'][$v])) {
			$pdf->Image($H_hos.'/'.$data['dir'].'/'.$data['img'][$v], $data['gab']['L'], 35, $data['gab']['W']);
		}
	}
	$data['cur'] = $data['gab']['H'] + 30;
	$pdf->Ln($data['cur']);
	$pdf->SetFont('Arialbd', 'B', '16');
	$pdf->Cell(0, 0, iconv('utf-8', 'windows-1251', 'ЖК '.$data['zk']['name']));
	$pdf->Ln(5);
	$pdf->SetFont('Arial', '', '14');
	$pdf->Cell(0, 0, iconv('utf-8', 'windows-1251', 'Блок-секция '.$data['bs']['name']));
	$pdf->Ln(8);
	$pdf->SetFont('Arial', '', '10');
	$pdf->Line(10, $data['cur'] + 40, 120, $data['cur'] + 40);
	$pdf->Line(10, $data['cur'] + 48, 120, $data['cur'] + 48);
	$pdf->Line(10, $data['cur'] + 56, 120, $data['cur'] + 56);
	$pdf->Line(10, $data['cur'] + 64, 120, $data['cur'] + 64);
	$pdf->Cell(0, 0, iconv('utf-8', 'windows-1251', $data['city']['name'].', '.$data['rn'].' '.$data['zk_info']['adres']));
	$pdf->Ln(11);
	$pdf->SetFont('Arial', '', '10');
	$pdf->Cell(40, 0, iconv('utf-8', 'windows-1251', 'Этажность'));
	$pdf->SetFont('Arialbd', 'B', '10');
	$pdf->Cell(70, 0, iconv('utf-8', 'windows-1251', $data['levmax'][1]), 0, 0, 'R');
	$pdf->Ln(8);
	$pdf->SetFont('Arial', '', '10');
	$pdf->Cell(40, 0, iconv('utf-8', 'windows-1251', 'Площадь квартир'));
	$pdf->SetFont('Arialbd', 'B', '10');
	$pdf->Cell(70, 0, iconv('utf-8', 'windows-1251', 'от '.$data['mix']['min'].' до '.$data['mix']['max'].' м. кв.'), 0, 0, 'R');
	$data['cur'] += 22;
	$pdf->Ln(8);
	$pdf->SetFont('Arial', '', '10');
	$pdf->Cell(40, 0, iconv('utf-8', 'windows-1251', 'Срок сдачи'));
	$pdf->SetFont('Arialbd', 'B', '10');
	$pdf->Cell(70, 0, iconv('utf-8', 'windows-1251', $term['q'].' кв '.$term['Y']), 0, 0, 'R');
	if (isset($data['img']['zk'])) {$pdf->Image($data['img']['zk'], 125, $data['cur'], 75);}
	$pdf->AddPage();
	$data['cur'] = 20;
	$data['box'] = 140;
	$data['gab'] = array('W'=>0, 'H'=>0, 'L'=>0);
	if (isset($data['img']['lev'])) {
		$data['sim'] = getimagesize($nest.''.$data['img']['lev']);
		if ($data['sim'][0] > $data['sim'][1]) {
			$data['gab']['W'] = $data['box'];
			$data['gab']['H'] = round($data['sim'][1] * ($data['gab']['W'] / $data['sim'][0]));
		} else {
			$data['gab']['H'] = $data['box'];
			$data['gab']['W'] = round($data['sim'][0] * ($data['gab']['H'] / $data['sim'][1]));
		}
		$data['gab']['L'] = round(($data['spa']['W'] - $data['gab']['W']) * 0.5);
		$pdf->Image($H_hos.'/'.$data['img']['lev'], $data['gab']['L'], $data['cur'], $data['gab']['W']);
	}
	$data['cur'] += $data['gab']['H'] + 10;
	$pdf->Ln($data['gab']['H'] + 30);
	$pdf->Line(10, $data['cur'], 155, $data['cur']);
	$pdf->SetFont('Arial', '', '12');
	$pdf->Cell(50, 0, iconv('utf-8', 'windows-1251', 'Отдел продаж'), 0, 0, 'L');
	$pdf->Cell(70, 0, iconv('utf-8', 'windows-1251', $data['sk']['name']), 0, 0, 'L');
	$pdf->SetFont('Arial', '', '10');
	$pdf->Ln(8);
	$pdf->Cell(50, 0, $data['zk_info']['tel'], 0, 0, 'L');
	$pdf->Cell(70, 0, iconv('utf-8', 'windows-1251', $data['zk_info']['skadres']), 0, 0, 'L');
	$pdf->Ln(5);
	$pdf->Cell(50, 0, $data['zk_info']['site'], 0, 0, 'L');
	if (isset($data['img']['sk'])) {$pdf->Image($data['img']['sk'], 160, $data['cur'], 40);}
	$f = 'mail.pdf';
	if (!is_dir('pdf/')) {$mkdir = mkdir('pdf/',0755);}
	$pdf->Output('pdf/'.$f,'F');
	$json = array();
	$json['pdf'] = 'exp/catalog/apa/pdf/'.$f;
	$json['subject'] = 'Информация. Квартира №'.$data['apa']['name'].' ЖК '.$data['zk']['name'].' - Блок-секция '.$data['bs']['name'];
	echo json_encode($json);
	unset($data);
}

require_once($nest.'close.php');
?>