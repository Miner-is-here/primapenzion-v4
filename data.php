<?php
// pripojime projekt k databazi
$instanceDB = new PDO(
    "mysql:host=127.0.0.1:3306;dbname=penzion;charset=utf8mb4",
    "root",
    "",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);


class Stranka
{
    public $id;
    public $titulek;
    public $menu;
    public $obrazek;
    public $oldId = "";

    function __construct($argId, $argTitulek, $argMenu, $argObrazek)
    {
        $this->id = $argId;
        $this->titulek = $argTitulek;
        $this->menu = $argMenu;
        $this->obrazek = $argObrazek;
    }

    // statucka funkce nepatri instanci, staticka funkce patri classe
    // chceme vytvorit funkci, ktera po zavolani seradi
    // databaze musi aktualizovat
    // musi se proiterovat a rict, ktera polozka ma dostat jake cislo poradi, tj. 0, 1, 2, 3
    static function seraditStranky ($argPoleId) {
        // proiterujeme pole a pro kazdou polozku udelame udpate
        // pouzijeme rozirenou formu foreach, potrebujeme znat i poradi
        foreach ($argPoleId AS $index => $idStranky) {
            $prikaz = $GLOBALS["instanceDB"]->prepare("UPDATE stranka SET poradi=? WHERE id=?");
            $prikaz->execute(array($index, $idStranky));
            // kdyz delame update, nemusime FETCHovat, FETCH delame jenom kdyz SETujeme
        }
    }

    // funkce GET nam vytahne obsah
    function getObsah()
    {
        $prikaz = $GLOBALS["instanceDB"]->prepare("SELECT * FROM stranka WHERE id=?"); //vytazeni pro jeden konkretni obsah stranky, vyhazuje se nam chyba, protoze jsme uvnitr classy... nesmime definovat promenne, kter nejsou uvnitr classy
        // instanceDB je az pod EndStranka
        // pomoci GLOBALS muzu dostat promenne, ktere jsou mimo classu $GLOBALS["instanceDB"]

        $prikaz->execute(array($this->id));
        $vysledek = $prikaz->fetch();

        if ($vysledek == false) {
            $obsah = "";
        } else {
            $obsah = $vysledek["obsah"];
        }

        //$obsah = file_get_contents("./$this->id.html");
        return $obsah;
    }

    /*
        $stranka = $prikaz->fetch();

        // $obsah = file_get_contents("./$this->id.html"); s timhle uz pracovat nechceme
        return $stranka["obsah"];
        // pokud bych dal ale aktualizovat, tak se mi vytvori novy soubor kocka.html, coz nechceme

        lze napsat i takto
        $obsah = $prikaz->fetch()["obsah"];
        return $obsah; */


    // SETTER
    // bez funkce nize, kdyz klikneme na aktualizovat obsah, tak se nic nestane
    // potrebujeme dat jeste funkci setObsah => tu nasledne pouzijeme v admin.php
    function setObsah($argNovyObsah)
    {
        $prikaz = $GLOBALS["instanceDB"]->prepare("UPDATE stranka SET obsah=? WHERE id=?");
        // je to to stejne, kdyz rikame co zapsat a kam zapsat
        $prikaz->execute(array($argNovyObsah, $this->id));

        // file_put_contents("./$this->id.html", $argNovyObsah);
        return; // ani nemusime returnovat
    }


    function ulozdoDB()
    {
        // pokud nejake odlId existuje, tak uz instance existuje, pokud ne, tak chceme tvorit novou stranku
        if ($this->oldId == "") {
            //jeste predtim nez udelame insert, tak musime zjsitit nejvyssi hodnotu poradi
            // bud varianta funkce SELECT ORDER BY a DESC...
            $prikaz = $GLOBALS["instanceDB"]->prepare("SELECT MAX(poradi) AS max_poradi FROM stranka");
            $prikaz->execute();
            $maxPoradi = $prikaz->fetch()["max_poradi"];
            $maxPoradi += 1;

            //vlozime stranku do DB
            $prikaz = $GLOBALS["instanceDB"]->prepare("INSERT INTO stranka SET id=?, titulek=?, menu=?, obrazek=?, poradi=?");
            $prikaz->execute(array($this->id, $this->titulek, $this->menu, $this->obrazek, $maxPoradi));
        } else {
            $prikaz = $GLOBALS["instanceDB"]->prepare("UPDATE stranka SET id=?, titulek=?, menu=?, obrazek=? WHERE id=?");
            // chceme rict, ze neco stareho se nahrazuje novym, v classe ale nemame nadefinovano, takze musime doplnit nove promenne
            $prikaz->execute(array($this->id, $this->titulek, $this->menu, $this->obrazek, $this->oldId));
        }
    }

    function smazSe()
    {
        $prikaz = $GLOBALS["instanceDB"]->prepare("DELETE FROM stranka WHERE id=?");
        $prikaz->execute(array($this->id));
    }
}//endStranka

// vytahneme si vsechny stranky z DB
$prikaz = $instanceDB->prepare("SELECT * FROM stranka ORDER BY poradi");
$prikaz->execute(array());
$poleVysledkuDB = $prikaz->fetchAll(PDO::FETCH_ASSOC);

//z vysledku DB vytvorime pole instanci

// kdyz jsme klikli na kocku, ukazala se chyba, protoze kocka nebyla definovana jako id v poli
/*
$poleStranek = array();
foreach ($poleVysledkuDB AS $stranka) {
    $poleStranek[] = new Stranka($stranka["id"], $stranka["titulek"], $stranka["menu"], $stranka["obrazek"]);
}*/

$poleStranek = array();
foreach ($poleVysledkuDB as $stranka) {
    $poleStranek[$stranka["id"]] = new Stranka($stranka["id"], $stranka["titulek"], $stranka["menu"], $stranka["obrazek"]);
}
// po uprave uz vidime WYSIWYG, ale chyba, protoze kocka neexituje


// PoleStranek chci nove vygenerovat z tabulky
/*
$poleStranek = [
    "domu" => new Stranka(
        "domu",
        "PrimaPenzion",
        "Home",
        "primapenzion-main.jpg"
    ),
    "galerie" => new Stranka(
        "galerie",
        "Fotogalerie",
        "Foto",
        "primapenzion-pool-min.jpg"
    ),
    "kontakt" => new Stranka(
        "kontakt",
        "Kontakty",
        "Napište nám",
        "primapenzion-room.jpg"
    ),
    "rezervace" => new Stranka(
        "rezervace",
        "Rezervace",
        "Chci pokoj",
        "primapenzion-room2.jpg"
    ),
    "404" => new Stranka(
        "404",
        "Stranka neexistuje",
        "", //stranka se propisuje do menu, ale neukazuje se, protoze jsme nedali zadny text, tim padem to vypada, ze je menu souple trochu vlevo
        "primapenzion-room2.jpg"
    )
];*/