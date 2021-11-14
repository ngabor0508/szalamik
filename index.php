<?php

require_once 'db.php';
require_once 'Szalamik.php';

$markaHiba = false;
$izHiba = false;
$husfajtaHiba = false;
$kiszerelesHiba = false;
$eltarthatosagHiba = false;
$laktozmentesHiba = false;
$hibaUzenet = "";
$kiszerelesHibaUzenet = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $deleteId = $_POST['deleteId'] ?? '';
    if ($deleteId !== '') {
        Szalamik::torol($deleteId);
    } 
    
    if($_POST['marka'] == ""){
        $markaHiba = true;
        $hibaUzenet = "Kérjük töltsd ki az összes mezőt!";
    }

    else if($_POST['iz'] == ""){
        $izHiba = true;
        $hibaUzenet = "Kérjük töltsd ki az összes mezőt!";
    }

    else if($_POST['husfajta'] == ""){
        $husfajtaHiba = true;
        $hibaUzenet = "Kérjük töltsd ki az összes mezőt!";
    }

    else if($_POST['kiszereles'] == 0){
        $kiszerelesHiba = true;
        $kiszerelesHibaUzenet = "A kiszerelés nem lehet 0, kérem írjon be egy valós adatot!";
    }

    else if($_POST['eltarthatosag'] == ""){
        $eltarthatosagHiba = true;
        $hibaUzenet = "Kérem adjon meg érvényes lejárati időt!";
    }

    else if($_POST['laktozmentes'] == ""){
        $laktozmentesHiba = true;
        $hibaUzenet = "Kérem töltsd ki az összes mezőt!";
    }

    
    else {
        $markaHiba = false;
        $izHiba = false;
        $husfajtaHiba = false;
        $kiszerelesHiba = false;
        $eltarthatosagHiba = false;

        $ujMarka = $_POST['marka'];
        $ujIz = $_POST['iz'];
        $ujHusfajta = $_POST['husfajta'];
        $ujKiszereles = $_POST['kiszereles'];
        $ujEltarthatosag = $_POST['eltarthatosag'];
        $ujLaktozmentes = $_POST['laktozmentes'];
        
        $ujSzalamik = new Szalamik($ujMarka, $ujIz, $ujHusfajta, $ujKiszereles, new DateTime($ujEltarthatosag), $ujLaktozmentes);
        $ujSzalamik -> uj();
    }
}


$szalamik = Szalamik::osszes();


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Szalámik</title>
        <link rel="stylesheet" href="main.css">
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    <body>
        <img src="https://www.mindmegette.hu/images/112/O/124283_szalami05.jpg" alt="szalami" id="szalamikep">
        <form method="POST">
            <div>
                <h1 id="header">Szalámik</h1>     
                <input type="text" name="marka" placeholder="A szalámi márkája:" value="<?php if(isset($_POST['marka'])) echo $_POST['marka'];?>"><br>
                <input type="text" name="iz" placeholder="A szalámi ízesítése:" value="<?php if(isset($_POST['iz'])) echo $_POST['iz'];?>"><br>
                <input type="text" name="husfajta" placeholder="A szalámiban található hús fajtája:" value="<?php if(isset($_POST['husfajta'])) echo $_POST['husfajta'];?>"><br>
                <input type="number" name="kiszereles" placeholder="Add meg a kiszerelést grammban:"><br>
                <input type="date" name="eltarthatosag" placeholder="Lejárati idő:" value="<?php if(isset($_POST['eltarthatosag'])) echo $_POST['eltarthatosag'];?>"><br>
                <input type="text" name="laktozmentes" placeholder="Laktózmentes(igen/nem)" value="<?php if(isset($_POST['laktozmentes'])) echo $_POST['laktozmentes'];?>"><br>
                
            </div>
            <div>
                <input type="submit" value="Új Szalámi!" id="ujSzalami">
            </div>
        </form>

        <div class="hibauzenet"><?php echo $hibaUzenet ?></div>
        <div class="hibauzenet"><?php echo $kiszerelesHibaUzenet ?></div>


        <?php
        
            foreach ($szalamik as $szalami) {

                echo "<article>";
                echo "<h3 id='header'>Szalámi adatok: </h3>";
                echo "<p>" . "Márkája: " . $szalami -> getMarka() . "</p>";
                echo "<p>" . "Ízesítése: " . $szalami -> getIz() . "</p>";
                echo "<p>" . "Hús fajtája: " . $szalami -> getHusfajta() . "</p>";
                echo "<p>" . "Kiszerelés: " . $szalami -> getKiszereles() . " g" . "</p>";
                echo "<p>" . "Szavatosság: " . $szalami -> getEltarthatosag() -> format('Y-m-d') . "</p>";
                if ($szalami->getLaktozmentes() == "igen"){
                    echo "<p>" . "Laktózmentes" . "</p>";
                }
                else if($szalami->getLaktozmentes() == "nem"){
                    echo "<p>" . "Nem laktózmentes" . "</p>";
                }
                else {
                    echo "<p>Hibás adatot adtál meg!</p>";
                }

                echo "<form method='POST'>";
                echo "<input type='hidden' name='deleteId' value='" . $szalami -> getId() . "'>";
                echo "<button type='submit' id='torles'>Törlés</button>";
                echo "</form>";
                echo "<a href='editSzalamik.php?id=" . $szalami -> getId() . "'>Szerkeszt</a>";
                echo "</article>";
            }
        ?>
    </body>
</html>