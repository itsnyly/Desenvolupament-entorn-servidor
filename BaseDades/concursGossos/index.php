<?php
require_once("models/baseDades/baseDades.php");
require_once("connexions/connexio.php");
require_once("models/gos/gos.php");
require_once("models/fase/fase.php");
require_once("models/vot/vot.php");

session_start();


date_default_timezone_set('UTC');

if (isset($_GET["data"])) {

    $_SESSION["dataActual"] = $_GET["data"];
} else {
    $_SESSION["dataActual"] = get_today_date();
}


/**
 * @return date data del dia actual
 */
function get_today_date()
{
    return date("Y-m-d");
}
/**
 * @return string comprova si l'usuari ja ha votat a la fase actual
 */
function comprovar_votacio()
{
    if (isset($_SESSION["votacioRealitzada"])) {
        if ($_SESSION["votacioRealitzada"] == session_id()) {
            $votacio = new Vot(session_id(), numero_fase(), "");
            $infoVotacio = $votacio->get_info_vot();
            if ($infoVotacio != false) {
                return "Ja has realitzat el teu vot, però el pots modificar abans no s'acabi la fase";
            } else {
                return "";
            }
        } else {
            return "";
        }
    } else {
        return "";
    }
}
/**
 * Mostra el llistat de gossos disponibles per votar
 */
function mostrar_gossos()
{
    $fase = numero_fase();
    if ($fase) {
        if ($fase == 1) {
            $gossos = Gos::get_all_gossos();
        } else {
            $gossos = Gos::get_llistat_gossos_guanyadors($fase - 1);
        }

        if ($gossos) {
            $sumaIndex = 0;
            for ($i = 0; $i < sizeof($gossos); $i++) {
                $sumaIndex = $i + 1;
                echo "<input type='checkbox' name='poll' id='opt-{$sumaIndex}' value='{$gossos[$i]['id_gos']}' onClick='submit()'>";
            }
            for ($i = 0; $i < sizeof($gossos); $i++) {
                $sumaIndex = $i + 1;
                echo "<label for= 'opt-{$sumaIndex}' class= 'opt-{$sumaIndex}'>";
                echo "<div class='row'>";
                echo "<div class='column'>";
                echo "<div class='right'>";
                echo "<span class='circle'></span>";
                echo "<span class='text'>{$gossos[$i]['nom']}</span>";
                echo "</div>";
                echo "<img class='dog'  alt='{$gossos[$i]['nom']}' src='{$gossos[$i]['imatge']}'>";
                echo "</div>";
                echo "</div>";
                echo "</label>";
            }
        } else {
            echo "No hi ha gossos disponibles";
        }
    } else {
        echo "La data no pertany a una fase";
    }
}
/**
 * @return int el número de fase en el que estem
 */
function numero_fase()
{
    $fase = Fase::get_fase_by_date($_SESSION["dataActual"]);
    $dataUltimaFase = Fase::get_fase_by_id(8);
    if ($fase) {
        return $fase["id_fase"];
    } else if ($_SESSION["dataActual"] > $dataUltimaFase["dataFinal"]) {
        return 8;
    } else {
        return false;
    }
}
/**
 * @return date data final de la fase actual
 */
function data_fase()
{
    $fase = Fase::get_fase_by_date($_SESSION["dataActual"]);
    if ($fase) {
        return $fase["dataFinal"];
    } else {
        return "Fase no existent";
    }
}


?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votació popular Concurs Internacional de Gossos d'Atura 2023</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="wrapper">
        <header>Votació popular del Concurs Internacional de Gossos d'Atura 2023- FASE <span> <?php echo numero_fase() ?> </span></header>
        <p class="info"> Podeu votar fins el dia <?php echo data_fase() ?></p>

        <p class="warning"> <?php echo comprovar_votacio() ?></p>
        <div class="poll-area">
            <form action="./controlador/process.php" method="post" id="form">
                <?php mostrar_gossos() ?>
            </form>
            <script>
                function submit() {
                    let form = document.getElementById("form");
                    form.submit();
                    alert("Vot realitzat");
                }
            </script>
        </div>
        <p> Mostra els <a href="resultats.php">resultats</a> de les fases anteriors.</p>
    </div>

</body>

</html>