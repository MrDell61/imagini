
<div id="title">Войти или зарегистрироваться</div id="title">
<div id="msg"></div>
<input type="text" id="login" name="login" onkeypress="if (event.keyCode == 13) addComment('login');" placeholder="Логин">
<input type="password" id="password" name="password" onkeypress="if (event.keyCode == 13) autorization('login');" placeholder="Пароль">
<input type="submit" id="LoginEnter" name="submit" value="Войти" onclick="autorization('login')">
<input type="submit" id="RegEnter" name="submit" value="Зарегистрироваться" onclick="autorization('reg')">

<script>
	function autorization(url) {
		if (document.getElementById('login').value == "") {
			document.getElementById('msg').innerHTML = "Не введен логин";
			return false;
		};
		if (document.getElementById('password').value == "") {
			document.getElementById('msg').innerHTML = "Не введен пароль";
			return false;
		};
		$.post(
			'/api/'+url+'.php',
			{
				login: document.getElementById('login').value,
				password: document.getElementById('password').value
			},
			function(data) {
				document.getElementById('msg').innerHTML = data.msg;
				if (data.code == 1) {
					document.cookie = "SID=" + data.SID;
					document.location.href = "/";
				};
			},
			'JSON'
		);
		return true;
	};

</script>