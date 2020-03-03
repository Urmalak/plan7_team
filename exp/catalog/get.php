<?php
$nest = '../../';
include_once($nest.'connect.php');
include_once($nest.'host.php');
include_once($nest.'svg.php');
include_once($nest.'function.php');

if (isset($_GET['get_call'])) {
	$get = Get('SELECT * FROM cat_zk WHERE id="'.$_GET['zk'].'";',1,0);
	$info = unserialize($get[0]['info']);
	$json = array();
	$json['data'] = '<div class="ex_rel" style="padding:20px; min-width:260px;">
			<h2>Заказ звонка</h2>
			<h3>ЖК '.$get[0]['name'].'</h3>
			<div class="ex_rel" style="height:20px;"></div>
			<form action="'.$H_hos.'/exp/mail/get.php" class="ex_W" target="rFrame" enctype="multipart/form-data" method="post">
				<input type="hidden" name="send_mail" value="1">
				<input type="hidden" name="send[to]" value="'.$info['mail'].'">
				<input type="hidden" name="upd[page]" value="'.$H_hos.''.$_SERVER['REQUEST_URI'].'">
				<input type="hidden" name="upd[type]" value="cat">
				<input type="hidden" name="upd[city]" value="'.$get[0]['city'].'">
				<input type="hidden" name="send[message][0]" value="Имя: ">
				<input type="text" class="exp_cat_bblue ex_cro3 ex_W ex_bobo" name="send[message][1]" placeholder="Имя Отчество" style="padding:5px 12px;">
				<div class="ex_rel" style="height:10px;"></div>
				<input type="hidden" name="send[message][2]" value="Телефон: ">
				<input type="text" class="exp_cat_bblue ex_cro3 ex_W ex_bobo" name="send[message][3]" placeholder="Ваш телефон" style="padding:5px 12px;">
				<div class="ex_rel" style="height:10px;"></div>
				<div class="form_text ex_rel"></div>
				<div class="ex_rel" style="height:10px;"></div>
				<input type="submit" class="exp_cat_bhave ex_cro3" value="Отправить" style="padding:5px 12px; margin-right:10px;" onClick="$(this).fadeOut(10).delay(900).fadeIn(900); yaCounter10482295.reachGoal(`submit_zvonka_1`); return true;">
				<input type="button" class="exp_cat_bblue ex_cro3" value="Закрыть" style="padding:5px 12px;" onClick="$(`.remove`).remove()">
			</form>
	</div>';
	echo json_encode($json);
}

include_once($nest.'close.php');
?>