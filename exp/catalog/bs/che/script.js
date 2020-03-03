// JavaScript Document

	function EXP_CAT_BsCheMENU(options) {
		var opt = {eto:null, id:0};
		$.extend(opt, options);
		$('.entdiv').hide();
		$('#'+opt.id).show();
		$('.entmenu').removeClass('exp_cat_bblue').addClass('exp_cat_bempt');
		$(opt.eto).removeClass('exp_cat_bempt').addClass('exp_cat_bblue');
	}
	
	function EXP_CAT_BsCheMODE(options) {
		var opt = {eto:null, val:null};
		$.extend(opt, options);
		if (opt.val != 0) {
			var dis = $(opt.eto).hasClass('exp_cat_fblue');
			var par = $('[name="che['+opt.val+']"]').parent();
			$(opt.eto).removeClass(dis != true ? 'ex_fgrey' : 'exp_cat_fblue').addClass(dis != true ? 'exp_cat_fblue' : 'ex_fgrey');
			if (dis != true) {$(par).show();} else {$(par).hide();}
		} else {
			if ($(opt.eto).hasClass('exp_cat_bempt') == true) {
				$(opt.eto).removeClass('exp_cat_bempt').addClass('exp_cat_bblue');
				$('.che').show();
				$('.mode').removeClass('ex_fgrey').addClass('exp_cat_fblue');
			} else {
				$(opt.eto).removeClass('exp_cat_bblue').addClass('exp_cat_bempt');
				$('.che').hide();
				$('.mode').removeClass('exp_cat_fblue').addClass('ex_fgrey');
			}
		}
	}