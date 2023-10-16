<?php
function countProducts() {
    $suma=0;
    if(isset($_SESSION['koszyk'])) {
        foreach( $_SESSION['koszyk'] as $p) {

            $suma+=$p;
        }
    }
    return $suma;
}
function isBuyOptionAvaliable() {
    $n =basename($_SERVER['SCRIPT_NAME'])=='buynow.php' || basename($_SERVER['SCRIPT_NAME'])=='data.php';
    if(countProducts()<1 || $n) {
        ?>hidden<?php
    }
}

function isLogin() {
    if(!isSet($_SESSION["NumerKlienta"])): ?>hidden<?php endif;
        
}

function isNotLogin2() {
    if(!isSet($_SESSION["NumerKlienta"])): ?>display: none !important<?php endif;
        
}

function isNotLogin() {
    if(isSet($_SESSION["NumerKlienta"])): ?>hidden<?php endif;
}

?>

<nav>
        <div class="nav">
            <img src="img/logo.svg" alt="" class="logo">
        <ul>
         <li><a href="buynow.php" class="buy <?= isBuyOptionAvaliable() ?>" data-ile="<?=countProducts()?>"><img src="img/shopping-cart.svg" alt="" ></a></li>
         
        </ul>
        <a href="login.php" class="marginleft-max"><input type="button" value="Zaloguj" class="btn <?php isNotLogin()?>"></a>
        <div class="inline " style="<?php isNotLogin2()?>">
           <input type="text"><img src="img/user2.svg" alt="" class="loginoptions">
            <div class="options">
                <ul>
                    <li><a href="index.php">produkty</a></li>
                    <li><a href="orders.php">zamowienia</a></li>
                    <li><a href="buynow.php">koszyk</a></li>
                    <li><a href="data.php">Dane</a></li>
                    <li><a href="logout.php">wyloguj</a></li>
                </ul>
            </div>
        </div>
        </div>
     </nav>

    