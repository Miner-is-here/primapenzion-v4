<?php
require_once "./vendor/autoload.php";
require_once './data.php';

//vychozi id bude domu
// $idStranky = "domu";

//vychozi id bude prvnihodnota v poli
// zjisti vsechny klice daneho pole a rekne mi, ze se pouzije prvni
$idStranky = array_keys($poleStranek)[0];

//zpracujeme formular GET, ktery rozhodne jaky obsah ma vypsat
if (array_key_exists("id-stranky", $_GET)) {
    $idStranky = $_GET["id-stranky"];

    // kontrola zda stranka skutecne exituje
    if (!array_key_exists($idStranky, $poleStranek)) {
        $idStranky = "404";
    }
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $poleStranek[$idStranky]->titulek; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>

<body>

    <header>
        <div class="container">

            <div class="headerTop">
                <a class="odkaz" href="tel:+420606123456">+420 / 606 123 456</a>
                <div class="socIkon">
                    <a href="https://www.facebook.com/" target="_blank">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/" target="_blank">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>

            <a class="logo" href="?id-stranky=domu">Prima<br>penzion</a>

            <?php require "./komponenty/menu.php"; ?>

        </div>

        <img src="img/<?php echo $poleStranek[$idStranky]->obrazek; ?>" alt="PrimaPenzion">
    </header>

    <!-- sem se bude pripojovat obsah stranky 
    < ?php
    require "./$idStranky.html";
    ?>-->

    <!--  -->
    <?php
    // $surovyObsah = file_get_contents("./$idStranky.html");
    $surovyObsah = $poleStranek[$idStranky] -> getObsah();
    $zpracovanyObsah = primakurzy\Shortcode\Processor::process("./moje-shortcody", $surovyObsah);
    echo $zpracovanyObsah;
    ?>

    <footer>
        <div class="pata">

            <?php require "./komponenty/menu.php"; ?>

            <a class="logo" href="?id-stranky=domu">Prima<br>penzion</a>

            <div class="pataInfo">
                <p>
                    <i class="fa-regular fa-map"></i>
                    <a class="odkaz" href="https://maps.app.goo.gl/ThvKYz79XGN2zLP88" target="_blank">
                        <b>PrimaPenzion</b>, Jablonského 2, Praha 7
                    </a>
                </p>
                <p>
                    <i class="fa-solid fa-phone"></i>
                    <a class="odkaz" href="tel:+420606123456">
                        +420 / 606 123 456
                    </a>
                </p>
                <p>
                    <i class="fa-regular fa-envelope"></i>
                    <span>info@primapenzion.cz</span>
                </p>
            </div>

            <div class="socIkon">
                <a href="https://www.facebook.com/" target="_blank">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="https://www.instagram.com/" target="_blank">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.youtube.com/" target="_blank">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>

        </div>

        <div class="copy">
            &copy; <b>Primapenzion</b> 2023
        </div>
    </footer>

</body>

</html>