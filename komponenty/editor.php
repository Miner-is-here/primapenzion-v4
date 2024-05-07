<h2>Editor stranky <?php echo $aktualniInstance->id; ?></h2> <!-- php ostruvek, ktery vypisuje, co edituju, tj. domu, rezervace atd. -->
<form action="" method="post">
    <!-- krome obsahu stranky jsme pridali i dalsi policka, id stranky, titulek stranky, menu stranky, obrazek -->
<label for="">Id stranky</label>
    <input type="text" name="id-stranky" id="" value="<?php echo $aktualniInstance->id; ?>">
    <br>
    <label for="">Titulek stranky</label>
    <input type="text" name="titulek-stranky" id="" value="<?php echo $aktualniInstance->titulek; ?>">
    <br>
    <label for="">Menu stranky</label>
    <input type="text" name="menu-stranky" id="" value="<?php echo $aktualniInstance->menu; ?>">
    <br>
    <label for="">Obrazek</label>
    <input type="text" name="obrazek-stranky" id="" value="<?php echo $aktualniInstance->obrazek; ?>">
    <br>
    <label for="">Obsah stranky</label>
    <br>
    <textarea name="obsah-stranky" id="obsah" cols="30" rows="30"><?php //do text area chceme vlozit obsah stranky; spatne se vypisuje ale kontakt nebo rezervace, vlozi se nam tlacitko odeslat. Nase stranka nevi, kde konci textarea ... abychom teto situaci zabranili, tak musime echo echo $aktualniInstance->getObsah() zrusit o html pomoci htmlspecialchars
                                                                echo htmlspecialchars($aktualniInstance->getObsah());
                                                                ?></textarea>
    <br>
    <input type="submit" name="aktualizovat-submit" value="Aktualizovat obsah">
</form>

<!-- timhle jsme pripojili knihovnu -->
<script src="./vendor/tinymce/tinymce/tinymce.js"></script>

<!-- timhle jsme aktivovali knihovnu -->
<script>
    tinymce.init({
        selector: "#obsah",
        content_css: ["./css/style.css", "./css/all.min.css"],
        // diakritika, bez pluginu nize se nam prevadi text s &
        //  <h2>Inspirov&aacute;no kr&aacute;sn&yacute;mi věcmi.</h2>
        entity_encoding: "raw",
        //ikonky napr. platebnich karet, kdyby nize nebylo, tak mi to nezobrazi ikonky, mysli si totiz, ze to je nejaka chyba
        verify_html: false,
        plugins: ["code", "responsivefilemanager", "image", "anchor", "autolink", "autoresize", "link", "media", "lists"],
        //1 a 2 uvadi toolbaru, ktere chceme videt
        toolbar1: 'formatselect | bold italic strikethrough | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
        toolbar2: "| responsivefilemanager | link | image media | forecolor backcolor  | print preview code ",
        // funkce dirname nam zjisti, kde aktualne lezi editor php
        // to najdu, kdyz si otevru admin.php zdrojovy kod
        // 'responsivefilemanager': '/programator-unor/primapenzion-v2/vendor/primakurzy/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
        external_plugins: {
			'responsivefilemanager': '<?php echo dirname($_SERVER['PHP_SELF']); ?>/vendor/primakurzy/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
		},
		external_filemanager_path: "<?php echo dirname($_SERVER['PHP_SELF']); ?>/vendor/primakurzy/responsivefilemanager/filemanager/",
		filemanager_title: "File manager", 
        // nainstalovali jsme si knihovny od Pepy, ktera nam dovoli vkladat soubory, obrazky, textaky atd.
    });
</script>

<!-- editor jeste vylepsime, vzali jsme z text area, ta nema zadne css -->
<!-- toto muzeme udelat pres javascript -->
