<?php
	include_once('..\common.php');
	$return = array(
		"code" => -1,
		"msg" => ""
	);
	if (!$user["isAutorization"]) {
		$return["code"] = 235;
		$return["msg"] = "Вы не авторизованы";
		die(json_encode($return));
	};
	if (!isSet($_POST["comment"]) || $_POST["comment"] === "") {
		$return["code"] = 256;
		$return["msg"] = "Коментарий пуст";
		die(json_encode($return));
	};
	if (count($_POST["comment"]) > 100) {
		$return["code"] = 586;
		$return["msg"] = "Слишком длинное сообщение!";
		die(json_encode($return));
	}
	$comment = strip_tags($_POST["comment"]);
	$stmt = $db -> prepare('INSERT INTO "comments" ("text", "id_user", "ip", "images") VALUES (:text, :id_user, :ip, :image_id)');
	$res = $stmt -> execute(array(
		'id_user' => $user['id'],
		"text" =>  $comment,
		"ip" => $_SERVER['REMOTE_ADDR'],
		"image_id" => base64_decode($_POST['img'])
	));
	$return["code"] = 1;
	$return["msg"] = "Done";
	die(json_encode($return));
?>