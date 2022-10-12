<?php 
session_start();

function comprovarParaula(){
    $paraula = $_POST["paraula"];
    $Solucions = get_defined_functions();
    $trobat = false;
    for ($i=0; $i < sizeof($Solucions["internal"]); $i++) {
        if($paraula == $Solucions["internal"][$i]){
            if(isset($_SESSION["resultats"])){
                for ($i=0; $i < sizeof($_SESSION["resultats"]); $i++) { 
                    if($paraula == $_SESSION["resultats"][$i]){
                        $trobat = true;
                    }
                }
                if($trobat == false){
                    $_SESSION["resultats"][] = $paraula;
                }
            }
            else{
                $_SESSION["resultats"][] = $paraula;
            }
            
            header('Location: index.php');
        }
    }
}

comprovarParaula();



?>