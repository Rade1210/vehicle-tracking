<?php 
define('DB_HOST', 'localhost'); 
define('DB_USERNAME', 'u265055216_root'); 
define('DB_PASSWORD', '875254Broj#'); 
define('DB_NAME', 'u265055216_vehicles');

date_default_timezone_set('Europe/Belgrade');

// Connect with the database 
$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME); 
 
// Display error if failed to connect 
if ($db->connect_errno) { 
    echo "Connection to database is failed: ".$db->connect_error;
    exit();
}