<?php
session_start();
include_once 'Query.php';
if(!isset($_SESSION['NumerKlienta']) ) {
    header('Location: login.php');
    exit();
} 
function Display($varriable, $var2) {
    if (isset($varriable) && !is_null($varriable)) {
        return $varriable;
    } else if (isset($var2) && !is_null($var2)) {
        return $var2;
    } else {
        return "";
    }
}
$u = new User($db, $_SESSION['phone'],$_SESSION['password']);
$result= $u -> getUser();


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
<?php
    include 'menu.php';
    ?>
</div>
    <main>
        
        <form action="orders.php" method="POST">
            
            <h2>Dane Dostawy</h2>
            <h2></h2>
           <div class="gridfrm">
            <div class="input" data-val="imie" >
                <input type="text" name="imie2" value="<?php 
                if (isset($_SESSION['imie2']) && !is_null($_SESSION['imie2'])) {
        echo $_SESSION['imie2'];
    } else if (isset($result-> Imie) && !is_null(isset($result -> Imie))) {
        echo $result -> Imie;
    } else {
        echo "";
    }
                
                ?>">
            </div>
            <div class="input" data-val="nazwisko">
                <input type="text" name="nazwisko" value="<?php 
                if (isset($_SESSION['nazwisko']) && !is_null($_SESSION['nazwisko'])) {
        echo $_SESSION['nazwisko'];
    } else if (isset($result -> Nazwisko) && !is_null(isset($result -> Nazwisko))) {
        echo $result  -> Nazwisko;
    } else {
        echo "";
    }
                
                ?>">
            </div>
            <div class="input span street" data-val="ulica">
                <input type="text" name="ulica" value="<?php 
                if (isset($_SESSION['ulica']) && !is_null($_SESSION['ulica'])) {
        echo $_SESSION['ulica'];
    } else if (isset($result  -> Ulica) && !is_null(isset($result -> Ulica))) {
        echo $result -> Ulica;
    } else {
        echo "";
    }
                
                ?>">
            </div>
            <div class="input city" data-val="miasto">
                <input type="text" name="miasto" value="<?php 
                if (isset($_SESSION['miasto']) && !is_null($_SESSION['miasto'])) {
        echo $_SESSION['miasto'];
    } else if (isset($result -> Miasto) && !is_null(isset($result -> Miasto))) {
        echo $result -> Miasto;
    } else {
        echo "";
    }
                
                ?>">
            </div>
            <div class="input zip" data-val="kod">
                <input type="text" name="kod" value="<?php 
                if (isset($_SESSION['kod']) && !is_null($_SESSION['kod'])) {
        echo $_SESSION['kod'];
    } else if (isset($result -> KodPocztowy) && !is_null(isset($result -> KodPocztowy))) {
        echo $result -> KodPocztowy;
    } else {
        echo "";
    }
                
                ?>">
            </div>
            <div class="input span country" data-val="kraj">
                <input type="text" name="kraj" value="<?php 
                if (isset($_SESSION['kraj']) && !is_null($_SESSION['kraj'])) {
        echo $_SESSION['kraj'];
    } else if (isset($result -> Kraj) && !is_null(isset($result  -> Kraj))) {
        echo $result  -> Kraj;
    } else {
        echo "";
    }
                
                ?>">
            </div>      
            <input type="submit" value="Zapisz" class="btn">
           </div>
        </form>
    </main>
</body>
</html>

<?php
$db =null;