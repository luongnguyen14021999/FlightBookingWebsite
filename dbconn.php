<?php
$dbConn = new mysqli('localhost', 'luongwsu', 'Luong140299', 'cooper_flights');
if($dbConn->connect_error) {
    die("failed to connect to the database: " . $dbConn->connect_error);
}
?>
