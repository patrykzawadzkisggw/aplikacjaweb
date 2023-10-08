<?php
session_start();
include_once 'connect.php';
$ok=true;

if(!isset($_SESSION['NumerKlienta']) ) {
    header('Location: index.php');
    exit();
} 


    if(isset($_POST['imie2'])) {
    $stmt = $db -> prepare('select max(NumerZamowienia) as n from zamowienia');
    $stmt -> execute();
    $result = $stmt -> fetchAll(PDO::FETCH_OBJ);
    $numerek= ((int)$result[0]-> n)+1;


    $stmt = $db -> prepare('UPDATE klienci SET 
    Imie=:imie,
    Nazwisko=:nazwisko,
    Miasto=:miasto,
    Ulica=:ulica,
    KodPocztowy=:kod,
    Kraj=:kraj
    WHERE NumerKlienta = :num');
    $stmt -> execute(['imie' => $_POST['imie2'],'nazwisko' => $_POST['nazwisko'],'miasto' => $_POST['miasto'],'ulica' => $_POST['ulica'],'kod' => $_POST['kod'],'kraj' => $_POST['kraj'],
    'num' => $_SESSION['NumerKlienta']]);


    $stmt = $db -> prepare("INSERT INTO zamowienia(NumerZamowienia, NumerKlienta,  DataZamowienia,  NazwiskoOdbiorcy,
     ImieOdbiorcy, UlicaOdbiorcy, MiastoOdbiorcy, 
     KodPocztowyOdbiorcy, KrajOdbiorcy) VALUES (:numer, :nrklienta, :datazam, :nazwisko, :imie, :ulica, :miasto, :kod, :kraj)");
     $stmt -> execute(['numer'=> $numerek, 'nrklienta' => $_SESSION['NumerKlienta'], 'datazam'=> date("Y-m-d"), 'imie'=> $_POST['imie2'],
     'nazwisko'=> $_POST['nazwisko'], 'ulica'=> $_POST['ulica'], 'miasto'=> $_POST['miasto'], 'kod'=> $_POST['kod'], 'kraj'=> $_POST['kraj']]);
    $result = $stmt -> fetchAll(PDO::FETCH_OBJ);

    foreach ($_SESSION['koszyk'] as $key => $value) {
        $stmt = $db -> prepare('INSERT INTO szczegoly_zamowien(NumerZamowienia, IdPudelka, Ilosc) 
        VALUES (:num, :idp, :il)');
        $stmt -> execute(['num' => $numerek, 'idp'=> $key, 'il' => $value]);
        $result = $stmt -> fetchAll(PDO::FETCH_OBJ);
    }
    unset($_SESSION['koszyk']);
    unset($_POST);

   
    }
 $stmt = $db -> prepare('select NumerZamowienia,DataZamowienia from zamowienia where NumerKlienta = :numer');
    $stmt -> execute(["numer" => $_SESSION['NumerKlienta']]);
    $result = $stmt -> fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\style.css">
</head>
<body>
<?php
    include_once 'menu.php';
    ?>
    <main>
        <h2>lista zamówień</h2>
        <div class="orders">

        <?php
        $num =1;
        foreach ($result as $k):
        ?>
            <a href="orderdetail.php?orderid=<?=$k->NumerZamowienia?>" style="all:unset; ">
            <div class="order" >
                <span><?=$num++?>#</span>
                <p><?=$k->DataZamowienia?></p>
            </div>
            </a>
            <?php endforeach;?>
        </div>
    </main>
    
</body>
</html>

<?php
$db=null;