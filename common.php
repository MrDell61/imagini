<?php
	$page404 = '.\body\404.php';
	$page = isSet($_GET['p']) ? $_GET['p'] : 'index';
	function randomString($leight) {
        $str = 'qwertyuiopasdfghjklzxcvbnmQWERTYIOPASDFGHJKLZXCVBNM1234567890';
        $result = '';
        for ($i = 0; $i < $leight; $i++) {
            $result .= substr($str, mt_rand(0, strlen($str) - 1), 1);
        };
        return $result;
    };
	try {
		$db = new PDO("sqlite:".$_SERVER['DOCUMENT_ROOT']."/data/db/data.db");
	} catch (PDOException $e) {
		die("Connection error: " . $e->getMessage());
	};
	$user = array(
		"isAutorization" => false,
		"login" => "Anonymous",
		"id" => -1
	);
	if (isSet($_COOKIE['SID'])) {
		$SID = $_COOKIE['SID'];
	} else if (isSet($_POST['SID'])) {
		$SID = $_POST['SID'];
	};
	if (isSet($SID)) {
		$stmt = $db -> prepare('SELECT * FROM users WHERE hash_SID = :hash_SID LIMIT 1');
		$stmt -> execute(array('hash_SID' => md5($_COOKIE['SID'])));
		$data = $stmt->fetchAll();
		if (count($data) != 0) {
			$data = $data[0];
			$user["isAutorization"] = true;
			$user["login"] = $data['login'];
			$user["id"] = $data["id"];
		};
	};
?>