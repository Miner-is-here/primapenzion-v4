// propojeni js a admin.php souboru

console.log("pripojeno");

//chceme vypnout vsechny mazaci odkazy - abychom zabranili smazani omylem
const poleMazacichOdkazu = document.querySelectorAll(".mazaci-odkaz");
console.log(poleMazacichOdkazu);

for (const odkaz of poleMazacichOdkazu) {
    odkaz.addEventListener("click", (udalost) => {
        // vypneme
        udalost.preventDefault();
        // chceme se zeptat, jestli chce opravdu smazat
        // confirm vraci boolean

        const odpoved = confirm("Opravdu chcete stranku smazat?")

        if (odpoved == true) {
            // nemusi se pouzit current target, muze se rovnou pouzit odkaz
            // udalost.currentTarget.getAttribute("href")
            const cilOdkazu = odkaz.getAttribute("href");
            // console.log(cilOdkazu); // po odklidknut bz se melo propsat v Console ?delete=afdas

            // odkazani uzivatele 
            // bez prikau nize se smazani neprovede
            window.location.href = cilOdkazu;
        }
    });
}

// chceme dat moznost stranky radit pomoci JS, hodnoty muze mysi vzit a presunout nahoru nebo dolu
// prohazuje se v prohlizeci pomoci JS
// pokazde, kdyz to prohodi u sebe, tak musime dat servru vedet, ze se to ma zmenit i v serveru, tj. da serveru vedet, ze uzivatel hnul s nejakou polozkou
// server nasledne posle prikaz do databaze, aby se poradi zmenilo
// zacneme razenim u uzivatele

// razeni stranek
// potrebujeme mit knihovnu jquery a knihovnu jquery-ui (rozsireni jquery napr. o razeni)- musime si byt jisti, ze jsme ve spravne slozce
// npm install jquery
// npm install jqueryui
// v node_modules mame dve slozky
// po stazeni prijpojime v admin.php - musi byt ve sprvnem poradi

// zamerime ul seznam (do admin.php jsme si vlozili class seznam-stranek)a dame funkci, ktera radi
// sortable vnima objekt, vlozime do funkce {}
$("#seznam-stranek").sortable({
    update: () => {
        // console.log("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"); - pri kazdem posunu se nam ukaze v console aaaaaaa, my chceme, aby se pri kazdem posunu poslalo do databaze

        //toto je funkce, ktera se spusti pri jakekoliv zmene poradi v seznamu

        //budeme zde posilat ajax formular do serveru
        // abychom meli ajaxu zo poslat, tak nejdrive musime zjistit poradi stranek
        //sortable("toArray") koukne na <li> v seznamu a vrati pole jejich id atributu
        const poleIdStranek = $("#seznam-stranek").sortable("toArray");
        console.log(poleIdStranek); // dostaneme pole prazdnych stringu, proto potrebujeme v admin.php kazdemu stringu dodat id =>  // po pridani id='$stranka->id' v admin.php se nam bude vypisovat v console poradi v poli

        //kdyz uz zname poradi stranek, tak muzeme poslat ajax formular
        // vyplnime kam se formular ma poslat, jaka data, jakeho datoveho typy atd.
        $.ajax({
            url: "./admin.php", //kam se ma poslat
            method: "post", // jakou metodou se ma poslat
            dataType: "text", // v jakem formatu nam server odpovi
            data: {
                seraditSubmit: true,
                poleId: poleIdStranek
            },
            success: (odpovedServeru) => {

                console.log(odpovedServeru);
            }
        });
    }
});
// po refreshi muzeme presouvat, pokud znovu udelame refresh, tak se vrati zpet - databaze nevi, ze delame upravy

// jak kontaktovat ajax
