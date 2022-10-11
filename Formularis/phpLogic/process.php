<?php 
session_start();

function comprovarParaula(){
    $paraula = $_POST["paraula"];
    $Solucions = get_defined_functions();
    $resultat = false;
    for ($i=0; $i < sizeof($Solucions["internal"]); $i++) {

        if($paraula == $Solucions["internal"][$i]){
            afegirResultatSession($paraula);
        }

    }
    
}

function afegirResultatSession($paraula){
    $variable = "Paraula";
    if(sizeof($_SESSION) > 0){
        for ($i=0; $i < sizeof($_SESSION); $i++) { 
            if (!isset($_SESSION[$variable . strval($i)])) {
                $_SESSION[strval($i)] = $paraula;
            }
            else{
                continue;
            }
        }
    }
    else{
        $_SESSION[$variable . "0"] = $paraula;
        header("Location: http://localhost/desenvolupament-entorn-servidor/formularis/phpLogic/index.php");
    }
    
}
comprovarParaula();



?>