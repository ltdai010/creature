<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["creature_loggedin"]) || $_SESSION["creature_loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>creature</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
	<table>
	  	<tr>
		    <th>Tên sinh vật</th>
		    <th>Lớp</th>
		    <th>Số upvote</th>
		    <th>Số downvote</th>
		    <th>Hiệu số bình chọn</th>
	  	</tr>
	  	<?php
  		require_once "config.php";

  		$sql = "SELECT * FROM creature WHERE author =".$_SESSION["creature_id"];
  		$query = mysqli_query($link, $sql);
  		if(mysqli_num_rows($query) > 0)
	    {
	        while ($row = mysqli_fetch_assoc($query)) 
	        {
	        	echo "<tr>
			    <td><a style='text-decoration: none; color: black;' href='detail.php?id=".$row['ID']."'>".$row['name']."</a></td>
			    <td><a style='text-decoration: none; color: black;' href='search.php?class=".$row['class']."'>".$row['class']."</td>";
			    $sql = "SELECT *, (upvote - downvote) as difference FROM creaturereview WHERE id =".$row['ID'];
			    $query_vote = mysqli_query($link, $sql);
			    if(mysqli_num_rows($query_vote) > 0)
			    {
			    	$row_vote = mysqli_fetch_assoc($query_vote);
				    echo "<td>".$row_vote['upvote']."</td>
				    	  <td>".$row_vote['downvote']."</td>
				    	  <td>".$row_vote['difference']."</td>
				  	</tr>";
			    }
			    else
			    {
			    	echo "<td>0</td>
			    		  <td>0</td>
			    		  <td>0</td>
				  		  </tr>";
			    }
	        }
	    }
  		?>
  	</table>
  	<br>
  	<button onclick="window.location.href='index.php'" >Về trang chủ</button>
  	<button onclick="window.location.href='account.php'">Về trang tài khoản</button>
</body>
</html>