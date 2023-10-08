<?php
require_once "connect.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD']==='GET' && $_SERVER['REQUEST_URI']==='/witryna/api.php/pudelka') {
    
    $stmt = $db -> prepare('select idPudelka, NazwaPudelka, Cena,url from pudelka');
    $stmt -> execute();
    $result = $stmt -> fetchAll(PDO::FETCH_OBJ);
    echo json_encode($result);
    $db=null;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/\/witryna\/api\.php\/pudelko\/(\w{1,})/', $_SERVER['REQUEST_URI'], $matches)) {
    $id = $matches[1];
    $stmt = $db -> prepare('select idPudelka, NazwaPudelka, Cena, Opis,url from pudelka where idPudelka = :id');
    $stmt -> execute(['id' => $id]);
    $result = $stmt -> fetchAll();
    echo json_encode($result);
    $db=null;
    exit();
}   

$db=null;
?>