<?php
if (isset($_GET['apa']) && $_GET['apa'] > 0) {
	$data = array();
	$get = Get('SELECT * FROM cat_apa WHERE id="'.$_GET['apa'].'";',1,0);
	if (isset($get[0])) {$data['apa'] = $get[0];}
	unset($get);
	$get = Get('SELECT * FROM cat_bs WHERE id="'.$data['apa']['bs'].'";',1,0);
	if (isset($get[0])) {$data['bs'] = $get[0];}
	unset($get);
}
?>
<div class="ex_rel ex_vcen" style="max-width: 1400px; padding: 20px;">
	<div class="exp_cat_flox">
		<div style="flex: 1 1 66%;">
			<div class="set_box_one ex_rel">
				<?php
				echo CAT_APA_Plan(array('apa'=>$_GET['apa'], 'nest'=>'../../', 'url'=>(isset($_COOKIE['referer']) && strlen($_COOKIE['referer']) > 12 ? $_COOKIE['referer'] : NULL)));
				?>
			</div>
			<div class="set_box_two ex_rel ex_hid"></div>
			<div class="ex_rel" style="height:20px;"></div>
		</div>
		<div style="flex: 1 1 34%; border-left: #CCC 1px solid; min-height: 700px;">
			<div class="ex_imgbox ex_vlef" style="padding: 10px; min-width: 280px;">
				<div class="ex_rel">
					<div class="callcat ex_imgbox exp_cat_bhave ex_f14 ex_cro3 ex_W ex_vcen ex_bobo" style="padding:10px;">
						<input type="hidden" name="print[zk]" value="<?php echo $HEAD['zk']['id']; ?>">
						<input type="hidden" name="print[apa]" value="<?php echo $_GET['apa']; ?>">
						<span>ОТПРАВИТЬ ЗАЯВКУ</span>
					</div>
				</div>
				<div class="ex_rel" style="height: 20px;"></div>
				<div class="apa_param ex_rel">
					<?php
					echo CAT_APA_Parameters(array('apa'=>$_GET['apa']));
					?>
				</div>
				<div class="ex_rel" style="height: 40px;"></div>
			</div>
		</div>
	</div>
</div>
<?php
unset($data);
?>