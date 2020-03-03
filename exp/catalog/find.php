<div id="cookdiv" class="ex_rel" style="background:#EEE; padding-bottom:15px; z-index:3;">
	<div class="exp_cat_flex" style="padding:10px 25px;">
		<?php
		if (isset($HEAD['typs']) && count($HEAD['typs']) > 1) {
			$data = array('opt'=>array());
			$data['tit'] = array(0=>'Квартиры', 1=>'Офисы', 2=>'Парковки', 3=>'Кладовые');
			foreach($data['tit'] as $i => $v) {
				$data['opt'][] = (in_array($i, $HEAD['typs']) ? '<div class="ex_rel ex_bgover ex_wrap" style="padding:5px 10px;"><input type="checkbox" name="type" style="margin-right:10px;"><b class="ex_f14">'.$v.'</b><div class="ex_abs ex_pos" onClick="EXP_CAT_Chek(this)"></div></div>' : '<input type="checkbox" class="ex_hid" name="type">');
			}
			echo '<div class="find type ex_imgbox exp_cat_shadover ex_cro3 ex_bgwhite" style="width:254px; height:32px; margin:15px 15px 0 0; z-index:2;">
				<table class="ex_cell ex_pos">
					<tbody>
						<tr class="ex_vlef ex_vmid">
							<td style="width:25px;"></td>
							<td>
								<span class="text ex_f14 ex_fgrey">Тип помещения</span>
							</td>
							<td style="width:20px;">
								<div class="ex_imgbox" style="width:20px; height:20px;">
									<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['arwb'].'" style="fill:#CCC;"/></svg>
								</div>
							</td>
							<td style="width:20px;"></td>
						</tr>
					</tbody>
				</table>
				<div class="ex_abs ex_pos">
					<div class="ex_abs hidden ex_hid ex_curs ex_W" style="height:0px; bottom:0px;">
						<div class="ex_rel ex_bord ex_vlef" style="background:#FFF;">
							'.implode($data['opt']).'
						</div>
					</div>
					<div class="ex_abs ex_pos ex_curs" onClick="$(this).parent().find(`.hidden`).show()"></div>
				</div>
			</div>';
		}
		?>
		<div class="find room ex_imgbox exp_cat_shadover ex_cro3 ex_bgwhite" style="width:254px; height:32px; margin:15px 15px 0 0; z-index:2;">
			<table class="ex_cell ex_pos">
				<tbody>
					<tr class="ex_vlef ex_vmid">
						<td style="width:25px;"></td>
						<td>
							<span class="text ex_f14 ex_fgrey"></span>
						</td>
						<td style="width:20px;">
							<div class="ex_imgbox" style="width:20px; height:20px;">
								<svg class="svg" viewBox="0 0 400 400"><path d="<?php echo $SVG['arwb']; ?>" style="fill:#CCC;"/></svg>
							</div>
						</td>
						<td style="width:20px;"></td>
					</tr>
				</tbody>
			</table>
			<div class="ex_abs ex_pos">
				<div class="ex_abs hidden ex_hid ex_curs ex_W" style="height:0px; bottom:0px;">
					<div class="ex_rel ex_bord ex_vlef" style="background:#FFF;">
						<table class="ex_cell ex_W">
							<tbody>
								<tr>
									<td class="ex_bgover ex_wrap" style="padding:10px;">
										<input type="checkbox" name="room" style="margin-right:10px;">
										<b class="ex_f16">1</b>
										<div class="ex_abs ex_pos" onClick="EXP_CAT_Chek(this)"></div>
									</td>
									<td class="ex_bgover ex_wrap" style="padding:10px;">
										<input type="checkbox" name="room" style="margin-right:10px;">
										<b class="ex_f16">2</b>
										<div class="ex_abs ex_pos" onClick="EXP_CAT_Chek(this)"></div>
									</td>
									<td class="ex_bgover ex_wrap" style="padding:10px;">
										<input type="checkbox" name="room" style="margin-right:10px;">
										<b class="ex_f16">3</b>
										<div class="ex_abs ex_pos" onClick="EXP_CAT_Chek(this)"></div>
									</td>
									<td class="ex_bgover ex_wrap" style="padding:10px;">
										<input type="checkbox" name="room" style="margin-right:10px;">
										<b class="ex_f16">4+</b>
										<div class="ex_abs ex_pos" onClick="EXP_CAT_Chek(this)"></div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="ex_abs ex_pos ex_curs" onClick="$(this).parent().find('.hidden').show()"></div>
			</div>
		</div>
		<div class="find summ ex_imgbox exp_cat_shadover ex_cro3 ex_bgwhite" style="width:254px; height:32px; margin:15px 15px 0 0; z-index:1;">
			<table class="ex_cell ex_pos">
				<tbody>
					<tr class="ex_vcen ex_vmid">
						<td style="width:12%;">
							<span class="ex_f18 ex_fgrey ruble">р</span>
						</td>
						<td style="width:0px; border-left:#EEE 1px solid;"></td>
						<td class="ex_vcen ex_vmid" style="width:44%;" title="Стоимость начиная от...">
							<input type="text" class="text ex_abs ex_bgno ex_borno ex_fgrey ex_f14" style="left:0px; top:6px; width:40px; text-align:center;" value="от">
							<input type="text" class="inval ex_abs ex_borno ex_bgno ex_pos" name="summ" onClick="$(this).focus().select()" onKeyUp="EXP_CAT_KeyUP(event)" style="text-align:center; font-size:18px;" autocomplete="off" maxlength="9">
						</td>
						<td style="width:0px; border-left:#EEE 1px solid;"></td>
						<td class="ex_vcen ex_vmid" style="width:44%;" title="Стоимость до...">
							<input type="text" class="text ex_abs ex_bgno ex_borno ex_fgrey ex_f14" style="left:0px; top:6px; width:40px; text-align:center;" value="до">
							<input type="text" class="inval ex_abs ex_borno ex_bgno ex_pos" name="summ" onClick="$(this).focus().select()" onKeyUp="EXP_CAT_KeyUP(event)" style="text-align:center; font-size:18px;" autocomplete="off" maxlength="9">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="find area ex_imgbox exp_cat_shadover ex_cro3 ex_bgwhite" style="width:254px; height:32px; margin:15px 15px 0 0; z-index:1;">
			<table class="ex_cell ex_pos">
				<tbody>
					<tr class="ex_vcen ex_vmid">
						<td style="width:12%;">
							<span class="ex_f14 ex_fgrey">м<sup>2</sup></span>
						</td>
						<td style="width:0px; border-left:#EEE 1px solid;"></td>
						<td class="ex_vcen ex_vmid" style="width:44%;" title="Площадь начиная от...">
							<input type="text" class="text ex_abs ex_bgno ex_borno ex_fgrey ex_f14" style="left:0px; top:6px; width:40px; text-align:center;" value="от">
							<input type="text" class="inval ex_abs ex_borno ex_bgno ex_pos" name="area" onClick="$(this).focus().select()" onKeyUp="EXP_CAT_KeyUP(event)" style="text-align:center; font-size:18px;" autocomplete="off" maxlength="5">
						</td>
						<td style="width:0px; border-left:#EEE 1px solid;"></td>
						<td class="ex_vcen ex_vmid" style="width:44%;" title="Площадь до...">
							<input type="text" class="text ex_abs ex_bgno ex_borno ex_fgrey ex_f14" style="left:0px; top:6px; width:40px; text-align:center;" value="до">
							<input type="text" class="inval ex_abs ex_borno ex_bgno ex_pos" name="area" onClick="$(this).focus().select()" onKeyUp="EXP_CAT_KeyUP(event)" style="text-align:center; font-size:18px;" autocomplete="off" maxlength="5">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="find ex_imgbox" style="margin:15px 15px 0 0;">
			<div id="findsend" class="exp_cat_bhave ex_f16 ex_cro3 ex_curs" style="padding:5px 20px 6px 20px;">Поиск</div>
			<input type="hidden" value="<?php echo (isset($_GET['page']) && $_GET['page'] == 'bs' && isset($_GET['id']) ? $HEAD['pat'].'&page=bs&id='.$_GET['id'].'&path=apa' : $HEAD['pat'].'&page=apa'); ?>">
		</div>
	</div>
	<div class="clecook ex_imgbox ex_curs ex_hid" style="padding:0px 25px;" alt="<?php echo (isset($_GET['page']) && $_GET['page'] == 'bs' && isset($_GET['id']) ? $HEAD['pat'].'&page=bs&id='.$_GET['id'].'&path=apa' : $HEAD['pat'].'&page=apa'); ?>">
		<table class="ex_cell exp_cat_fblue">
			<tbody>
				<tr>
					<td>
						<span class="ex_f12">Сбросить фильтр</span>
					</td>
					<td>
						<div class="ex_imgbox" style="width:30px; height:30px;">
							<svg class="svg" viewBox="0 0 400 400"><path d="<?php echo $SVG['del']; ?>"/></svg>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>