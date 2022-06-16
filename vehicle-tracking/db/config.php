<?php 
define('DB_HOST', 'db-vehicles.clam63y6v8ul.us-east-1.rds.amazonaws.com'); 
define('DB_USERNAME', 'Rade1210'); 
define('DB_PASSWORD', 'U#u!m%p333'); 
define('DB_NAME', 'vehicles');

date_default_timezone_set('Europe/Belgrade');

// Connect with the database 
$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME); 
 
// Display error if failed to connect 
if ($db->connect_errno) { 
    echo "Connection to database is failed: ".$db->connect_error;
    exit();
}