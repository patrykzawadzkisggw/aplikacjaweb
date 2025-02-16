<?php
session_start();
include_once 'Query.php';
$ok=true;

if(isset($_SESSION['NumerKlienta']) ) {
    header('Location: index.php');
    exit();
} 

if (isset($_FILES['plik_xml']['tmp_name']) && !empty($_FILES['plik_xml']['tmp_name'])) {
    $plik_tmp = $_FILES['plik_xml']['tmp_name'];

    
    $xml = simplexml_load_file($plik_tmp);

    if ($xml) {
        
        $_POST['imie'] = (string)$xml->imie;
        $_POST['nazwisko'] = (string)$xml->nazwisko;
        $_POST['phone'] = (string)$xml->telefon;
        $_POST['password'] = (string)$xml->haslo;
    } 
    
}

$obiekt = [
    [
        'name'=> 'imie',
        'pattern' => '/^[^\d\W]{3,}$/'
    ],
    [
        'name'=> 'nazwisko',
        'pattern' => '/^[^\d\W]{3,}$/'
    ],
    [
        'name'=> 'phone',
        'pattern' => '/^(\+\d{1,4}[- ]?)?\d{3,}([ -]?\d{2,}){1,}$/'
    ],
    [
        'name'=> 'password',
        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/'
    ]
];

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
    
    
    try {
        $u1 = User::addUser($db,$_POST['imie'],$_POST['nazwisko'],$_POST['phone'],$_POST['password']);
        $result = $u1 -> getUser();
        $_SESSION['NumerKlienta']=$u1 -> getId() ;
        $_SESSION['imie']=$_POST['imie'];
        $_SESSION['nazwisko']=$_POST['nazwisko'];
        $_SESSION['password']=$_POST['password'];
        $_SESSION['phone']=$_POST['phone'];
        unset($_POST);
    } catch (Exception $th) {
        $ok=false;
        $_SESSION['phone_blad']="Wprowadź inny numer";
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
     <script src="js/create.Account.js" defer></script>
</head>
<body>
    <nav>
       <div class="nav">
            <img src="img/logo.svg" alt="" class="logo">
            <ul>
                <li><a href="index.php">Strona główna</a></li>
            </ul>
       </div>
    </nav>
    <main>
        
        <form  id="createAccount" method="POST" enctype="multipart/form-data">
            <p class="capital">ROZPOCZNIJ ZA DARMO</p>
            <h2>Utwórz koto</h2>
            <p class="message">Masz już konto? <a href="login.php">zaloguj</a></p>

           <div class="gridfrm">
            <div>
                <div class="input" data-val="imie">
                    <input type="text" id="name"  name="imie" class="<?php isError("imie_blad");?>" value="<?php PrintValue("imie");?>">
                </div>
                <span class="errorTxt"><?php printError("imie_blad");?></span>
            </div>

            <div>
                <div class="input" data-val="nazwisko">
                    <input type="text" id="surrname" name="nazwisko" class="<?php isError("nazwisko_blad");?>" value="<?php PrintValue("nazwisko");?>">
                </div>
                <span class="errorTxt"><?php printError("nazwisko_blad");?></span>
            </div>

            <div class="span">
                <div class="input phone" data-val="telefon" >
                    <input type="text" id="phone" name="phone" class="<?php isError("phone_blad");?>" value="<?php PrintValue("phone");?>">
                </div>
                <span class="errorTxt"><?php printError("phone_blad");?></span>
            </div>

            <div class="span">
                <div class="input pass span" data-val="hasło">
                    <input type="password" id="password" name="password" class="<?php isError("password_blad");?>" value="<?php PrintValue("password");?>">
                </div>
                <span class="errorTxt"><?php printError("password_blad");?></span>
            </div>

             <input type="hidden" name="plik_xml" accept=".xml" id="plik">
             <input type="submit" value="Utwórz" class="btn" id="submit1">

           </div>
        </form>
    </main>
</body>
</html>