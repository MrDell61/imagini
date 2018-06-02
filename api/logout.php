<?php
	include('..\common.php');
	header('Content-Type: application/json');
	$return = array(
		'msg' => '',
		'code' => -1
	);
	if (!isSet($_POST['SID'])) {
		if (!isSet($_COOKIE['SID'])) {
			$return['msg'] = 'No set SID';
			$return['code'] = 303;
			die(json_encode($return));
		} else {
			$SID = $_COOKIE['SID'];
		};
	} else {
		$SID = $_POST['SID'];
	};
	$stmt = $db -> prepare('SELECT * FROM users WHERE hash_SID = :hash_SID LIMIT 1');
	$stmt -> execute(array('hash_SID' => md5($SID)));
	$data = $stmt->fetchAll();
	if (count($data) != 0) {
		$stmt = $db -> prepare('UPDATE "users" SET "hash_SID" = NULL WHERE "id" = :user_id');
		$res = $stmt -> execute(array(
			'user_id' => $data[0]["id"]
		));
	};
	$return['msg'] = '';
	$return['code'] = 1;
	die(json_encode($return));
?>