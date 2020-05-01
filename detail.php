<?php
    session_start();
    $upvote_val = 0;
    $downvote_val = 0;
    require_once "config.php";
    $sql = "SELECT * FROM creaturereview WHERE id =".$_GET['id'];
    $query = mysqli_query($link, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        $row = mysqli_fetch_assoc($query);
        $upvote_val = $row['upvote'];
        $downvote_val = $row['downvote'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Creature</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body id="infoPage">
    <div id='mainInfoPage'>
        <form action="search.php" method="get">
        <input type="text" class="search" id="secondSearch" name = "key" placeholder="Search.."/>
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
        <div>
            <button type="submit" name="vote" class="vote" value="upvote" id="upvote"></button>
            <span id="s_upvote"><?php echo $upvote_val?></span>
        </div>
        <div>
            <button type="submit" name="vote" class="vote" value="downvote" id="downvote"></button>
            <span id="s_downvote"><?php echo $downvote_val?></span>
        </div>
    <?php
        if(isset($_GET['id']) && $_GET['id'] != '')
        {
            $query_string = "SELECT * FROM creature WHERE ID =".$_GET['id'];
            $query = mysqli_query($link, $query_string);
            $row = mysqli_fetch_assoc($query);
            $query_string = "SELECT * FROM users WHERE ID =".$row['author'];
            $query_user = mysqli_query($link, $query_string);
            $row_user = mysqli_fetch_assoc($query_user);
            echo"<div id='detailTop'><img src='".$row['imageLink']."' id='detailImage'>";
            echo"Tên: ".$row['name']."<br><br>"."Lớp: ".$row['class']."<br><br>
                Tác giả:".$row_user['username']."</div>";
            echo"<div id='content'>Đặc điểm nhận dạng:".$row["identifyingCharacteristic"]."<br><br>";
            echo "Sinh học, sinh thái:".$row["biologicalCharacteristic"]."<br><br>";
            echo "Phân bố:".$row["habitat"]."<br><br>";
            echo "Giá trị:".$row["worth"]."<br><br>";
            echo "Tình trạng:".$row["status"]."<br><br></div>";
        }
    ?>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        $('.vote').click(function (){
            var vote = $(this).val();
            var post_id = <?php echo $_GET['id']?>;
            var user_id = <?php echo $_SESSION['creature_id']?>;
            $('#test').html(post_id);
            $.ajax({
                url:"vote.php",
                method:"POST",
                data: {vote: vote, post_id: post_id, user_id: user_id},
                success: function(data)
                {
                    var ar = data.split(" ");
                    $('#s_upvote').html(ar[0]);
                    $('#s_downvote').html(ar[1]);
                }
            });
        });
    });
</script>
</html>