// JavaScript Document

var profit_cook;

$(document).ready(function() {
	EXP_CAT_CookGET();
	EXP_CAT_FindSET();
	EXP_CAT_FindTEXT();
	$('#findsend').click(function() {
		EXP_CAT_CookSET();
		document.location = $('#findsend').next().val();
	});
	$('.menu_loc').click(function() {document.location = $(this).find('.loc').val();});
	if (H_mob) {
		$('.area_pat').click(function() {
			$('.remove').remove();
			EXPORT_FreeMODAL({e:event, div:$(this).attr('alt'), over:1});
			EXPORT_FreeMODAL({e:event, over:-1});
			$('.close').click(function() {$('.remove').remove();});
			$('.chesscat').removeClass('exp_cat_bhave').addClass('exp_cat_chess');
			$(this).parent().find('.chesscat').removeClass('exp_cat_chess').addClass('exp_cat_bhave');
		});
	} else {
		$('.area_ches').mouseover(function() {EXPORT_FreeMODAL({e:event, div:$(this).attr('alt'), over:1});});
		$('.area_ches').mousemove(function() {EXPORT_FreeMODAL({e:event, over:-1});});
		$('.area_ches').mouseout(function() {EXPORT_FreeMODAL({e:event, over:0});});
		$('.area_pat').click(function() {document.location = $('#'+$(this).attr('alt')).find('a').attr('href');});
	}
	$('.area_para').mouseover(function() {EXP_CAT_apaParam($(this).attr('alt'));});
	$('.area_para').click(function() {EXP_CAT_SetAPA({apa:$(this).attr('alt')});});
	$('.catpage').click(function() {
		EXPORT_Referer();
		var apa = $(this).find('[name="apa"]').val();
		var zk = $(this).find('[name="zk"]').val();
		document.location = H_hos+'/exp/catalog/index.php?zk='+zk+'&page=apa&apa='+apa;
	});
	$.each($('.area_svg'), function(i,v) {EXPORT_ImgSVG({eto:$(v),nex:$(v).next()});});
	$('.sortcat').click(function() {EXPORT_SORTIR({eto:this, type:1, by:$(this).attr('alt'), num:3})});
	$('.levcat').click(function() {EXP_CAT_BsLevChek({eto:this,lev:$(this).attr('alt')});});
	$('.printcat').click(function() {EXP_CAT_Print({div:$(this).attr('alt')});});
	$('.mode').click(function() {EXP_CAT_BsCheMODE({eto:this, val:$(this).attr('alt')});});
	$('.callcat').click(function() {EXP_CAT_Call({zk:$(this).find('[name="print[zk]"]').val(), apa:$(this).find('[name="print[apa]"]').val()})});
	$('.clecook').click(function() {
		EXPORT_CLEAR_COOKIE({name:'cat_find'});
		document.location = $(this).attr('alt');
	});
	$('.entmenu').click(function() {EXP_CAT_BsCheMENU({eto:this,id:$(this).attr('alt')})});
	if (window.location.hash) {
		var hash = window.location.hash.replace(/#/,"");
		var harr = hash.split(',');
		for (var i=0; i<parseInt(harr.length); i++) {
			var horr = hash.split('_');
			if (horr && horr[0] && horr[1]) {
				switch(horr[0]) {
					case "apa": EXP_CAT_ShowAPA({apa:horr[1]}); break;
				}
			}
		}
	}
	$('.cat_zone').mouseover(function() {
		$('.exp_svg_hove').removeClass('exp_svg_hove');
		$(this).addClass('exp_svg_hove');
	});
});

function EXP_CAT_Tog(eto) {
	var val = $(eto).parent().find('[name="val"]').val();
	var tog = $(eto).parent().find('[name="tog"]').val();
	$(eto).parent().removeClass(tog == 1 ? 'exp_cat_bblue' : 'exp_cat_bgrey');
	$(eto).parent().addClass(tog == 1 ? 'exp_cat_bgrey' : 'exp_cat_bblue');
	$(eto).parent().find('[name="tog"]').val(tog == 1 ? 0 : 1);
	$('.'+val).css('display', (tog == 1 ? 'none' : 'block'));
}

function EXP_CAT_SetAPA(options) {
	var opt = {apa:null};
	$.extend(opt, options);
	$.get(H_hos+'/exp/catalog/apa/get.php', {set_apa:1, apa:opt.apa}, function(json) {
		$('.set_box_two').show().html(json['data']);
		$('.set_box_one').hide();
	},'json');
}

function EXP_CAT_closeBox() {
	$('.set_box_one').show();
	$('.set_box_two').html('').hide();
}

function EXP_CAT_apaParam(apa) {
	$.get(H_hos+'/exp/catalog/apa/get.php', {get_par:1, apa:apa}, function(json) {
		$('.apa_param').html(json);
	},'json');
}

function EXP_CAT_postMessage() {
	$('.dbody').css('height', 'auto');
	var divBody = document.getElementById('divBody');
	var hey = divBody.scrollHeight;
	window.parent.postMessage(parseInt(hey)+40, '*');
}

function EXP_CAT_Chek(eto) {
	var inp = $(eto).parent().find('input');
	$(inp).prop('checked') == true ? $(inp).prop('checked',false) : $(inp).prop('checked',true);
	EXP_CAT_CookSET();
	EXP_CAT_FindTEXT();
}

function EXP_CAT_KeyUP(e) {
	e = event || window.event;
	if (e.keyCode == 13) {
		EXP_CAT_CookSET();
		document.location = H_pat+'&page=apa';
	}
}

function EXP_CAT_CookGET() {
	var val = EXPORT_GET_COOKIE({name:"cat_find"});
	if (val) {profit_cook = JSON.parse(val);}
	EXP_CAT_CookCLE();
}

function EXP_CAT_CookSET() {
	var func = function(v) {
		v = v.replace(/,/g, ".");
		v = v.replace(/[^0-9\.]/g, "");
		return parseFloat(v);
	}
	var profit_cook = {type:[], room:[], summ:[], area:[]};
	$.each($('#cookdiv').find('[name=type]'), function(i,v) {profit_cook.type.push($(v).prop('checked'));});
	$.each($('#cookdiv').find('[name=room]'), function(i,v) {profit_cook.room.push($(v).prop('checked'));});
	$.each($('#cookdiv').find('[name=summ]'), function(i,v) {profit_cook.summ.push(func($(v).val()));});
	$.each($('#cookdiv').find('[name=area]'), function(i,v) {profit_cook.area.push(func($(v).val()));});
	var val = JSON.stringify(profit_cook);
	EXPORT_ADD_COOKIE({name:"cat_find", val:val, time:604800});
	EXP_CAT_CookCLE();
}

function EXP_CAT_CookCLE() {
	var clecook = false;
	if (profit_cook) {
		$.each(profit_cook, function(i,v) {
			$.each(v, function(j,u) {
				if (u && u != "" && u != 0) {clecook = true;}
			});
		});
	}
	if (clecook) {
		$('.clecook').show();
	} else {
		$('.clecook').hide();
	}
}

function EXP_CAT_FindSET() {
	if (profit_cook) {
		$.each($('#cookdiv').find('[name=type]'), function(i,v) {$(v).prop('checked', profit_cook.type[i]);});
		$.each($('#cookdiv').find('[name=room]'), function(i,v) {$(v).prop('checked', profit_cook.room[i]);});
		$.each($('#cookdiv').find('[name=summ]'), function(i,v) {$(v).val(EXPORT_PRICE(profit_cook.summ[i]));});
		$.each($('#cookdiv').find('[name=area]'), function(i,v) {$(v).val(profit_cook.area[i]);});
	}
}

function EXP_CAT_FindTEXT() {
	var type = ['Квартиры', 'Офисы', 'Парковки', 'Кладовые', 'Любые помещения'];
	var arr = [];
	$.each($('#cookdiv').find('[name=type]'), function(i,v) {if ($(v).prop('checked') == true) {arr.push(type[i]);}});
	$('#cookdiv').find('.type').find('.text').html(parseInt(arr.length) > 0 ? arr.join(', ') : 'Тип помещений');
	var summ = $('#cookdiv').find('.summ').find('.text');
	var arr = [];
	$.each($('#cookdiv').find('[name=room]'), function(i,v) {if ($(v).prop('checked') == true) {arr.push(i + 1);}});
	$('#cookdiv').find('.room').find('.text').html(parseInt(arr.length) > 0 ? arr.join(', ')+' комн' : 'Комнат');
	var summ = $('#cookdiv').find('.summ').find('.text');
	$.each($('#cookdiv').find('[name=summ]'), function(i,v) {
		var val = $(v).val().replace(/[^0-9]/g, "");
		$($(summ)[i]).css('display',(val != "" ? 'none' : 'block'));
	});
	var area = $('#cookdiv').find('.area').find('.text');
	$.each($('#cookdiv').find('[name=area]'), function(i,v) {
		var val = $(v).val().replace(/[^0-9\.]/g, "");
		$($(area)[i]).css('display',(val != "" ? 'none' : 'block'));
	});
}

function EXP_CAT_ShowAPA(options) {
	var opt = {get_apa:1, apa:0, user:0}
	$.extend(opt, options);
	EXPORT_FreeMODAL({over:0});
	EXP_CAT_Modal();
	$('.modal').html('<div class="ex_pos ex_bggrey" style="display:flex; align-items:center; justify-content:center;"><img src="'+H_hos+'/img/load.gif" style="width:64px;" alt="load"></div>');
	opt.user = $('[name="head[user]"]').val();
	$.get(H_hos+'/exp/catalog/apa/get.php', opt, function(json) {
		$('.modal').html(json['data']);
		$('#plaimg').one('load', function() {
			$('.dbody').css('height', 'auto');
			$('body').css('overflow','auto');
			var hey = parseInt($('#print_apa').height()) + 48;
			window.parent.postMessage(hey, '*');
			$('#print_apa').css('height','100%');
		});
		location.hash = 'apa_'+opt.apa;
		$('.printcat').click(function() {EXP_CAT_Print({div:$(this).attr('alt')});});
		$('.emailcat').click(function() {EXP_CAT_EMail({eto:this, apa:opt.apa});});
		$('.callcat').click(function() {EXP_CAT_Call({zk:$(this).find('[name="print[zk]"]').val(), apa:$(this).find('[name="print[apa]"]').val()})});
	},'json');
}

function EXP_CAT_CloseMOD() {
	$('.tempo').remove();
	$('body').css('height','auto');
	$('body').css('overflow','auto');
	EXP_CAT_postMessage();
	location.hash = '';
}

function EXP_CAT_Modal() {
	$('.tempo').remove();
	$('body').append('<div class="tempo ex_fix" style="top:51px; bottom:0px; left:0px; right:0px; z-index:799;"><div class="modal ex_abs ex_pos">TEMPO</div></div>');
}

function EXP_CAT_Call(options) {
	var opt = {get_call:1, zk:0, apa:0}
	$.extend(opt, options);
	EXPORT_MODAL();
	$('.export_mod_text').html('<div class="ex_rel ex_vcen ex_padd"><img src="'+H_hos+'/img/load.gif" class="ex_vcen" style="width:64px;" alt="load"></div>');
	$.get(H_hos+'/exp/catalog/get.php', opt, function(json) {
		$('.export_mod_text').html(json['data']);
	},'json');
}

function EXP_CAT_Print(options) {
	var opt = {div:null}
	$.extend(opt, options);
	$('.print_h').show();
	$('.print_s').hide();
	var size = {x:parseInt($(document).width()), y:parseInt($(document).height())};
	var mywindow = window.open('', opt.div, 'height='+size.x+',width='+size.y+'');
		mywindow.document.write('<html><head>'+
		'<title>plan7.ru</title>'+
		'<link rel="stylesheet" href="'+H_hos+'/css/p7_export.css" type="text/css" />'+
		'<link rel="stylesheet" href="'+H_hos+'/exp/catalog/style.css" type="text/css" />'+
		'<link rel="stylesheet" type="text/css" href="'+H_hos+'/css/ruble.css">'+
		'</head><body><div id="printpage" class="ex_rel ex_vcen">'+$('#'+opt.div).html()+'</div></body></html>');
	$(mywindow.document).ready(function() {
		setTimeout(function() {
			mywindow.focus();
			mywindow.print();
			mywindow.close();
			$('.print_h').hide();
			$('.print_s').show();
		}, 1200);
	});
}

function EXP_CAT_EMail(options) {
	var opt = {eto:null, apa:null}
	$.extend(opt, options);
	EXPORT_MODAL();
	$('.export_mod_text').html('<div class="ex_rel ex_vcen ex_padd"><img src="'+H_hos+'/img/load.gif" class="ex_vcen" style="width:64px;" alt="load"></div>');
	$.get(H_hos+'/exp/catalog/apa/pdf.php', {pdf_apa:1, apa:opt.apa}, function(json) {
		$('.export_mod_text').html('<div style="padding:10px; width:260px;"><form id="sform" action="'+H_hos+'/exp/mail/get.php" class="ex_W" target="rFrame" enctype="multipart/form-data" method="post"></form></div>');
		$('#sform').append('<input type="hidden" name="send_mail" value="1">');
		$('#sform').append('<input type="hidden" name="send[subject]" value="'+json['subject']+'">');
		$('#sform').append('<span class="ex_f12 ex_fgrey">На E-mail</span><br>');
		$('#sform').append('<input type="email" class="ex_W" name="send[to]" required style="padding:5px;"><br><br>');
		$('#sform').append('<span class="ex_f12 ex_fgrey">Текст письма</span><br>');
		$('#sform').append('<textarea class="ex_W" name="send[message]" style="padding:5px; height:120px;"></textarea><br><br>');
		$('#sform').append('<a href="'+H_hos+'/'+json['pdf']+'" class="ex_f12" target="_blank">Прикреплённый PDF файл</a><br><br>');
		$('#sform').append('<input type="hidden" name="attach[0]" value="'+json['pdf']+'">');
		$('#sform').append('<input type="submit" class="exp_cat_bhave ex_cro3" value="Отправить" style="padding:5px 10px;">');
		$('#sform').submit(function() {
			$('#sform').hide();
		});
	},'json');
}