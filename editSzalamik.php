<?php

require_once 'db.php';
require_once 'Szalamik.php';

$adatId = $_GET['id'] ?? null;

if ($adatId === null) {
    header('Location: index.php');
    exit();
}

// SELECT
$adat = Szalamik::getById($adatId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ujMarka = $_POST['marka'] ?? '';
    $ujIz = $_POST['iz'] ?? '';
    $ujHusfajta = $_POST['husfajta'] ?? '';
    $ujKiszereles = $_POST['kiszereles'] ?? 0;
    $ujEltarthatosag = $_POST['eltarthatosag'] ?? 0;
    $ujLaktozmentes = $_POST['laktozmentes'] ?? '';

    $adat -> setMarka($ujMarka);
    $adat -> setIz($ujIz);
    $adat -> setHusfajta($ujHusfajta);
    $adat -> setKiszereles($ujKiszereles);
    $adat -> setEltarthatosag($ujEltarthatosag);
    $adat -> setLaktozmentes($ujLaktozmentes);

    // UPDATE
    $adat -> mentes($adatId);
    header('Location: index.php');
    exit();

}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Szerkesztés</title>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <form method="POST">
            <h1>Szerkeszt</h1>
            <input type="text" name="marka" placeholder="A szalámi márkája:"><br>
            <input type="text" name="iz" placeholder="A szalámi ízesítése:"><br>
            <input type="text" name="husfajta" placeholder="A szalámiban található hús fajtája:"><br>
            <input type="number" name="kiszereles" placeholder="Add meg a kiszerelést grammban:"><br>
            <input type="date" name="eltarthatosag" placeholder="Lejárati idő:"><br>
            <input type="checkbox" name="laktozmentes" placeholder="Laktózmentes"><br>
            <input type="submit" value="Szerkeszt" id="szerkeszt">
        </form>
    </body>
</html>

