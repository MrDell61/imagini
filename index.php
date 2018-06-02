<?php
	include('common.php');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/all.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/all.js"></script>
	<title>Imagini</title>
</head>
<body>
	<div id="head">
		<div id="btn_logo" data-link="?p=index" class="btn"></div>
		<?php if ($user['isAutorization']) {?>
		<div id="btn_profile" onmouseover="shownProfileMenu(true)" class="btn" style="background-color:<?php echo $page === 'profile'? '#eee': '';?>"><?php echo $user["login"] ?></div>
		<div id="menu" style="display: none" onmouseout="shownProfileMenu(false)">
			<div class="btn" onclick="$.post('/api/logout.php', function(){document.location.href = '/?p=login';})">Выход</div>
		</div>
		<?php } else { ?>
		<div id="btn_login" data-link="?p=login" class="btn" style="background-color:<?php echo $page === 'login'? '#eee': '';?>"></div>
		<?php };?>
		<div id="btn_loading" data-link="?p=loading" class="btn" style="background-color:<?php echo $page === 'loading'? '#eee': '';?>"></div>
	</div>
	<div id="body">
		<?php
			if (!$user['isAutorization']) {
				if (!in_array($page, ["index", "login"])) {
					$page = 'login';
				}
			}
			$page = file_exists("body/$page.php") ? $page : '404';
			include("body/$page.php");
		?>
	</div>
</body>
</html>