<div id="drop">
	<h2>Загружайте и делитесь изображениями.</h2>
	<button style="width: 250px; height: 60px" onclick="document.querySelector('input').click()">Начать загрузку</button>
	<input style="visibility: collapse; width: 0px;" onchange="upload(this.files[0])" type="file">
	<br><h5>Перетащите или вставьте изображение для начала загрузки</h5>
	<div id="msg"></div>
</div>
<script>
	window.ondragover = function(e) {e.preventDefault()};
	window.ondrop = function(e) {e.preventDefault(); upload(e.dataTransfer.files[0])};

	function upload(file) {
		if (!file) return;
		document.getElementById('msg').innerHTML = 'Загрузка...';
		var fd = new FormData();
		fd.append("image", file);
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "/api/load_img.php");
		xhr.onload = function() {
			a = xhr.responseText;
			document.location.href = "/?p=image&v=" + JSON.parse(xhr.responseText).image_id;
		};
		xhr.send(fd);
	};
</script>