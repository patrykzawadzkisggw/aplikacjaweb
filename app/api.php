<?php
require_once "Query.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Content-Type: application/json');
$kosz = new Pudelko($db);
if($_SERVER['REQUEST_METHOD']==='GET' && str_contains($_SERVER['REQUEST_URI'], '/api.php/pudelka')) {
    $result = $kosz -> getAllBoxes();
    echo json_encode($result);
    $db=null;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/\/api\.php\/pudelko\/(\w{1,})/', $_SERVER['REQUEST_URI'], $matches)) {
    $id = $matches[1];
    $result = $kosz -> getBox($id);
    echo json_encode($result);
    $db=null;
    exit();
}   

$db=null;
?>