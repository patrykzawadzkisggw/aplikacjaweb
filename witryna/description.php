<?php
session_start();
include_once 'connect.php';
$prod="";

if(isset($_GET['product']) && $_GET['product']!='') {
    $prod=$_GET['product'];
    if(isset($_COOKIE["products"])) {
        $cisteczka = unserialize($_COOKIE["products"]);
        if(!in_array($prod, $cisteczka)) {
            if(count($cisteczka)>=3) {
                array_shift($cisteczka); 
            }
            array_push($cisteczka, $prod);
            setcookie("products", serialize($cisteczka), time() + 36*3600);
        }
    } else {
        setcookie("products", serialize([$prod]), time() + 36*3600);
    }
} else {
        header('Location: index.php');
exit();
}

if(isset($_POST['productid'])) {
    if(isset($_SESSION['koszyk'][$_POST['productid']])) {
        $_SESSION['koszyk'][$_POST['productid']]+=$_POST['ile'];
    } else {
        $_SESSION['koszyk'][$_POST['productid']]=$_POST['ile'];
    }
    unset($_POST);
    header('Location: index.php');
exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opis</title>
    <link rel="stylesheet" href="css\style.css">
    <script src="js/description.js" defer></script>
    <script src="js/numberbox.js" defer></script>
</head>
<body>
    <main class="page">
        <div class="close"><img src="img/cross.svg" alt="" height="30" ></div>
        <div class="columns">
            <h2></h2>
    <p class="price"></p>
        </div>
    <img src="https:\\unsplash.it\300\300" alt="" class="titleimg">
    <div class="desc">
        <p class="opis">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cum expedita minus dolore odit esse eum quidem harum alias, eligendi repellat assumenda, laboriosam maiores nesciunt eius asperiores exercitationem beatae facilis ullam.</p>
        <form method="POST">
            <input type="hidden" name="productid"  class="prodid" value="<?=$_GET['product']?>">
        <div class="numberbox">
            <input type="button" value="-" class="minus">
            <input type="number" value="1" min="0" max="99" class="val" name="ile">
            <input type="button" value="+" class="plus">
        </div>
        <input type="submit" value="Dodaj do koszyka" class="btn">
        </form>
    </div>
    </main>
</body>
</html>