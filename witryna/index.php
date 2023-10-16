<?php
session_start();
include_once 'Query.php';

function welcome() {
    if(isSet($_SESSION["NumerKlienta"])): ?>
    <h2 data-aos="fade-up">Cześć <?=$_SESSION["imie"]?></h2>
    <?php endif;
}

function anyCookies() {
    return isset($_COOKIE['products']);
}

function renderCard($p) { ?>
    <a href="<?="description.php?product={$p->idPudelka}"?>" style="all:unset">
    <div class="card">
                  <img src="<?=$p-> url?>" alt="">
                  <div class="details">
                      <h4 class="title"><?=$p->NazwaPudelka?></h4>
                      <p class="price"><?=$p->Cena?> zł</p>
                      <div class="basket"></div>
                  </div>
              </div>  
    </a>        
<?php
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="js/home.js" defer ></script>
</head>
<body class="">
   
    <?php
    include 'menu.php';
    ?>
   
    <header class="welcome">
        <h2 class="<?php isNotLogin()?> " data-aos="fade-up" data-aos-anchor-placement="center-center">Witaj w naszym słodkim świecie!</h2>
        <p class="<?php isNotLogin()?>" data-aos="fade-up" data-aos-delay="100">Czy jesteś gotowy na przygodę pełną słodyczy? Dołącz do naszej słodkiej społeczności i zyskaj dostęp do nieograniczonej ilości cukierkowych radości!</p>
        <a href="register.php" class="<?php isNotLogin()?>" data-aos="fade-up" data-aos-duration="200"><input type="button" value="utwórz konto" class="btn btn--inverse " ></a>
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

            <div class="grid" id="board1" data-aos="fade-up" data-aos-delay="50">
                <div class="card">
                    <img src="https://unsplash.it/300/300" alt="">
                    <div class="details">
                        <h4 class="title"></h4>
                        <p class="price"></p>
                        <div class="basket"></div>
                    </div>
                </div>

            </div>
        </section>

        <?php if(anyCookies()): ?>
        <section class="recent">
            <h2 data-aos="zoom-in">Ostatnie</h2>
            <div class="grid"  data-aos="fade-up" data-aos-delay="50">
                <?php
                $p = new Pudelko($db);
                $result = $p->getBoxes($_COOKIE["products"]);
                foreach( $result as $p):
                    renderCard($p);
                endforeach;
                ?>
            </div>
        </section>
        <?php endif;?>
    </main>
    <?php include 'footer.php'; ?>
    <template id="tp1">
        <div class="card">
            <img src="https://unsplash.it/300/300" alt="" class="img">
            <div class="details">
                <h4 class="title"></h4>
                <p class="price"></p>
                <a href=""><div class="basket"></div></a>
            </div>
    </div>
</template>

<div id="filtr" class="hidden" data-aos="fade-up">
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
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
</body>
</html>

<?php
$db= null;