<?php 
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Creature</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body id="main">
	<form action="search.php" method="get">
		<input type="text" class="search" id="mainSearch" name = "key" placeholder="Search.."/>
		<input type="submit" id="submit_search" value="Search"/>
	</form>
	<div id=account_container>
		<button id="account" onclick="window.location.href='login.php';"></button>
		<label for="account" style="font-family: 'Arial'"><?php 
			if(!isset($_SESSION["creature_loggedin"]) || $_SESSION["creature_loggedin"] !== true){
    			echo "Đăng nhập, Đăng ký";
			}
			else {
				echo $_SESSION["creature_username"];
			}
		 ?></label>
	</div>
	<form action="search.php" method="get">
		<button class="chooseButton" name="class" id="boSat" value="Bò sát" type="submit"></button>
		<button class="chooseButton" name="class" id="mammal" value="Thú" type="submit"></button>
		<button class="chooseButton" name="class" id="insect" value="Côn trùng" type="submit"></button>
		<button class="chooseButton" name="class" id="fish" value="Cá" type="submit"></button>
		<button class="chooseButton" name="class" id="bird" value="Chim" type="submit"></button>
	</form>

</body>
</html>