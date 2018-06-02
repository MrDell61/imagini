<?php
	include('..\common.php');
	//header('Content-Type: application/json');
	$return = array(
		"msg" => 'Fatal error',
		"code" => -1,
		"SID" => '-1'
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
	$login = $_POST['login'];
	$passwd = $_POST['password'];
	$stmt = $db -> prepare('SELECT * FROM users WHERE login = :login LIMIT 1');
	$stmt -> execute(array('login' => $login));
	$data = $stmt->fetchAll();
	if (count($data) == 0) {
		$return['msg'] = 'Логин или пароль введены не верно';
		$return['code'] = 305;
		echo(json_encode($return));
	} else if (!password_verify($passwd, $data[0]['hash_password'])) {
		$return['msg'] = 'Логин или пароль введены не верно';
		$return['code'] = 305;
		die(json_encode($return));
	} else {
		$SID = randomString(25);
		$stmt = $db -> prepare('UPDATE "users" SET "hash_SID" = :hash_SID, "ip" = :ip WHERE "id" = :user_id');
		$res = $stmt -> execute(array(
			'user_id' => $data[0]['id'],
			'hash_SID' => md5($SID),
			'ip' => $_SERVER['REMOTE_ADDR']
		));
		if ($res) {
			$return['msg'] = '';
			$return['code'] = 1;
			$return['SID'] = $SID;
			die(json_encode($return));
		} else {
			$return['code'] = 306;
			die(json_encode($return));
		};
	};
?>