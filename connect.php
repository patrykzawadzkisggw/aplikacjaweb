<?php
$dotenv = parse_ini_file(__DIR__ . '/.env');
$host = $dotenv['MYSQL_HOST'];
$user = $dotenv['MYSQL_USER'];
$password = $dotenv['MYSQL_PASSWORD'];
$db_name = $dotenv['MYSQL_DATABASE'];
try {
    $db = new PDO("mysql:host=$host;dbname=$db_name",$user,$password);
} catch(Exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>