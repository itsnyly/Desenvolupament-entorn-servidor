<?php
session_start();

date_default_timezone_set('Europe/Madrid');

/**
 * Comprova que el format de la data sigui el correcte.
 * @param date $data És la data que s'entra per GET.
 * @return bool Retorna si la data entrada té un format correcte.
 */
function comprovarData($data): bool
{
    $formatData = "Ymd";
    $dataFinal =  date_create_from_format($formatData, $data);
    return $data && ($dataFinal->format($formatData) === $data);
}

/**
 * Guarda la data en una sessió.
 */
function guardarData()
{
    if (isset($_GET["data"]) && !empty($_SESSION["Data"])) {
        $dataComprovada = comprovarData($_GET["data"]);
        if ($dataComprovada == true) {
            $_SESSION["Data"] = $_GET["data"];
        }
    } elseif (empty($_SESSION["Data"])) {
        $_SESSION["Data"] = date("Ymd");
    }
}


if (!isset($_SESSION["Data"])) {
    guardarData();
} else {
    $diaAntic = $_SESSION["Data"];
    guardarData();
    if (!isset($_SESSION["resultats"]) || $diaAntic != $_SESSION["Data"]) {
        unset($_SESSION["resultats"]);
    }
}
srand($_SESSION["Data"]);

if (isset($_SESSION["resultats"]) && (isset($_GET["neteja"]))){
    unset($_SESSION["resultats"]);
}
if (!isset($_SESSION["lletres"]) || $diaAntic != $_SESSION["Data"]) {
    $funcions = get_defined_functions();
    escriureLletresHexagon($funcions);
}

/**
 * Genera un lletra de manera aleatòria
 * @return string $lletra Retorna la lletra escollida aleatoriament.
 */
function generarLletra()
{
    $caracters = "abcdefghijklmnopqrstuvwxyz_";
    $index = rand(0, 26);
    $lletra = $caracters[$index];

    return $lletra;
}
/**
 * Genera 7 lletres de manera aleatòria concatenant-les i establint un lletra en la posició del mig.
 * @param string $lletraMig És la lletra que establirem com a central.
 * @return string $cadenaLletres Retorna una cadena amb les 7 lletres.
 */

function generar6Lletres($lletraMig)
{
    $cadenaLletres = "";
    for ($i = 0; $i < 6; $i++) {
        if ($i == 3) {
            $cadenaLletres .= $lletraMig;
        }
        $cadenaLletres .= generarLletra();
    }
    return $cadenaLletres;
}

/**
 * Treu les funcions que no compleixen els nostres requisits.
 * @param array $arrayFuncionsTotal Array que conté totes les funcions de php.
 * @return array $arrayOptimitzat Retorna un nou array amb tots els valors que compleixen els requisits
 */
function treureValorsArray($arrayFuncionsTotal)
{
    $arrayOptimitzat = [];
    foreach ($arrayFuncionsTotal as $key => $value) {
        if (count(array_unique(str_split($value))) <= 7 && preg_match('/^([^0-9]*)$/', ($value))) {
            array_push($arrayOptimitzat, $value);
        }
    }
    sort($arrayOptimitzat);
    return $arrayOptimitzat;
}

/**
 * Comprova que les lletres que es mostraran tinguin la possiblitat de formar 10 noms de funcions.
 * @param array $arrayFuncions Array de funcions php.
 */
function escriureLletresHexagon($arrayFuncions)
{

    $comptador = 0;
    $arrayFuncions = $arrayFuncions["internal"];
    $arrayFuncionsOptimitzades = treureValorsArray($arrayFuncions);
    while ($comptador < 10) {
        $comptador = 0;
        $Solucions = [];
        $lletraMig = generarLletra();
        $opcioLletres = generar6Lletres($lletraMig);
        foreach ($arrayFuncionsOptimitzades as $key => $value) {
            if (preg_match("/^[" . $opcioLletres . "]+$/", ($value)) && preg_match("/" . $lletraMig . "/", ($value))) {
                $comptador++;
                array_push($Solucions, $value);
            }
        }
        if ($comptador >= 9) {
            $_SESSION["lletres"] = str_split($opcioLletres);
            $_SESSION["solucions"] = $Solucions;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <title>PHPògic</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Juga al PHPògic.">
    <link href="//fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body data-joc="2022-10-07">
    <form action="process.php" method="post">
        <div class="main">
            <h1>
                <a href=""><img src="logo.png" height="54" class="logo" alt="PHPlògic"></a>
            </h1>
            <p><?php

                if (isset($_SESSION["solucions"]) && (isset($_GET["sol"]))) {

                    echo "Solucions: " . (implode(",", ($_SESSION["solucions"])));
                }
                ?> </p>
            <div class="container-notifications">
                <?php
                if (isset($_GET['error'])) {

                    $missatgeError = $_GET['error'];

                    switch ($missatgeError) {
                        case "jahies":
                            echo '<p class="hide" id="message">' . $_GET["paraula"] . '</p>';
                            break;
                        case "Noesunafuncio":
                            echo '<p class="hide" id="message">La paraula no és una funció de PHP.</p>';
                            break;
                        case "faltalalletradelmig":
                            echo '<p class="hide" id="message">Falta la lletra del mig.</p>';
                            break;
                    }
                }
                ?>
            </div>
            <div class="cursor-container">
                <p id="input-word"><span id="test-word"></span><span id="cursor">|</span></p>
                <input type="hidden" name="paraula" id="campText">
            </div>
            <div class="container-hexgrid">
                <?php
                echo ("<ul id='hex-grid'>");
                foreach ($_SESSION["lletres"] as $key => $value) {
                    echo ("<li class='hex'>");
                    if ($key == 3) {
                        echo ("<div class='hex-in'><a class='hex-link' data-lletra=" . $value . " draggable='false' id='center-letter'><p>" . $value . "</p></a></div>");
                    } else {
                        echo ("<div class='hex-in'><a class='hex-link' data-lletra=" . $value . " draggable='false'><p>" . $value . "</p></a></div>
            </li>");
                    }
                }
                echo "</ul>";
                ?>
            </div>
            <div class="button-container">
                <button id="delete-button" type="button" title="Suprimeix l'última lletra" onclick="suprimeix()"> Suprimeix</button>
                <button id="shuffle-button" type="button" class="icon" aria-label="Barreja les lletres" title="Barreja les lletres">
                    <svg width="16" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"></path>
                    </svg>
                </button>
                <button id="submit-button" type="submit" title="Introdueix la paraula">Introdueix</button>
            </div>
            <div class="scoreboard">
                <div>Has trobat <?php print_r(mostrarResultats()) ?> <span id="found-suffix"><?php if(mostrarResultats() == 1){echo " funció";}else{echo " funcions";}?></span> <strong><?php print_r(mostrarNomsFuncions()) ?></strong><span id="discovered-text">.</span>
                </div>
                <div id="score"></div>
                <div id="level"></div>
            </div>
        </div>
    </form>
    <script>
        function amagaError() {
            if (document.getElementById("message"))
                document.getElementById("message").style.opacity = "0"
        }

        function afegeixLletra(lletra) {
            document.getElementById("test-word").innerHTML += lletra;
            document.getElementById("campText").value += lletra;
        }

        function suprimeix() {
            document.getElementById("test-word").innerHTML = document.getElementById("test-word").innerHTML.slice(0, -1);
            document.getElementById("campText").value = document.getElementById("campText").value.slice(0, -1)
        }
        window.onload = () => {
            // Afegeix funcionalitat al click de les lletres
            Array.from(document.getElementsByClassName("hex-link")).forEach((el) => {
                el.onclick = () => {
                    afegeixLletra(el.getAttribute("data-lletra"))
                }
            })
            setTimeout(amagaError, 2000)
            //Anima el cursor
            let estat_cursor = true;
            setInterval(() => {
                document.getElementById("cursor").style.opacity = estat_cursor ? "1" : "0"
                estat_cursor = !estat_cursor
            }, 500)
        }
    </script>

    <?php
    /**
     * Mostra el nombre de paraules encertades.
     */
    function mostrarResultats()
    {
        if (isset($_SESSION["resultats"])) {
            return sizeof($_SESSION["resultats"]);
        } else {
            return 0;
        }
    }
   
    /**
     * Mostra les paraules encertades
     */
    function mostrarNomsFuncions()
    {
        if (isset($_SESSION["resultats"])) {
            return implode(" ", $_SESSION["resultats"]);
        }
    }

    ?>
</body>

</html>