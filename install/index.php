<?php
	if (file_exists('..\data\db\data.db')) die("Для начала удалите страую базу данных!");
	if (!isSet($_GET['install'])) die("<a href='index.php?install=yes'>Установить базу данных.</a>");
	if ($_GET['install'] == 'yes') {
		$db = new PDO("sqlite:..\data\db\data.db");
		if (!$db) exit("Невозможно создать базу данных!");
		$query_table = $db -> query("CREATE TABLE 'users' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'login' TEXT NOT NULL, 'hash_password' TEXT NOT NULL, 'hash_SID' TEXT DEFAULT NULL, 'ip' TEXT);");
		if (!$query_table) exit("Невозможно создать таблицу в базе данных!");
		$query_table = $db -> query("CREATE TABLE 'comments' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'id_user' INTEGER NOT NULL, 'text' TEXT NOT NULL, 'date'  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  , 'ip' TEXT, 'images' INTEGER);");
		if (!$query_table) exit("Невозможно создать таблицу в базе данных!");
		$query_table = $db -> query("CREATE TABLE 'images' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'user_id' INTEGER DEFAULT NULL, 'count_view' INTEGER NOT NULL DEFAULT 0 , 'count_like' INTEGER NOT NULL DEFAULT 0 , 'date'  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  , 'ip' TEXT);");
		if (!$query_table) exit("Невозможно создать таблицу в базе данных!");
		$query_insert = $db -> query("INSERT INTO 'users' ('id','login','hash_password','hash_SID','ip') VALUES ('0','admin','any',NULL,NULL);");
		if (!$query_insert) exit("Невозможно записать данные в таблицу!");
		$query_insert = $db -> query("INSERT INTO 'users' ('id','login','hash_password','hash_SID','ip') VALUES ('1','root','any',NULL,NULL);");
		if (!$query_insert) exit("Невозможно записать данные в таблицу!");
		$query_insert = $db -> query("INSERT INTO 'users' ('id','login','hash_password','hash_SID','ip') VALUES ('2','','any',NULL,NULL);");
		if (!$query_insert) exit("Невозможно записать данные в таблицу!");
		$query_insert = $db -> query("INSERT INTO 'users' ('id','login','hash_password','hash_SID','ip') VALUES ('3','404','any',NULL,'');");
		if (!$query_insert) exit("Невозможно записать данные в таблицу!");
		exit("Done!");
	};
?>