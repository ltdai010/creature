<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Creature</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link href="https://fonts.googleapis.com/css2?family=B612&display=swap" rel="stylesheet">
</head>
<body id="infoPage">
	<div id='mainInfoPage'>
		<form action="search.php" method="get">
		<input type="text" class="search" id="secondSearch" name = "key" placeholder="Search.."/>
		<input type="submit" value="Search"/>
	</form>
	<?php
		require_once "config.php";
		if(isset($_GET['id']) && $_GET['id'] != '')
		{
			$query_string = "SELECT * FROM creature WHERE ID =".$_GET['id'];
			$query = mysqli_query($link, $query_string);
			$row = mysqli_fetch_assoc($query);
			echo"<div id='detailTop'><img src='".$row['imageLink']."' id='detailImage'>";
			echo"Tên: ".$row['name']."<br><br>"."Lớp: ".$row['class']."<br></div>";
			echo"<div id='content'>Đặc điểm nhận dạng:".$row["identifyingCharacteristic"]."<br><br>";
			echo "Sinh học, sinh thái:".$row["biologicalCharacteristic"]."<br><br>";
			echo "Phân bố:".$row["habitat"]."<br><br>";
			echo "Giá trị:".$row["worth"]."<br><br>";
			echo "Tình trạng:".$row["status"]."<br><br></div>";
		}
	?>
	</div>
</body>
</html>