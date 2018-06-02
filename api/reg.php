<?php
	include('..\common.php');
	header('Content-Type: application/json');
	$return = array(
		"msg" => 'Fatal error',
		"code" => -1,
		"SID" => ""
	);
	if (!isSet($_POST['login'])) {
		$return['msg'] = 'No set login';
		$return['code'] = 303;
		die(json_encode($return));
	};
	if (!isSet($_POST['password'])) {
		$return['msg'] = 'No set password';
		$return['code'] = 304;
		die(json_encode($return));
	};
	if (count($_POST['login']) > 35 || count($_POST['login']) < 2) {
		$return['msg'] = 'Логин слишком длинный или короткий';
		$return['code'] = 556;
		die(json_encode($return));
	}
	$login = $_POST['login'];
	$password = $_POST['password'];
	$stmt = $db -> prepare('SELECT * FROM users WHERE login = :login LIMIT 1');
	$stmt -> execute(array('login' => $login));
	$data = $stmt->fetchAll();
	if (count($data) == 0) {
		$stmt = $db -> prepare('INSERT INTO `users` (`login`, `hash_password`) VALUES (:login, :hash_passwd);');
		$res = $stmt -> execute(array(
			'login' => $login,
			'hash_passwd' => password_hash($password, PASSWORD_DEFAULT)
		));
		$SID = md5(randomString(25));

		$stmt = $db -> prepare('UPDATE "users" SET "hash_SID" = :hash_SID, "ip" = :ip WHERE "id" = :user_id');
		$res = $stmt -> execute(array(
			'user_id' => $db -> lastInsertId(),
			'hash_SID' => md5($SID),
			'ip' => $_SERVER['REMOTE_ADDR']
		));
		$return['msg'] = 'Done';
		$return['code'] = 1;
		$return['SID'] = $SID;
		die(json_encode($return));
	} else {
		$return['msg'] = 'Логин уже используется';
		$return['code'] = 303;
		die(json_encode($return));
	};
?>