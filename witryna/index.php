<?php
session_start();
include_once 'connect.php';



function welcome() {
    if(isSet($_SESSION["NumerKlienta"])): ?>
    <h2>Cześć <?=$_SESSION["imie"]?></h2>
    <?php endif;
}

function anyCookies() {
    return isset($_COOKIE['products']);
}


?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\style.css">
    <script src="js/home.js" defer ></script>
</head>
<body class="">
   
    <?php
    include 'menu.php';
    ?>
   
    <header class="welcome">
        <h2 class="<?php isNotLogin()?>">Witaj w naszym słodkim świecie!</h2>
        <p class="<?php isNotLogin()?>">Czy jesteś gotowy na przygodę pełną słodyczy? Dołącz do naszej słodkiej społeczności i zyskaj dostęp do nieograniczonej ilości cukierkowych radości!</p>
        <a href="register.php" class="<?php isNotLogin()?>"><input type="button" value="utwórz konto" class="btn btn--inverse " ></a>
        <?php welcome()?>
    </header>

    <main>

        <section class="itemslist">
            <div class="grid2">
                <div class="input search" aria-placeholder="szukaj">
                    <input type="text" >
                    
                </div>
                <input type="button" value="" class="filter">
            </div>
            <div class="grid" id="board1">
                <div class="card">
                    <img src="https://unsplash.it/300/300" alt="">
                    <div class="details">
                        <h4 class="title">Serca</h4>
                        <p class="price">21zl</p>
                        <div class="basket"></div>
                    </div>
                </div>
                
                


                
            </div>
        </section>

        <?php
        if(anyCookies()): ?>
        <section class="recent">
            <h2>Ostatnie</h2>
            <div class="grid">

<?php
$ids = "('".implode("','",unserialize($_COOKIE["products"]))."')";

$stmt = $db -> prepare('select idPudelka, NazwaPudelka, Cena,url from pudelka where idPudelka in '.$ids);
$stmt -> execute();
$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
foreach( $result as $p):
?>
      <a href="<?="description.php?product={$p->idPudelka}"?>" style="all:unset">
      <div class="card">
                    <img src="<?=$p-> url?>" alt="">
                    <div class="details">
                        <h4 class="title"><?=$p->NazwaPudelka?></h4>
                        <p class="price"><?=$p->Cena?></p>
                        <div class="basket"></div>
                    </div>
                </div>  
      </a>        
<?php
endforeach;
?>
                

                

            </div>
        </section>
        <?php endif;?>
    </main>
    <?php
    include 'footer.php';
    ?>
    <template id="tp1">
        <div class="card">
            <img src="https://unsplash.it/300/300" alt="" class="img">
            <div class="details">
                <h4 class="title">Serca</h4>
                <p class="price">21zl</p>
                <a href=""><div class="basket"></div></a>
            </div>
    </div>
</template>

<div id="filtr" class="hidden">
    <div class="page">
        <div class="close"><img src="img/cross.svg" alt="" height="30" ></div>
        <h3>Cena</h3>
        <div class="gridfrm">
            <div class="input empty" data-val="Od">
                <input type="text" id="startingPrice">
            </div>
            <div class="input empty" data-val="Do">
                <input type="text" id="endPrice">
            </div>

        </div>
        <h3>Sortuj</h3>
        <select name="" id="order">
            <option value="PriceAsc">Po cenie rosnąco</option>
            <option value="PriceDesc">Po cenie malejąco</option>
            <option value="NameAsc">Po nazwie rozsnąco</option>
            <option value="NameDesc">Po nazwie malejąco</option>
        </select>
    </div>
</div>
</body>
</html>

<?php
$db= null;