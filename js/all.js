// Устанавливаем ссылка на btn элементы
$(document).ready(function() {
	var elems = document.getElementsByClassName('btn');
	for (var i = 0; elems.length > i; i++) {
		var item = elems[i];
		if (item.dataset.link != undefined) {
			item.onclick = function() {
				document.location.href = this.dataset.link;
			};
		}
	};
});
// Получаем ссылку на сайт в виде GET
var GET = window.location.search.replace('?','').split('&').reduce(
	function(p, e) {
		var a = e.split('=');
		p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
		return p;
	},{}
);

function shownProfileMenu(isShow) {
	document.getElementById("menu").style.display = isShow ? "inline-block" : "none";
}

function addComment(elem) {
	var id = window.location.search.replace('?','').split('&').reduce(function(p,e){
		var a = e.split('=');
		p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
		return p;
	},{})['v'];
	var text = elem.value;
	if (text == "") return;
	elem.value = "";
	$.post(
		'/api/addComment.php',
		{
			comment: text,
			img: id
		},
		function(data) {
			if (data['code'] != 1)
				alert(data['msg']);
		},
		'JSON'
	);
}


function updateComment(url, lastId) {
	document.getElementById("comments").scrollTop = 9999;
	$.post(
		'/api/updateComment.php',
		{
			img: url,
			last: lastId
		},
		function(data) {
			data['newComments'].forEach(item => {
				var li = document.createElement('li');
				li.innerHTML = item[0] + ':' + item[1];
				var hr = document.createElement('hr');
				document.getElementById("comments").appendChild(li);
				document.getElementById("comments").appendChild(hr);
			});
			updateComment(url, data['last']);
		},
		'JSON'
	);
};
// Делаем фон для страницы которой выбрали

//
