<?php

?>

<ui id="lastUploude">
	<li><h3>Недавние загрузки</h3></li>
	<?php
		$stmt = $db -> prepare('SELECT * FROM "images" ORDER BY date DESC LIMIT 10');
		$stmt -> execute(array());
		$data = $stmt->fetchAll();
		foreach ($data as $key => $value) {
			$url64 = str_replace("=", "", base64_encode($value['id']));
			?>
			<li><img src="http://u2.localhost/data/image/<?php echo($url64)?>.jpeg" data-link="/?p=image&v=<?php echo($url64)?>" class="btn"></li>
			<?php
		}
	?>
</ui>
<ui id="mostPopular">
	<li><h3>Наиболее популярные</h3></li>
	<?php
		$stmt = $db -> prepare('SELECT * FROM "images" ORDER BY count_view DESC LIMIT 10');
		$stmt -> execute(array());
		$data = $stmt->fetchAll();
		foreach ($data as $key => $value) {
			$url64 = str_replace("=", "", base64_encode($value['id']));
			?>
			<li><img src="http://u2.localhost/data/image/<?php echo($url64)?>.jpeg" data-link="/?p=image&v=<?php echo($url64)?>" class="btn"></li>
			<?php
		}
	?>
</ui>