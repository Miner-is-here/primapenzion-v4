<!-- potrebujeme rict, prosmejdi nam slozku a najdi, co tam je - to delame pres scandir -->
<?php
$slozka = "./upload/source/fotogalerie/";

$poleNazvu = scandir($slozka);


// var_dump($slozka);

foreach ($poleNazvu AS $nazev) {
    if ($nazev == "." || $nazev == "..") {
        continue;
    }

    echo "<a href='#'><img src='{$slozka}{$nazev}' alt=''></a>";

}

?>