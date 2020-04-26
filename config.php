<?php 
define('DB_SERVER', 'localhost');
define('DB_USER', 'id13443547_diaz');
define('DB_PASS', 'HsL}zAK0]CD9hepU');
define('DB_NAME','id13443547_creature');
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
 mysqli_set_charset($link, 'UTF8');
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 ?>