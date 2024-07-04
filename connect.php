<?php
$host="localhost";
$user="root";
$password="";
$db_name="cukierki";
try {
    $db = new PDO("mysql:host=$host;dbname=$db_name",$user,$password);
} catch(Exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>