<?php 
session_start();

function comprovarParaula(){
    if(!isset($_SESSION["resultats"])){
        $_SESSION["resultats"];
    }
    $paraula = $_POST["paraula"];
    $Solucions = get_defined_functions();
    if(in_array($paraula, $Solucions['internal'])){
        echo("entra");
        if (!in_array($paraula, $_SESSION["resultats"])) {
            $_SESSION["resultats"][] = $paraula;
        }
    }
    else{
        print_r("no hi és");
    }
    /*header('Location: index.php');
    die(); */  
}

comprovarParaula();

?>