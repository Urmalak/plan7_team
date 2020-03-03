// JavaScript Document

/*window.onload = function() {
	document.getElementById('catalogFrame').style.background = '#FFF';
	window.addEventListener('message', CATALOG_receiveMessage, false);
}

function CATALOG_receiveMessage(e) {
	let e = e || window.event;
	let frame = document.getElementById('catFrame');
	if (frame) {
		frame.style.height = (e.data + 20)+'px';
	}
}*/

function CATALOG_P7_Init(zk) {
	if (!zk) {zk = 1;}
	var hos = (window.location.hostname != '127.0.0.1' ? 'https://plan7.ru' : 'http://127.0.0.1/www.plan7.ru');
	var div = window.document.createElement('div');
		div.id = 'p7_container';
		div.style.cssText = 'position:fixed; top:0px; left:0px; width:100%; height:100%; z-index:999; background:#FFF; overflow:auto;';
	window.document.body.style.height = '100%';
	window.document.body.style.overflow = 'hidden';
	window.document.body.style.webkitOverflowScrolling = 'touch';
	window.document.body.appendChild(div);
	var url = hos+'/exp/catalog/index.php?zk='+zk;
	CATALOG_Set('p7_container', url);
}

function CATALOG_Set(id, url) {
	var div = document.getElementById(id);
	var but = [];
		but.push('<div onClick="CATALOG_P7_Remove()" style="position:relative; cursor:pointer; margin-left:15px;"><span style="color:#999; font-size:12px; font-family:Arial, Helvetica, sans-serif;">Закрыть</span></div>');
	div.innerHTML = '<iframe src="'+url+'" style="position:absolute; width:100%; height:100%; border:none;"></iframe><div style="position:absolute; top:15px; right:35px; z-index:3; text-align:right; margin-left:auto;">'+but.join('')+'</div>';
}

function CATALOG_P7_Remove() {
	var rem = window.document.getElementById('p7_container');
	rem.remove();
	window.document.body.style.height = 'auto';
	window.document.body.style.overflow = 'auto';
}