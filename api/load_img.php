<?php
	include_once('..\common.php');
	header('Content-Type: application/json');
	$return = array(
		'code' => 0,
		'msg' => '',
		'image_id' => ''
	);
	if (!$user["isAutorization"]) {
		$return['code'] = 301;
		$return['msg'] = 'Не авторизованы';
		die(json_encode($return));
	};
	if (!isSet($_FILES['image'])) {
		$return['code'] = 303;
		$return['msg'] = 'Файл не найден';
		die(json_encode($return));
	};
	//INSERT INTO "images" ("id","url","user_id") VALUES (NULL,'refwefwef',NULL)
	$stmt = $db -> prepare('INSERT INTO "images" ("user_id", "ip") VALUES (:user, :ip)');
	$res = $stmt -> execute(array(
		'user' => $user['id'],
		"ip" =>  $_SERVER['REMOTE_ADDR']
	));
	$fileName = str_replace("=", "", base64_encode($db -> lastInsertId()));
	if (move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/data/image/'.$fileName.'.jpeg')) {
		$return['code'] = 1;
		$return['image_id'] = $fileName;
		$return['msg'] = 'Загружен';
		die(json_encode($return));
	} else {
		$return['code'] = 302;
		$return['msg'] = 'Не удалось перенести файл';
		die(json_encode($return));
	};
?>