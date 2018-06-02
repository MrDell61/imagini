<?php
	$imageUrl = $_GET['v'];
	$stmt = $db -> prepare('SELECT * FROM images WHERE id = :id LIMIT 1');
	$stmt -> execute(array('id' => base64_decode($imageUrl)));
	$data = $stmt->fetchAll();
	$lastIdComment = -1;
	if (count($data) != 0) {
		$image = $data[0];
		$stmt = $db -> prepare('UPDATE "images" SET count_view = count_view + 1 WHERE id = :id');
		$stmt -> execute(array('id' => $image['id']));
		$stmt = $db -> prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
		$stmt -> execute(array('id' => $image['user_id']));
		$data = $stmt->fetchAll();
		$author = $data[0]['login'];
		$countView = $image['count_view'];
		$date = $image['date'];
	} else {
		$author = "404";
		$countView = "-1";
		$date = "2999-01-01";
	};
?>
<div id='image'>
<img src="data/image/<?php echo $imageUrl?>.jpeg"></img>
</div>
<div id="content">
	<div id="statistic">
		<div id="author">Автор: <?php echo $author?></div><br>
		<div id="view">Просмотров: <?php echo $countView?></div><br>
		<div id="date">Загружено: <?php echo date("d-m-Y", strtotime($date))?></div>
	</div>
	<ul id="comments">
		<?php
			$stmt = $db -> prepare('SELECT * FROM "comments" WHERE "images" = :id_img ORDER BY id DESC LIMIT 30');
			$stmt -> execute(array('id_img' => base64_decode($imageUrl)));
			$data = $stmt->fetchAll();
			if (count($data) != 0 ) {
				$idToName = array();
				array_reverse($data);
				$lastIdComment = $data[0]['id'];
				for ($i = count($data) - 1; $i >= 0; $i--) {
					$value = $data[$i];
					if (!isSet($idToName[$value['id_user']])) {
						$stmt = $db -> prepare('SELECT * FROM "users" WHERE "id" = :id LIMIT 1');
						$stmt -> execute(array('id' => $value['id_user']));
						$us = $stmt->fetchAll();
						$idToName[$value['id_user']] = $us[0]["login"];
					};
					$loginAutor = $us[0]["login"];
		?>
					<li><?php echo($loginAutor . ":" . $value['text']);?></li><hr>
		<?php
				}
			}
		?>
	</ul>
	<?php if ($user['isAutorization']) {?>
		<input type="text" id="addComment" onkeypress="if (event.keyCode == 13) addComment(this);" placeholder="Комментарий...">
	<?php } else { ?>
		Необходимо выполнить вход!
	<?php };?>
</div>
<script>
	var lastIdCommnet = <?php echo $lastIdComment?>;
	var userName = 	"<?php echo $user["login"]?>";
	$("#comments").height($("#image").height() - 117);
	updateComment(GET['v'], lastIdCommnet);
</script>