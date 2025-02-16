<?php
session_start();
include_once 'Query.php';

if(!isset($_SESSION['koszyk']) || $_SESSION['koszyk']==null) {
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

if($_SESSION['koszyk']!=null && $_SESSION['koszyk'] !=""){ //blad
    $kosz = new Pudelko($db);
    $result = $kosz -> getBoxes(serialize(array_keys($_SESSION['koszyk'])));
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
<div class="fixed">
<?php
    include 'menu.php';
    ?>
</div>
    <main>
        <h2>kup teraz</h2>
        <div class="orders">
            <?php
            if(isset($_SESSION['koszyk']) && $_SESSION['koszyk']!=null):
            $suma=0.0;
            foreach($result as $p):
                $pom=((float)str_replace(',','.',$p->Cena)) * ((float)$_SESSION['koszyk'][$p->idPudelka]) ;
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
            $suma = str_replace('.',',',$suma);
            endif;
            ?>
            
        </div>
        <?php if(isset($_SESSION['koszyk']) && $_SESSION['koszyk']!=null): ?>
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
if(!isset($_SESSION['koszyk']) || $_SESSION['koszyk']==null) {
    header('Location: index.php');
    exit();
} 