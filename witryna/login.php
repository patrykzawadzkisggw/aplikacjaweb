<?php
session_start();
include_once 'connect.php';
$ok=true;

if(isset($_SESSION['NumerKlienta']) ) {
    header('Location: index.php');
    exit();
} 


$obiekt = [
    [
        'name'=> 'phone',
        'pattern' => '/^(\+\d{1,4}[- ]?)?\d{3,}([ -]?\d{2,}){1,}$/'
    ],
    [
        'name'=> 'password',
        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/'
    ]];
foreach($obiekt as $b):
    $a=$b['name'];

if(isSet($_POST[$a])) {
    
    $key = trim($_POST[$a]);
    $_SESSION[$a]=$key;
    if(empty($key)) {
        $_SESSION["{$a}_blad"] ="{$a} nie może być puste.";
		$ok=false;
} else if(strlen($key) < 3 || strlen($key) > 50) {
    $_SESSION["{$a}_blad"] ="{$a} zły rozmiar.";
    
    $ok=false;
} else if(!preg_match($b['pattern'], $key)) {
    $_SESSION["{$a}_blad"] ="{$a} jest niepoprawny.";
    $ok=false;
}
}
endforeach;

function printError($E) {
    if(isSet($_SESSION[$E])): ?>
            <?=$_SESSION[$E]?>
    <?php endif;
    $_SESSION[$E]='';
    unset($_SESSION[$E]);
    
}

function PrintValue($E) {
    if(isSet($_POST[$E])): ?><?=$_POST[$E]?><?php endif;
unset($_POST[$E]);
}

function isError($E) {
    if(isSet($_SESSION[$E])): ?>error<?php endif;
}

if($ok && !empty($_POST)) {
    
    $stmt = $db -> prepare('SELECT NumerKlienta,imie,nazwisko FROM klienci where Telefon= :phone and haslo= :password;');
    $stmt -> execute(['phone' => $_POST['phone'], 'password' => md5($_POST['password'])]);
    $result = $stmt -> fetchAll();
    
    if(empty($result)) {
        $ok=false;
        $_SESSION['password_blad']="Zły telefon lub hasło";
        $_SESSION['phone_blad']="Zły telefon lub hasło";
    } else {
        $_SESSION['NumerKlienta']=$result[0]['NumerKlienta'];
        $_SESSION['imie']=$result[0]['imie'];
        $_SESSION['nazwisko']=$result[0]['nazwisko'];
        $_SESSION['password']=md5($_POST['password']);
        $_SESSION['phone']=$_POST['phone'];
        unset($_POST);
    }
}
$db=null;

if(isset($_SESSION['NumerKlienta']) ) {
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
    <script src="js/login.js" defer></script>
</head>
<body>
    
    <main>
        <nav>
       <div class="nav">
        <img src="img/logo.svg" alt="" class="logo">
       <ul>
        <li><a href="index.php">Strona główna</a></li>
        <li><a href="">o nas</a></li>
       </ul>
       </div>
       
       
    </nav>
        <form  id="login"  method="POST">
            <p class="capital">DZIEŃ DOBRY</p>
            <h2>Zaloguj się</h2>
            <p class="message">Nie masz jeszcze konta? <a href="register.php">utwórz je</a></p>
           <div class="gridfrm">
            
            <div class="span">
                <div class="input phone" data-val="telefon">
                    <input type="text" id="phone" name="phone" class="<?php isError("phone_blad");?>" value="<?php PrintValue("phone");?>">
                </div>
                <span class="errorTxt">
                <?php printError("phone_blad");?>
                </span>
            </div>
            <div class="span">
                <div class="input pass span" data-val="hasło">
                    <input type="password" id="password" name="password" class="<?php isError("password_blad");?>" value="<?php PrintValue("password");?>">
                </div>
                <span class="errorTxt"><?php printError("password_blad");?></span>
            </div>
              
            <input type="submit" value="Zaloguj" class="btn" id="submit1">
           </div>
        </form>
    </main>
</body>
</html>