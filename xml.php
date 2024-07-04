<?php
session_start();

include_once 'Query.php';
if(!isset($_SESSION['NumerKlienta']) ) {
    header('Location: index.php');
    exit();
} 

$o1 = new OrderDetails(new User($db,$_SESSION['phone'],$_SESSION['password']),$_GET['orderid']);
$user = $o1 -> getData();

if($user==null) {
    header('Location: index.php');
    exit();
}

$result = $o1->getBoxes();

$xml = new SimpleXMLElement('<Zamowienie></Zamowienie>');

function array_to_xml($tablica, &$xml) {
    foreach ($tablica as $klucz => $wartosc) {
        if (is_array($wartosc)) {
            $subnode = $xml->addChild($klucz);
            array_to_xml($wartosc, $subnode);
        } elseif (is_object($wartosc)) {
            $subnode = $xml->addChild('produkt');
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

$db=null;