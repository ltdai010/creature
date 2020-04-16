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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>creature</title>
    <link rel="stylesheet" href="main.css">
</head>
<body style="text-align: center;background-color: #bababa">
    <div>
        <h1>Chào, <b><?php echo htmlspecialchars($_SESSION["creature_username"]); ?></b></h1>
    </div>
    <p>
        <div>
            <a href="index.php">Trang chủ</a>
        </div>
        <br>
        <div>
            <a href="contribute.php">Đóng góp cho trang</a>
        </div>
        <br>
        <div>
            <a href="reset-password.php">Đổi mật khẩu</a>
        </div>
        <br>
        <div>
            <a href="logout.php">Sign Out of Your Account</a>
        </div>  
    </p>

</body>
</html>