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
        
    }
    header('Location: index.php');
    die();   
}

comprovarParaula();

?>