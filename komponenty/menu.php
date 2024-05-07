<!--  PUVODNI VERZE
<nav>
    <ul>
        <li><a href="?id-stranky=domu">Domu</a></li>  === oproti puvodni verzi jsme upravili odkazy na html... misto toho jsme dali otaznik, co se ma meni za URL
        <li><a href="?id-stranky=kontakt">Kontakt</a></li>
        <li><a href="?id-stranky=galerie">Galerie</a></li>
        <li><a href="?id-stranky=rezervace">Rezervace</a></li>
    </ul>
</nav>
-->

<!-- chceme ale proiterovat -->

<nav>
    <ul>
        <?php
        foreach ($poleStranek as $stranka) {
            if ($stranka->menu == "") {
                continue;
            }
            echo "<li>
            <a href='?id-stranky={$stranka->id}'>{$stranka->menu}</a>
            </li>";
        }
        ?>
    </ul>
</nav>