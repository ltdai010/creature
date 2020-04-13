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
		<input type="submit" value="Search"/>
	</form>

	<?php
		require_once "config.php";
		if (isset($_GET['key']) && $_GET['key'] != ''){
						
			// save the keywords from the url
			$key = trim($_GET['key']);

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

				echo '<table class="search">';

				// display all the search results to the user
				while ($row = mysqli_fetch_assoc($query)){
								
					echo "<div class="."'searchResult'"."><a href='detail.php?id=".$row["ID"]."'>Tên: " . $row["name"]. "</a>-Lớp: " . $row["class"]. "<br>";
					echo "<img class='". "searchImage". "'src='". $row["imageLink"] ."'>";
					$prepage = substr($row["identifyingCharacteristic"], 0, 1000);
					$prepage .= "...";
					echo "$prepage"."<br></div>";
				}

				echo '</table>';
			}
			else
			echo 'No results found. Please search something else.';
		}
		else if(isset($_GET['class']) && $_GET['class'] != '')
		{
			// save the keywords from the url
			$class = $_GET['class'];

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

				echo '<table class="search">';

				// display all the search results to the user
				while ($row = mysqli_fetch_assoc($query)){
								
					echo "<div class="."'searchResult'"."><a href='detail.php?id=".$row["ID"]."'>Tên: " . $row["name"]. "</a>-Lớp: " . $row["class"]. "<br>";
					echo "<img class='". "searchImage". "'src='". $row["imageLink"] ."'>";
					$prepage = substr($row["identifyingCharacteristic"], 0, 1000);
					$prepage .= "...";
					echo "$prepage"."<br></div>";
				}

				echo '</table>';
			}
			else
			echo 'No results found. Please search something else.';
		}else
		{
			echo " ";
		}
	?>
</body>
</html>
