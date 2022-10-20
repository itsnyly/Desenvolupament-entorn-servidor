<?php 
session_start();

function comprovarParaula(){

    $paraula = $_POST["paraula"];
    $Solucions = get_defined_functions();
    if(in_array($paraula, $Solucions['internal'])){
        if(isset($_SESSION["resultats"])) {
            if (!in_array($paraula, $_SESSION["resultats"])) {
                $_SESSION["resultats"][] = $paraula;
            }
        }
        else{
            $_SESSION["resultats"][] = $paraula;
        }
        $_SESSION["existencia"] = "";   
    }
    else{
        $_SESSION["existencia"] = "La paraula no és una funció de PHP";
    }
    header('Location: index.php');
    die();   
}
function ErrorsParaula($paraula){

}

comprovarParaula();

?>