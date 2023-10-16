<?php
session_start();
include_once 'Query.php';
$ok=true;

function renderCard($k) {
    static $num=1;
    ?>
            <a href="orderdetail.php?orderid=<?=$k->NumerZamowienia?>" style="all:unset; ">
            <div class="order" >
                <span><?=$num++?>#</span>
                <p><?=$k->DataZamowienia?></p>
            </div>
            </a>
    <?php
}

function renderList($result) {
        foreach ($result as $k):
            renderCard($k);
        endforeach;
}

if(!isset($_SESSION['NumerKlienta']) ) {
    header('Location: index.php');
    exit();
} 

$u1 = new User($db, $_SESSION['phone'],$_SESSION['password']);
$o1 = new Order($u1);

if(isset($_POST['imie2']) && isset($_SESSION['koszyk'])) {
    $numerek = $o1->getNextOrder();

    $u1 -> updateUser($_POST['imie2'],$_POST['nazwisko'],$_POST['miasto'],$_POST['ulica'],$_POST['kod'],$_POST['kraj']);
    $o1 -> insertOrder($_POST['imie2'],$_POST['nazwisko'],$_POST['miasto'],$_POST['ulica'],$_POST['kod'],$_POST['kraj']);

    foreach ($_SESSION['koszyk'] as $key => $value) {
        $od = new OrderDetails($u1,$numerek);
        $od->insertOrderDetail($numerek,$key,$value);
    }

    unset($_SESSION['koszyk']);
    unset($_POST);

   
}

$result =$o1->getOrders();
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
        <h2>lista zamówień</h2>
        <div class="orders">
            <?php renderList($result); ?>
        </div>
    </main>
    
</body>
</html>

<?php
$db=null;