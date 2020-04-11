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
			$query_string = "SELECT * FROM products WHERE ";
			$display_words = "";

			// seperate each of the productLine
			$productLine = explode(' ', $key); 
			foreach($productLine as $word){
				$query_string .= " productLine LIKE '%".$word."%' OR ";
				$display_words .= $word." ";
			}
			$query_string = substr($query_string, 0, strlen($query_string) - 3);

			// connect to the database
			$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

			$query = mysqli_query($conn, $query_string);
			$result_count = mysqli_num_rows($query);

			// check to see if any results were returned
			if ($result_count > 0){
							
				// display search result count to user
				echo '<br /><div class="right"><b><u>'.$result_count.'</u></b> results found</div>';
				echo 'Your search for <i>'.$display_words.'</i> <hr /><br />';

				echo '<table class="search">';

				// display all the search results to the user
				while ($row = mysqli_fetch_assoc($query)){
								
					echo "id: " . $row["productCode"]. " - Name: " . $row["productName"]. " "
            . $row["productLine"]. "<br>";
				}

				echo '</table>';
			}
			else
			echo 'No results found. Please search something else.';
		}
		else
		echo '';
	?>
</body>
</html>
