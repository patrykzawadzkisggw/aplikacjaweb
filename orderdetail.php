<?php
session_start();
include_once 'Query.php';

if(!isset($_SESSION['NumerKlienta']) ) {
    header('Location: index.php');
    exit();
}

$o1 = new OrderDetails(new User($db,$_SESSION['phone'],$_SESSION['password']),$_GET['orderid']);
$result = $o1 -> getData();

if($result==null) {
    header('Location: index.php');
    exit();
}

function renderRow($p,$pom) { ?>
    <tr>
        <td><?= $p->nazwapudelka ?></td>
        <td><?= $p->Cena ?>zł</td>
        <td><?= $p->Ilosc ?></td>
        <td><?=str_replace('.',',',$pom)?>zł</td>
    </tr>
<?php
}

$sum=0;

function renderProducts($result, &$sum) {
    
    foreach ($result as $p):
        $pom=(int)$p->Ilosc * (float)str_replace(',','.',$p->Cena);
        $sum+=$pom;
        renderRow($p,$pom);
    endforeach;
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
    <div class="fixed">
        <?php include_once 'menu.php'; ?>
    </div>

    <main>
        <h2>Szczegóły</h2>

        <p>imie: <?=$result-> ImieOdbiorcy?> <br>
           nazwisko: <?=$result-> NazwiskoOdbiorcy?><br>           
           data: <?=$result-> DataZamowienia?><br>            
           miasto: <?=$result-> MiastoOdbiorcy?><br>            
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
                $result = $o1->getBoxes();
                renderProducts($result,$sum);
            ?>
            <tr>
                <td colspan="3">razem</td>
                <td><?=str_replace('.',',',$sum)?>zł</td>
            </tr>
        </table>

        <a href="xml.php?orderid=<?=$_GET['orderid']?>">wygeneruj xml zamówienia</a>
    </main>
</body>
</html>

<?php
$db=null;