<?php 
define('DB_SERVER', 'us-cdbr-iron-east-01.cleardb.net');
define('DB_USER', 'b4ef8d97f5a3ce');
define('DB_PASS', 'b561fd24760cb1d');
define('DB_NAME','heroku_1cb1d5ce05fc534');
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
 mysqli_set_charset($link, 'UTF8');
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 ?>