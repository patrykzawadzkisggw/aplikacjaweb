<?php
$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');
$db_name = getenv('MYSQL_DATABASE');
try {
    $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8",$user,$password);
} catch(Exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>