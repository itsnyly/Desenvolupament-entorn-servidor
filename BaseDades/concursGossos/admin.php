<?php
require_once("models/baseDades/baseDades.php");
require_once("connexions/connexio.php");
require_once("models/gos/gos.php");
require_once("models/fase/fase.php");
session_start();

if(!isset($_SESSION["acces"]))
{
    header("Location: login.php?error=faltaLogin", true, 303);
    exit();
}

/**
 * Mostra els gossos que participen al concurs
 */
function mostrar_concursants(){
    $gossos = Gos::get_all_gossos();
    if($gossos){
        for ($i = 0; $i < sizeof($gossos); $i++) {
            echo "<form action='./controlador/adminProcess.php' method='post'>";
            echo "<input type='hidden' name='method' value='modificarGos'/>";
            echo "<input type='hidden' name='id' value='{$gossos[$i]['id_gos']}'/>";
            echo "<input name='nom' type='text' placeholder='Nom' value='{$gossos[$i]['nom']}'>";
            echo "<input name='imatge' type='text' placeholder='Imatge' value='{$gossos[$i]['imatge']}'>";
            echo "<input name='amo' type='text' placeholder='Amo' value='{$gossos[$i]['amo']}'>";
            echo "<input name='raça' type='text' placeholder='Raça' value='{$gossos[$i]['raça']}'>";
            echo "<input type='submit' value='Modifica'>";
            echo "</form>";
            echo "<br>";
        }
    }
    else{
        echo "Error base de dades";
    }
    
}
/**
 * Mostra les fases del concurs
 */
function mostrar_fases(){
    $fases = Fase::get_all_fases();
    if($fases){
        for ($i = 0; $i < sizeof($fases); $i++) {
            echo "<form action='./controlador/adminProcess.php' method='post' class='fase-row'>";
            echo "<input type='hidden' name='method' value='modificarFase'/>";
            echo "<input type='hidden' name='idFase' value='{$fases[$i]['id_fase']}'>";
            echo "Fase <input type='text' name='id' value='{$fases[$i]['id_fase']}' disabled style='width: 3em'>";
            echo "del <input type='date' name='dataInici' placeholder='Inici' value='{$fases[$i]['dataInici']}'>";
            echo "al <input type='date' name='dataFinal' placeholder='Fi' value='{$fases[$i]['dataFinal']}'>";
            echo "<input type='submit' value='Modifica'>";
            echo "</form>";
        }
    }
    else{
        echo "Error base de dades";
    }
    
}



?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - Concurs Internacional de Gossos d'Atura</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="wrapper medium">
        <header>ADMINISTRADOR - Concurs Internacional de Gossos d'Atura</header>
        <div class="admin">
            <div class="admin-row">
                <h1> Resultat parcial: Fase 1 </h1>
                <div class="gossos">
                    <img class="dog" alt="Musclo" title="Musclo 15%" src="img/g1.png">
                    <img class="dog" alt="Jingo" title="Jingo 45%" src="img/g2.png">
                    <img class="dog" alt="Xuia" title="Xuia 4%" src="img/g3.png">
                    <img class="dog" alt="Bruc" title="Bruc 3%" src="img/g4.png">
                    <img class="dog" alt="Mango" title="Mango 13%" src="img/g5.png">
                    <img class="dog" alt="Fluski" title="Fluski 12 %" src="img/g6.png">
                    <img class="dog" alt="Fonoll" title="Fonoll 5%" src="img/g7.png">
                    <img class="dog" alt="Swing" title="Swing 2%" src="img/g8.png">
                    <img class="dog eliminat" alt="Coloma" title="Coloma 1%" src="img/g9.png">
                </div>
            </div>
            <div class="admin-row">
                <h1> Nou usuari: </h1>
                <form action="./controlador/adminProcess.php" method="post">
                    <input type="hidden" name="method" value="nouUsuari" />
                    <input type="text" name="nomUsuari" placeholder="Nom">
                    <input type="password" name="passwordUsuari" placeholder="Contrassenya">
                    <input type="submit" value="Crea usuari">
                </form>
            </div>
            <div class="admin-row">
                <h1> Fases: </h1>
                <?php mostrar_fases() ?>
            </div>

            <div class="admin-row">
                <h1> Concursants: </h1>
                <?php mostrar_concursants() ?>

                <form action="./controlador/adminProcess.php" method="post">
                    <input type="hidden" name="method" value="nouGos" />
                    <input name="nom" type="text" placeholder="Nom">
                    <input name="img" type="text" placeholder="Imatge">
                    <input name="amo" type="text" placeholder="Amo">
                    <input name="raça" type="text" placeholder="Raça">
                    <input type="submit" value="Afegeix">
                </form>
            </div>

            <div class="admin-row">
                <h1> Altres operacions: </h1>
                <form action="./controlador/adminProcess.php" method="post">
                    Esborra els vots de la fase
                    <input type="hidden" name="method" value="esborrarVotsFase" />
                    <input name="fase" type="number" placeholder="Fase">
                    <input type="submit" value="Esborra">
                </form>
                <form action="./controlador/adminProcess.php" method="post">
                    Esborra tots els vots
                    <input type="hidden" name="method" value="esborrarVots" />
                    <input type="submit" value="Esborra">
                </form>
            </div>
        </div>
    </div>

</body>

</html>