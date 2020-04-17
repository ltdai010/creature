<?php 
	session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Creature</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<form action="search.php" method="get">
		<input type="text" class="search" id="secondSearch" name = "key" placeholder="Search.."/>
		<div id="class_container">
			<label for="class">Lớp:</label>
			<select name="class" id="class" >
				<option value="Tất cả">Tất cả</option>
				<option value="Bò sát">Bò sát</option>
				<option value="Thú">Thú</option>
				<option value="Côn trùng">Côn trùng</option>
				<option value="Cá">Cá</option>
				<option value="Chim">Chim</option>
			</select>
		</div>
		<input type="submit" id="submit_search" value="Search"/>
	</form>
	<div id=account_container>
		<button id="account" onclick="window.location.href='login.php';"></button>
		<label for="account" style="font-family: 'Arial'">
		<?php 
				if(!isset($_SESSION["creature_loggedin"]) || $_SESSION["creature_loggedin"] !== true){
	    			echo "Đăng nhập, Đăng ký";
				}
				else {
					echo $_SESSION["creature_username"];
				}
		?></label>
	</div>
	<?php
		require_once "config.php";
		
		if(isset($_GET['class']) && $_GET['class'] != '' && $_GET['class'] != 'Tất cả')
		{
			// save the class from the url
			$class = trim($_GET['class']);
			$class = preg_replace('/([^\pL\.\ ]+)/u', '', $class);
			if (isset($_GET['key']) && $_GET['key'] != ''){
						
				// save the keywords from the url
				$key = trim($_GET['key']);
				$key = preg_replace('/([^\pL\.\ ]+)/u', '', $key);

				// create a base query and words string
				$query_string = "SELECT * FROM creature WHERE class ='".$class."' AND";
				$display_words = "";

				// seperate each of the name
				$name = explode(' ', $key); 
				foreach($name as $word){
					$query_string .= " name LIKE '%".$word."%' OR ";
					$display_words .= $word." ";
				}
				$query_string = substr($query_string, 0, strlen($query_string) - 3);

				// connect to the database
				$query = mysqli_query($link, $query_string);
				$result_count = mysqli_num_rows($query);

				// check to see if any results were returned
				if ($result_count > 0){
								
					// display search result count to user
					echo '<br /><div class="right"><b><u>'.$result_count.'</u></b> results found</div>';
					echo 'Your search for <i>'.$display_words.'</i> <hr /><br />';


					// display all the search results to the user
					while ($row = mysqli_fetch_assoc($query)){
									
						echo "<div class="."'searchResult'"."><a href='detail.php?id=".$row["ID"]."'>Tên: " . $row["name"]. "</a>-Lớp: " . $row["class"]. "<br>";
						echo "<img class='". "searchImage". "'src='". $row["imageLink"] ."'>";
						$prepage = substr($row["identifyingCharacteristic"], 0, 1000);
						$prepage .= "...";
						echo "$prepage"."<br></div>";
					}

				}
				else
				echo 'No results found. Please search something else.';
			}
			else{
				// create a base query and words string
				$query_string = "SELECT * FROM creature WHERE class LIKE'".$class."'";


				// connect to the database

				$query = mysqli_query($link, $query_string);
				$result_count = mysqli_num_rows($query);

				// check to see if any results were returned
				if ($result_count > 0){
								
					// display search result count to user
					echo '<br /><div class="right"><b><u>'.$result_count.'</u></b> results found</div>';
					echo 'Your search for <i>'.$class.'</i> <hr /><br />';

			

					// display all the search results to the user
					while ($row = mysqli_fetch_assoc($query)){
									
						echo "<div class="."'searchResult'"."><a href='detail.php?id=".$row["ID"]."'>Tên: " . $row["name"]. "</a>-Lớp: " . $row["class"]. "<br>";
						echo "<img class='". "searchImage". "'src='". $row["imageLink"] ."'>";
						$prepage = substr($row["identifyingCharacteristic"], 0, 1000);
						$prepage .= "...";
						echo "$prepage"."<br></div>";
					}

					
				}
				else
				echo 'No results found. Please search something else.';
			}
		}
		else if (isset($_GET['key']) && $_GET['key'] != ''){
						
				// save the keywords from the url
				$key = trim($_GET['key']);
				$key = preg_replace('/([^\pL\.\ ]+)/u', '', $key);
				// create a base query and words string
				$query_string = "SELECT * FROM creature WHERE ";
				$display_words = "";

				// seperate each of the name
				$name = explode(' ', $key); 
				foreach($name as $word){
					$query_string .= " name LIKE '%".$word."%' OR ";
					$display_words .= $word." ";
				}
				$query_string = substr($query_string, 0, strlen($query_string) - 3);

				// connect to the database
				$query = mysqli_query($link, $query_string);
				$result_count = mysqli_num_rows($query);

				// check to see if any results were returned
				if ($result_count > 0){
								
					// display search result count to user
					echo '<br /><div class="right"><b><u>'.$result_count.'</u></b> results found</div>';
					echo 'Your search for <i>'.$display_words.'</i> <hr /><br />';

					

					// display all the search results to the user
					while ($row = mysqli_fetch_assoc($query)){
									
						echo "<div class="."'searchResult'"."><a href='detail.php?id=".$row["ID"]."'>Tên: " . $row["name"]. "</a>-Lớp: " . $row["class"]. "<br>";
						echo "<img class='". "searchImage". "'src='". $row["imageLink"] ."'>";
						$prepage = substr($row["identifyingCharacteristic"], 0, 1000);
						$prepage .= "...";
						echo "$prepage"."<br></div>";
					}

					
				}
				else
				echo 'No results found. Please search something else.';
			}	
	?>
</body>
</html>
