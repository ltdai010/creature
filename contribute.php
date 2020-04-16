<?php
// Initialize the session
session_start();
 
if(!isset($_SESSION["creature_loggedin"]) || $_SESSION["creature_loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $identifyingCharacteristic = $biologicalCharacteristic = $habitat = $worth = $status = $image = $class = "";
$name_err = $identifyingCharacteristic_err = $biologicalCharacteristic_err = $habitat_err = $worth_err = $status_err = $image_err = $class_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if name is empty
    if(empty(trim($_POST["name"]))){
        $name_err = "Nhập tên";
    } else{
        $sql = "SELECT id FROM creature WHERE name = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $name_err = "Tên sinh vật đã được đặt.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Check if identifyingCharacteristic is empty
    if(empty(trim($_POST["identifyingCharacteristic"]))){
        $identifyingCharacteristic_err = "Nhập đặc điểm nhận dạng";
    } else{
        $identifyingCharacteristic = trim($_POST["identifyingCharacteristic"]);
    }

    if(empty(trim($_POST["habitat"]))){
        $habitat_err = "Nhập nơi cư trú";
    } else{
        $habitat = trim($_POST["habitat"]);
    }

    if(empty(trim($_POST["biologicalCharacteristic"]))){
        $biologicalCharacteristic_err = "Nhập tập tính sinh học";
    } else{
        $biologicalCharacteristic = trim($_POST["biologicalCharacteristic"]);
    }

    if(empty(trim($_POST["worth"]))){
        $worth_err = "Nhập giá trị sinh vật";
    } else{
        $worth = trim($_POST["worth"]);
    }

    if(empty(trim($_POST["status"]))){
        $status_err = "Nhập tình trạng hiện tại";
    } else{
        $status = trim($_POST["status"]);
    }

    if(empty(trim($_POST["class"]))){
        $class_err = "Nhập lớp";
    }else{
        $class = trim($_POST["class"]);
    }

    //upload image
    if(empty($name_err))
    {
        $target_dir = "uploads/".$name;
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
        $image_err = "Error";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = "uploads/".$name.$_FILES["image"]["name"];
            } else {
                $image_err = "Error";
            }
        }
    }
    
    // Validate credentials
    if(empty($name_err) && empty($identifyingCharacteristic_err) && empty($biologicalCharacteristic_err) && empty($habitat_err) && empty($worth_err) && empty($status_err) && empty($image_err) && empty($class_err)){
        // Prepare a select statement
        // Prepare an insert statement
        $sql = "INSERT INTO creature (name, identifyingCharacteristic, biologicalCharacteristic, habitat, worth, status, imageLink, class) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_name, $param_identifyingCharacteristic, $param_biologicalCharacteristic, $param_habitat, $param_worth, $param_status, $param_imageLink, $param_class);
            
            // Set parameters
            $param_name = $name;
            $param_identifyingCharacteristic = $identifyingCharacteristic; 
            $param_biologicalCharacteristic = $biologicalCharacteristic;
            $param_habitat = $habitat;
            $param_worth = $worth;
            $param_status = $status;
            $param_imageLink = $image;
            $param_class = $class;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: contribute_result.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Creature</title>
    <link rel="stylesheet" href="main.css">
</head>
<body style="background-color: #bababa">
    <h1>Đóng góp sinh vật</h2>
    <p>Điền thông tin về sinh vật</p>
    <form id="contribute_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div>
            <label for="name" style="float: left; width: 15%;">Tên</label>
            <input type="text" name="name" value="<?php echo $name ?>">
            <span class="help-block"><?php echo $name_err; ?></span>
        </div>    
        <br>
        <div>
            <label for="identifyingCharacteristic" style="float: left; width: 15%;">Đặc điểm nhận dạng</label>
            <textarea name="identifyingCharacteristic"></textarea>
            <span><?php echo $identifyingCharacteristic_err; ?></span>
        </div>
        <br>
        <div>
            <label for="biologicalCharacteristic" style="float: left; width: 15%;">Đặc điểm sinh học</label>
            <textarea name="biologicalCharacteristic"></textarea>
            <span><?php echo $biologicalCharacteristic_err; ?></span>
        </div>
        <br>
        <div>
            <label for="habitat" style="float: left; width: 15%;">Môi trường sống</label>
            <textarea name="habitat" ></textarea>
            <span><?php echo $habitat_err; ?></span>
        </div>
        <br>
        <div>
            <label for="worth" style="float: left; width: 15%;">Giá trị</label>
            <textarea name="worth" ></textarea>
            <span><?php echo $worth_err; ?></span>
        </div>
        <br>
        <div>
            <label for="status" style="float: left; width: 15%;">Tình trạng</label>
            <textarea name="status" ></textarea>
            <span><?php echo $status_err; ?></span>
        </div>
        <br>
        <div>
            <label for="class" style="float: left; width: 15%;">Lớp</label>
            <select name="class">
                <option value="">--</option>
                <option value="Bò sát">Bò sát</option>
                <option value="Cá">Cá</option>
                <option value="Chim">Chim</option>
                <option value="Thú">Thú</option>
                <option value="Công trùng">Côn trùng</option>
            </select>
            <span><?php echo $class_err; ?></span>
        </div>
        <br>
        <div>
            <label for="image" style="float: left; width: 15%;">Chọn hình ảnh</label>
            <input type="file" name="image">
            <span><?php echo $image_err; ?></span>
        </div>
        <br>
        <div>
           <input type="submit" value="Hoàn thành">
           <input type="button" value="Về trang chủ" onclick="window.location.href='index.php'">
        </div>
    </form>

</body>
</html>