<?php 
define('DB_SERVER', 'us-cdbr-iron-east-01.cleardb.net');
define('DB_USERNAME', 'b4ef8d97f5a3ce');
define('DB_PASSWORD', 'eed524752aa4497 ');
define('DB_NAME','heroku_1cb1d5ce05fc534');
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 ?>