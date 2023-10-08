<?php
session_start();
include_once 'connect.php';
if(!isset($_SESSION['NumerKlienta']) ) {
    header('Location: index.php');
    exit();
} 
$stmt = $db -> prepare('select ImieOdbiorcy,NazwiskoOdbiorcy,DataZamowienia,MiastoOdbiorcy from zamowienia where NumerZamowienia = :num and NumerKlienta= :klienum');
$stmt -> execute(['num' => $_GET['orderid'], 'klienum' => $_SESSION['NumerKlienta']]);
$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
$user=$result[0];
if(count($result)!=1) {
    header('Location: index.php');
    exit();
}

$stmt = $db -> prepare('SELECT nazwapudelka,Cena, Ilosc from szczegoly_zamowien INNER JOIN pudelka on pudelka.IdPudelka=szczegoly_zamowien.IdPudelka WHERE NumerZamowienia=:num;');
$stmt -> execute(['num' => $_GET['orderid']]);
$result = $stmt -> fetchAll(PDO::FETCH_OBJ);

$xml = new SimpleXMLElement('<root></root>');

function array_to_xml($tablica, &$xml) {
    foreach ($tablica as $klucz => $wartosc) {
        if (is_array($wartosc)) {
            $subnode = $xml->addChild($klucz);
            array_to_xml($wartosc, $subnode);
        } elseif (is_object($wartosc)) {
            $subnode = $xml->addChild('item');
            array_to_xml((array)$wartosc, $subnode);
        } else {
            $xml->addChild($klucz, htmlspecialchars($wartosc));
        }
    }
}
$tab1 = $xml->addChild('użytkownik');
$tab2 = $xml->addChild('produkty');

array_to_xml($user, $tab1);

array_to_xml($result, $tab2);


header('Content-Type: application/xml');
header('Content-Disposition: attachment; filename="plik.xml"');

echo $xml->asXML();