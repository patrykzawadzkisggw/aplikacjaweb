<?php
session_start();
include_once 'connect.php';

if(!isset($_SESSION['koszyk']) ) {
    header('Location: index.php');
    exit();
} 

if(isset($_POST["productChange"])) {
    $_SESSION['koszyk'][$_POST["productChange"]]=$_POST["ile"];
    unset($_POST["productChange"]);
    unset($_POST["ile"]);
}
if(isset($_GET['removeitem'])) {
    unset($_SESSION['koszyk'][$_GET['removeitem']]);
    unset($_GET['removeitem']);
}
if(isset($_SESSION['koszyk'])){
$ids = array_keys($_SESSION['koszyk']);
$query = "select idPudelka, NazwaPudelka, Cena,url from pudelka WHERE idPudelka IN ('" . implode("','", $ids) . "')";

$stmt = $db->query($query);
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\style.css">
    <script src="js/numberbox2.js" defer></script>
    <script src="js/cardRemove.js" defer></script>
</head>
<body>
    <main>
        <h2>kup teraz</h2>
        <div class="orders">
            <?php
            if(isset($_SESSION['koszyk'])):
            $suma=0.0;
            foreach($result as $p):
                $pom=((float)$p->Cena) * ((float)$_SESSION['koszyk'][$p->idPudelka]) ;
                $suma+=$pom;
            ?>
            <div class="order-light">
                <img src="<?=$p-> url?>" alt="">
                <div class="col">
                    <h3><?=$p->NazwaPudelka?> <?=$p->Cena?>zł</h3>
                    <form action="" method="post">
                    <input type="hidden" name="productChange" value="<?=$p-> idPudelka?>">
                    <div class="numberbox">
                        <input type="button" value="-" class="minus">
                        <input type="number" min="1" max="99" class="val" name="ile" value="<?=$_SESSION['koszyk'][$p->idPudelka]?>">
                        <input type="button" value="+" class="plus">
                    </div>
                    </form>
                    <p>razem: <?=$pom?>zł</p>
                    <a href="buynow.php?removeitem=<?=$p-> idPudelka?>"><input type="button" value="" class="remove"></a>
                </div>
            </div>
            <?php endforeach;
            endif;
            ?>
            
        </div>
        <?php if(isset($_SESSION['koszyk'])): ?>
        <p>Razem: <?=$suma?>zł</p>
        <a href="data.php"><input type="button" value="Kup" class="btn"></a>
<?php
endif;
?>
    </main>
</body>
</html>

<?php

$db=null;