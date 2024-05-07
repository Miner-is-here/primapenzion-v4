-- Active: 1708938783966@@127.0.0.1@3306@penzion

CREATE DATABASE penzion DEFAULT CHARSET utf8mb4;

SHOW TABLES;

-- vytvorime tabulku dle data.php
-- obrazek je spravne varchar, vkladame text
-- poradi = poradi stranek, aby se nejak stranka nejakym zpusobem zobrazovala
CREATE TABLE stranka (
    id VARCHAR(255) PRIMARY KEY,
    titulek VARCHAR (255),
    menu VARCHAR(255),
    obrazek VARCHAR(255),
    obsah TEXT,
    poradi INT DEFAULT 0
); 

-- vlozime si nejaou testovaci stranka
-- poradi nedavame, mela bz se dat detailne 0
INSERT INTO stranka SET id="kocka", titulek="mnau", menu="cici", obrazek="primapenzion-pool-min.jpg", obsah="mnau mnau mnau";


SELECT * FROM stranka;
