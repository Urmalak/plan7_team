<script src="bs/lev/script.js"></script>
<div class="ex_rel ex_vcen" style="margin:40px 25px;">
	<div class="exp_cat_flox">
		<div style="flex: 1 1 66%;">
			<div class="set_box_one ex_rel">
				<?php
				include_once('bs/lev/page.php');
				?>
			</div>
			<div class="set_box_two ex_rel ex_hid"></div>
			<div class="ex_rel" style="height:20px;"></div>
		</div>
		<div style="flex: 1 1 34%; border-left: #CCC 1px solid; min-height: 700px;">
			<div class="ex_imgbox ex_vlef" style="padding: 10px;">
				<div class="ex_rel">
					<div class="callcat ex_imgbox exp_cat_bhave ex_f14 ex_cro3 ex_W ex_vcen ex_bobo" style="padding:10px;">
						<input type="hidden" name="print[zk]" value="<?php echo $HEAD['zk']['id']; ?>">
						<input type="hidden" name="print[apa]" value="0">
						<span class="ex_f16">ОТПРАВИТЬ ЗАЯВКУ</span>
					</div>
				</div>
				<div class="ex_rel" style="height: 20px;"></div>
				<div class="apa_param ex_rel">
					<div class="ex_rel ex_bord" style="padding: 10px;">
						<span class="ex_f18">Блок-секция №<?php echo $HEAD['n_bs']['name']; ?></span>
						<div class="ex_rel" style="height: 5px;"></div>
						<span class="ex_f12 ex_fgrey">ЖК <?php echo $HEAD['zk']['name']; ?></span>
					</div>
					<p class="ex_f12 ex_fgrey">Наведите курсор на квартиру<br>чтобы увидеть её параметры</p>
				</div>
				<div class="ex_rel" style="height: 40px;"></div>
				<table class="ex_cell">
					<tbody>
						<tr>
							<td>
								<div class="ex_rel ex_cro16" style="width: 32px; height: 32px; background: #<?php echo $HEAD['sty']['f']; ?>;"></div>
							</td>
							<td style="width:10px;"></td>
							<td>
								<span class="ex_f12">Доступно для<br>покупки</span>
							</td>
							<td style="width:40px;"></td>
							<td>
								<div class="ex_rel ex_cro16" style="width: 32px; height: 32px; background: #CCC;"></div>
							</td>
							<td style="width:10px;"></td>
							<td>
								<span class="ex_f12">Куплено</span>
							</td>
							<td style="width:40px;"></td>
						</tr>
					</tbody>
				</table>
				<div class="ex_rel" style="height: 20px;"></div>
			</div>
		</div>
	</div>
</div>