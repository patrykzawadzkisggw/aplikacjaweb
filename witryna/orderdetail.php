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
if(count($result)!=1) {
    header('Location: index.php');
    exit();
}
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
        
        <h2>Szczegóły</h2>
        <p>imie: <?=$result[0]-> ImieOdbiorcy?> <br>
            nazwisko: <?=$result[0]-> NazwiskoOdbiorcy?><br>           
            data: <?=$result[0]-> DataZamowienia?><br>            
            miasto: <?=$result[0]-> MiastoOdbiorcy?><br>            
                      
        </p>
        <table border="1">
            <thead>
                <tr>
                    <td>nazwa</td>
                    <td>cena jed.</td>
                    <td>ilość</td>
                    <td>wartość</td>
                </tr>
            </thead>
            <?php
            $stmt = $db -> prepare('SELECT nazwapudelka,Cena, Ilosc from szczegoly_zamowien INNER JOIN pudelka on pudelka.IdPudelka=szczegoly_zamowien.IdPudelka WHERE NumerZamowienia=:num;');
            $stmt -> execute(['num' => $_GET['orderid']]);
            $result = $stmt -> fetchAll(PDO::FETCH_OBJ);
            $sum=0;
            foreach ($result as $p):
                $pom=(int)$p->Ilosc * (float)$p->Cena;
                $sum+=$pom;
            ?>
            <tr>
                <td><?= $p->nazwapudelka ?></td>
                <td><?= $p->Cena ?>zł</td>
                <td><?= $p->Ilosc ?></td>
                <td><?=$pom?>zł</td>
            </tr>
<?php endforeach;?>
            <tr>
                <td colspan="3">razem</td>
                
                <td><?=$sum?>zł</td>
            </tr>
        </table>
        <a href="xml.php?orderid=<?=$_GET['orderid']?>">wygeneruj xml zamówienia</a>
    </main>
</body>
</html>

<?php
$db=null;