<?php
require_once('../../connect.php');
require_once('../../host.php');
require_once('../../function.php');
require_once('../../svg.php');
require_once('function.php');
require_once('head.php');
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="favicon.png">
	<title>Каталог ЖК <?php echo $HEAD['zk']['name']; ?></title>
	<meta name="keywords" content="каталог жилого комплекса <?php echo $HEAD['zk']['name']; ?>">
	<meta name="Description" content="Трансляция каталога ЖК <?php echo $HEAD['zk']['name']; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="referrer" content="origin">
	<script src="<?php echo $H_hos; ?>/js/jquery/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $H_hos; ?>/css/p7_export.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $H_hos; ?>/css/ruble.css">
	<script src="<?php echo $H_hos; ?>/js/p7_export.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		.exp_cat_fblue {<?php echo 'color:#'.$HEAD['sty']['b'].'; fill:#'.$HEAD['sty']['b'].';'; ?>}
		.exp_cat_fblue:hover {<?php echo 'color:#'.$HEAD['sty']['f'].'; fill:#'.$HEAD['sty']['f'].';'; ?>}
		.exp_cat_fgrey {color:#777; fill:#777;}
		.exp_cat_fgrey:hover {color:#999; fill:#999;}
		[class*="exp_cat_b"] {cursor:pointer; border:none; text-decoration:none;}
		.exp_cat_bblue {<?php echo 'box-shadow: 0 0 0 1px #'.$HEAD['sty']['f'].'; color:#'.$HEAD['sty']['f'].'; fill:#'.$HEAD['sty']['f'].';'; ?> background:none;}
		.exp_cat_bblue:hover {<?php echo 'box-shadow: 0 0 0 1px #'.$HEAD['sty']['b'].'; color:#'.$HEAD['sty']['b'].'; fill:#'.$HEAD['sty']['b'].';'; ?> background:#CDE;}
		.exp_cat_bgrey {box-shadow: 0 0 0 1px #EEE; background:#F3F3F3; fill:#777; color:#777;}
		.exp_cat_bgrey:hover {box-shadow: 0 0 0 1px #EEE; background:#F9F9F9; fill:#555; color:#555;}
		.exp_cat_bhave {<?php echo 'box-shadow: 0 0 0 1px #'.$HEAD['sty']['b'].'; background:#'.$HEAD['sty']['f'].';'; ?> fill:#FFF; color:#FFF;}
		.exp_cat_bhave:hover {<?php echo 'background: #'.$HEAD['sty']['b'].';'; ?>}
		.exp_cat_bsold {box-shadow: 0 0 0 1px #999; background:#EEE; color:#999;}
		.exp_cat_bfill {<?php echo 'box-shadow: 0 0 0 1px #'.$HEAD['sty']['f'].'; background:#'.$HEAD['sty']['f'].';'; ?> color:#FFF;}
		.exp_cat_bempt {background:none; fill:#999; color:#555;}
		.exp_cat_bempt:hover {box-shadow: 0 0 0 1px #CCC; background:#EEE; color:#333;}
		.exp_cat_chess {box-shadow: 0 0 0 1px #694; background:#7A5; fill:#FFF; color:#FFF;}
		.exp_cat_bches {box-shadow: 0 0 0 1px #DDA; background:#EEB;}
		.exp_cat_bches:hover {background:#EE9;}
		.exp_cat_bord {<?php echo 'box-shadow: 0 0 0 1px #'.$HEAD['sty']['f'].';'; ?>}
		[class*="exp_svg"] {cursor:pointer;}
		.exp_svg_area {stroke-width:0.0; <?php echo 'stroke:#'.$HEAD['sty']['b'].'; fill: #'.$HEAD['sty']['b'].';'; ?> fill-opacity:0.0;}
		.exp_svg_area:hover {stroke-width:1; fill-opacity:0.5;}
		.exp_svg_grey {stroke:#000; stroke-width:0.1; fill:#EEE; fill-opacity:0.0;}
		.exp_svg_grey:hover {stroke-width:0.5; fill-opacity:0.5;}
		.exp_svg_sold {stroke:#FFF; stroke-width:0.5; fill:#CCC; fill-opacity:0.65;}
		.exp_svg_sold:hover {fill-opacity:0.5; stroke-width:1;}
		.exp_svg_zone {stroke-width:0.0; <?php echo 'stroke:#'.$HEAD['sty']['b'].'; fill:#'.$HEAD['sty']['b'].';'; ?> fill-opacity:0.0;}
		.exp_svg_zone:hover {fill-opacity:0.15;}
		.exp_svg_hove {stroke-width:5;}
	</style>
	<script src="script.js"></script>
	<script>
		var H_hos = "<?php echo $H_hos; ?>";
		var H_pat = H_hos + "/exp/catalog/index.php?zk=<?php echo $_GET['zk']; ?>";
		var H_mob = <?php echo ($HEAD['mobile']->isMobile() ? 1 : 0); ?>;
		$( document ).mouseup( function ( e ) {
			if ( $( ".hidden" ).has( e.target ).length === 0 ) {
				$( ".hidden" ).hide();
			}
			if ( $( ".remove" ).has( e.target ).length === 0 ) {
				$( ".remove" ).remove();
			}
		} );
		window.onload = function () {
			EXP_CAT_postMessage();
		}
	</script>
</head>

<body class="dbody" style="overflow:auto; padding:0px; margin:0px;">
	<iframe id="rFrame" name="rFrame" style="display:none;"></iframe>
	<div class="dbody ex_abs ex_pos ex_vlef">
		<div id="divBody" class="dbody ex_rel" style="height:auto;">
			<table class="ex_cell ex_W" style="min-height:100%;">
				<tbody>
					<tr class="ex_vlef ex_vtop">
						<td>
							<?php
							include_once('up.php');
							include_once('find.php');
							include_once('menu.php');
							if (isset($_GET['page']) && file_exists($_GET['page'].'/index.php')) {
								include_once($_GET['page'].'/index.php');
							} else {
								include_once('fasad/index.php');
							}
							?>
						</td>
					</tr>
					<tr class="ex_vlef ex_vcen">
						<td style="background:#EEE; height:50px;">
							<?php
							include_once('footer.php');
							?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
<?php
unset($HEAD);
include_once('../../close.php');
?>