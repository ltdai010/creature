<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
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
								
					echo "Tên: " . $row["name"]. " -Lớp: " . $row["class"]. "<br>";
				}

				echo '</table>';
			}
			else
			echo 'No results found. Please search something else.';
		}
		else if(isset($_GET['class']) && $_GET['class'] != '')
		{
			// save the keywords from the url
			$class = trim($_GET['class']);

			// create a base query and words string
			$query_string = "SELECT * FROM creature WHERE class LIKE".$class;


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
								
					echo "Tên: " . $row["name"]. " -Lớp: " . $row["class"]. "<br>";
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
