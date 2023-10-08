<?php
session_start();
include_once 'connect.php';
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
$stmt = $db -> prepare('select Imie,Nazwisko,Ulica,Miasto, KodPocztowy,Kraj from klienci where NumerKlienta = :numer and haslo = :haslo');
    $stmt -> execute(['numer' => $_SESSION['NumerKlienta'],'haslo' => $_SESSION['password']]);
    $result = $stmt -> fetchAll();
    

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
    include 'menu.php';
    ?>
    <main>
        
        <form action="orders.php" method="POST">
            
            <h2>Dane Dostawy</h2>
            <h2></h2>
           <div class="gridfrm">
            <div class="input" data-val="imie" >
                <input type="text" name="imie2" value="<?php 
                if (isset($_SESSION['imie2']) && !is_null($_SESSION['imie2'])) {
        echo $_SESSION['imie2'];
    } else if (isset($result[0][0]) && !is_null(isset($result[0][0]))) {
        echo $result[0][0];
    } else {
        echo "";
    }
                
                ?>">
            </div>
            <div class="input" data-val="nazwisko">
                <input type="text" name="nazwisko" value="<?php 
                if (isset($_SESSION['nazwisko']) && !is_null($_SESSION['nazwisko'])) {
        echo $_SESSION['nazwisko'];
    } else if (isset($result[0][1]) && !is_null(isset($result[0][1]))) {
        echo $result[0][1];
    } else {
        echo "";
    }
                
                ?>">
            </div>
            <div class="input span street" data-val="ulica">
                <input type="text" name="ulica" value="<?php 
                if (isset($_SESSION['ulica']) && !is_null($_SESSION['ulica'])) {
        echo $_SESSION['ulica'];
    } else if (isset($result[0][2]) && !is_null(isset($result[0][2]))) {
        echo $result[0][2];
    } else {
        echo "";
    }
                
                ?>">
            </div>
            <div class="input city" data-val="miasto">
                <input type="text" name="miasto" value="<?php 
                if (isset($_SESSION['miasto']) && !is_null($_SESSION['miasto'])) {
        echo $_SESSION['miasto'];
    } else if (isset($result[0][3]) && !is_null(isset($result[0][3]))) {
        echo $result[0][3];
    } else {
        echo "";
    }
                
                ?>">
            </div>
            <div class="input zip" data-val="kod">
                <input type="text" name="kod" value="<?php 
                if (isset($_SESSION['kod']) && !is_null($_SESSION['kod'])) {
        echo $_SESSION['kod'];
    } else if (isset($result[0][4]) && !is_null(isset($result[0][4]))) {
        echo $result[0][4];
    } else {
        echo "";
    }
                
                ?>">
            </div>
            <div class="input span country" data-val="kraj">
                <input type="text" name="kraj" value="<?php 
                if (isset($_SESSION['kraj']) && !is_null($_SESSION['kraj'])) {
        echo $_SESSION['kraj'];
    } else if (isset($result[0][5]) && !is_null(isset($result[0][5]))) {
        echo $result[0][5];
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