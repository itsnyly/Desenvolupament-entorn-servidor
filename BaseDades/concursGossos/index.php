<?php
require_once("models/baseDades/baseDades.php");
require_once("connexions/connexio.php");
require_once("models/gos/gos.php");
require_once("models/fase/fase.php");


date_default_timezone_set('UTC');

function getTodayDate(){
    return date("Y-m-d");
}

function mostrar_gossos()
{
    $gossos = Gos::get_all_gossos();
    if($gossos){
        $sumaIndex = 0;
        for ($i = 0; $i < sizeof($gossos); $i++) {
            $sumaIndex = $i + 1;
            echo "<input type='checkbox' name='poll' id='opt-{$sumaIndex}' value='{$gossos[$i]['id_gos']}'>";
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
    }
    else{
        echo "Error base de dades";
    }
   
}

function numeroFase(){
    $fase = Fase::get_fase_by_date(getTodayDate());
    if($fase){
        return $fase["id_fase"];
    }
    else{
        return "Fase no existent";
    }
}

function dataFase(){
    $fase = Fase::get_fase_by_date(getTodayDate());
    if($fase){
        return $fase["dataFinal"];
    }
    else{
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
        <header>Votació popular del Concurs Internacional de Gossos d'Atura 2023- FASE <span> <?php echo numeroFase()?> </span></header>
        <p class="info"> Podeu votar fins el dia <?php echo dataFase()?></p>

        <p class="warning"> </p>
        <div class="poll-area">
            <form action="./controlador/process.php" method="post" id="form">
                <?php mostrar_gossos() ?>
                <input type="submit" value="Vota">
            </form>
        </div>
        <p> Mostra els <a href="resultats.php">resultats</a> de les fases anteriors.</p>
    </div>

</body>

</html>