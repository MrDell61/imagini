<?php
	include_once('..\common.php');
	if (!isSet($_POST['img']) || !isSet($_POST['last'])) {
		$return["code"] = -1;
		die(json_encode($return));
	};
	$return = array(
		"code" => 1,
		"newComments" => array(),
		"last" => $_POST['last']
	);
	$mTime = microtime(true) + 25;
	$img_id = base64_decode($_POST['img']);
	$update = false;

	while ($mTime > microtime(true) && !$update) {
		$stmt = $db -> prepare('SELECT * FROM "comments" WHERE id > :last AND images = :img_id LIMIT 30');
		$stmt -> execute(array(
			'last' => $_POST['last'],
			"img_id" =>  $img_id
		));
		$data = $stmt->fetchAll();
		if (count($data) != 0) {
			$return['last'] = (int)$data[count($data) - 1]['id'];
			foreach ($data as $key => $value) {
				$stmt = $db -> prepare('SELECT * FROM "users" WHERE "id" = :id LIMIT 1');
				$stmt -> execute(array('id' => $value['id_user']));
				$us = $stmt->fetchAll();
				$return['newComments'][] = array($us[0]["login"], $value['text']);
			}
			$update = true;
		};
		sleep(1);
	};
	echo(json_encode($return));
?>