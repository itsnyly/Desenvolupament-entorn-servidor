<?php
require_once("models/baseDades/baseDades.php");
require_once("connexions/connexio.php");
require_once("models/gos/gos.php");
require_once("models/fase/fase.php");
require_once("models/vot/vot.php");

session_start();
date_default_timezone_set('UTC');

/**
 * @return date retorna la data del dia actual
 */
function getTodayDate()
{
    return date("Y-m-d");
}


/**
 * Mostra els gossos guanyadors de cada fase
 */
function mostrarResultats()
{
    if (isset($_SESSION["dataActual"])) {
        $fases = Fase::get_fases_by_date($_SESSION["dataActual"]);
        if ($fases) {

            for ($i = 0; $i < sizeof($fases); $i++) {
                echo "<h1> Resultat fase {$fases[$i]["id_fase"]} </h1>";
                $guanyadors = Gos::get_llistat_gossos_guanyadors($fases[$i]["id_fase"]);
                $totalVots = Vot::count_vots_fase($fases[$i]["id_fase"]);
                foreach ($guanyadors as $key => $value) {
                    $percentatgeVots = ($value["numVots"] / $totalVots["Vots"]) * 100;
                    echo "<img class='dog' alt='{$value["nom"]}' title='{$value["nom"]} {$percentatgeVots}%' src='{$value["imatge"]}'>";
                }
            }
        } else {
            echo "No hi ha cap fase activa";
        }
    }
}
/**
 * Busca el gos amb menys vots i l'elimina
 */
function eliminar_gos()
{
    if (isset($_SESSION["dataActual"])) {
        $vot = "";
        $ultimaFase = Fase::get_fase_by_id(8);
        $faseActual = Fase::get_fase_by_date($_SESSION["dataActual"]);
        if ($faseActual && $faseActual["id_fase"] != 1) {
            if ($faseActual["dataFinal"] > $_SESSION["dataActual"]) {
                $vot = new Vot("", $faseActual["id_fase"] - 1, "");
            }
        } else if ($ultimaFase["dataFinal"] < $_SESSION["dataActual"]) {
            $vot = new Vot("", 8, "");
        }
        if ($vot != "") {
            $minNumVot = $vot->min_vots();
            if ($minNumVot != false) {
                $gosTrobat = $vot->trobar_gos_eliminat_by_fase($minNumVot["Vots"]);
                if ($gosTrobat) {
                    if (sizeof($gosTrobat) > 1) {
                        if($vot->fase == 1){
                            $numeroEscollit = rand(0,sizeof($gosTrobat));
                            $gossosGuanyadors = Gos::get_gossos_guanyadors_primeraFase($gosTrobat[$numeroEscollit]["id_gos"]);
                            foreach ($gossosGuanyadors as $key => $value) {
                                $nVots = $vot->vots_by_gos($value["id_gos"]);
                                $gosGuanyador = new Gos($value["id_gos"], $value["nom"], $value["amo"], $value["raça"], $value["imatge"]);
                                $gosGuanyador->insert_gos_guanyador($vot->fase, $nVots["Vots"]);
                            }
                        }
                        else{
                            $menysVots = 100000;
                            foreach ($gosTrobat as $key => $value) {
                                $maxVots = Vot::vots_totals_gos($value["id_gos"]);
                                if($maxVots["Vots"] < $menysVots){
                                    $menysVots = $maxVots["Vots"];
                                }
                            }
                            $gosEliminat = Vot::search_gos_by_max_vots($menysVots);
                            if(sizeof($gosEliminat)>0){
                                $numeroEscollit = rand(0,sizeof($gosEliminat));
                                $gossosGuanyadors = Gos::get_gossos_guanyadors($vot->fase - 1, $gosEliminat[$numeroEscollit]["id_gos"]);
                                foreach ($gossosGuanyadors as $key => $value) {
                                    $nVots = $vot->vots_by_gos($value["id_gos"]);
                                    $gosGuanyador = new Gos($value["id_gos"], $value["nom"], $value["amo"], $value["raça"], $value["imatge"]);
                                    $gosGuanyador->insert_gos_guanyador($vot->fase, $nVots["Vots"]);
                                }
                            }
                            else{
                                $gossosGuanyadors = Gos::get_gossos_guanyadors($vot->fase - 1, $gosEliminat[0]["id_gos"]);
                                foreach ($gossosGuanyadors as $key => $value) {
                                    $nVots = $vot->vots_by_gos($value["id_gos"]);
                                    $gosGuanyador = new Gos($value["id_gos"], $value["nom"], $value["amo"], $value["raça"], $value["imatge"]);
                                    $gosGuanyador->insert_gos_guanyador($vot->fase, $nVots["Vots"]);
                                }

                            }
                            
                        }
                    } else {
                        if ($vot->fase == 1) {
                            $gossosGuanyadors = Gos::get_gossos_guanyadors_primeraFase($gosTrobat[0]["id_gos"]);
                        } else {
                            $gossosGuanyadors = Gos::get_gossos_guanyadors($vot->fase - 1, $gosTrobat[0]["id_gos"]);
                        }
                        foreach ($gossosGuanyadors as $key => $value) {
                            $nVots = $vot->vots_by_gos($value["id_gos"]);
                            $gosGuanyador = new Gos($value["id_gos"], $value["nom"], $value["amo"], $value["raça"], $value["imatge"]);
                            $gosGuanyador->insert_gos_guanyador($vot->fase, $nVots["Vots"]);
                        }
                    }
                }
            }
        }
        
    }
}
eliminar_gos();

?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultat votació popular Concurs Internacional de Gossos d'Atura</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="wrapper large">
        <header>Resultat de la votació popular del Concurs Internacional de Gossos d'Atura 2023</header>
        <div class="results">
            <?php mostrarResultats() ?>
           
        </div>

    </div>

</body>

</html>