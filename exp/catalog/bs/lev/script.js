// JavaScript Document

$(document).ready(function() {
	$('.levnext').click(function() {
		var pos = parseInt($(this).find('[name=val]').val());
		var levcat = $('.levcat');
		var len = parseInt(levcat.length)-1;
		var now = 0;
		var level = 0;
		$.each($(levcat), function(i,v) {
			if ($(v).hasClass('exp_cat_bblue')) {
				now = i + pos;
			}
			$(v).removeClass('exp_cat_bblue').addClass('exp_cat_bempt');
		});
		now = (now < 0 ? len : (now > len ? 0 : now));
		level = $(levcat[now]).find('[name=level]').val();
		$(levcat[now]).removeClass('exp_cat_bempt').addClass('exp_cat_bblue');
		$.each($('.levdiv'), function(i,v) {
			var lev = $(v).find('[name=level]').val();
			if (level == lev) {$(v).show();} else {$(v).hide();}
		});
	});
});

function EXP_CAT_BsLevChek(options) {
	var opt = {eto:null, lev:0};
	$.extend(opt, options);
	var set = false;
	$.each($('.levdiv'), function(i,v) {
		$(v).hide();
		var level = $(v).find('[name=level]').val();
		if (opt.lev == level) {$(v).show();}
	});
	$.each($(opt.eto).parent().parent().find('.exp_cat_bblue'), function(i,v) {
		$(v).removeClass('exp_cat_bblue').addClass('exp_cat_bempt');
	});
	$(opt.eto).removeClass('exp_cat_bempt').addClass('exp_cat_bblue');
}