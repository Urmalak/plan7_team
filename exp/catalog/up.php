<div class="ex_rel ex_W" style="height:50px; background:#000;"></div>
<div class="ex_fix" style="top:0px; left:0px; right:0px; height:50px; background:#FFF; box-shadow:0 0 0 1px #CCC; z-index:5;">
	<table class="ex_cell ex_abs ex_pos">
		<tbody>
			<tr>
				<td style="width:25px;"></td>
				<td style="width:32px;">
					<?php
						if (isset($_GET['page'])) {
							echo '<a href="'.$HEAD['pat'].'" class="ex_imgbox ex_decno" style="width:32px; height:32px;" title="На главную">
								<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['home'].'" style="fill:#000;"/></svg>
							</a>';
						} else {
							echo '<div class="ex_imgbox" style="width:32px; height:32px;">
								<svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['home'].'" style="fill:#CCC;"/></svg>
							</div>';
						}
					?>
				</td>
				<td style="width:10px;">
					<div class="ex_rel" style="width:20px;"></div>
				</td>
				<td class="ex_vlef exp_cat_com ex_wrap">
					<?php
					echo '<span class="ex_f18">ЖК '.$HEAD['zk']['name'].'</span>';
					if (isset($_GET['page'])) {
						switch($_GET['page']) {
							case "bs": $text = 'Секци'.(isset($_GET['id']) ? 'я '.$HEAD['bs'][$_GET['id']]['name'] : 'и'); break;
							case "apa": $text = "все квартиры"; break;
							default: break;
						}
						if (isset($text)) {
							echo '<span>&nbsp; - &nbsp;</span><span class="ex_f18">'.$text.'</span>';
							unset($text);
						}
					}
					?>
				</td>
				<td>
					<div class="ex_rel" style="width:20px;"></div>
				</td>
				<td class="ex_vrig">
					<div class="ex_imgbox ex_wrap">
						<table class="ex_cell" title="Телефон отдела продаж">
						<tbody>
						<tr>
							<td>
								<?php
									echo '<div class="ex_imgbox" style="'.($HEAD['mobile']->isMobile() ? 'width:20px; height:20px;' : 'width:32px; height:32px;').'"><svg class="svg" viewBox="0 0 400 400"><path d="'.$SVG['phone'].'" style="fill:#CCC;"/></svg></div>';
								?>
								<div class="ex_imgbox" style="'width:32px; height:32px;">
									<svg class="svg" viewBox="0 0 400 400"><path d="<?php echo $SVG['phone']; ?>" style="fill:#CCC;"/></svg>
								</div>
							</td>
							<td style="width:5px;"></td>
							<td>
								<?php echo (isset($HEAD['zk_info']['tel']) ? '<span class="ex_fblack '.($HEAD['mobile']->isMobile() ? 'ex_f14' : 'ex_f24').'">'.$HEAD['zk_info']['tel'].'</span>' : ''); ?>
							</td>
						</tr>
						</tbody>
						</table>
					</div>
				</td>
				<td style="width:160px;">
					<div class="ex_rel" style="width:160px;"></div>
				</td>
			</tr>
		</tbody>
	</table>
</div>