<?php

function comprovarParaula(){
    $paraula = $_POST["paraula"];
    $Solucions = get_defined_functions();
    $resultat = false;
        foreach($Solucions as $valor){
            if($paraula == $valor){
                $resultat = true;
                print_r($resultat);
            }
            else{
                print_r(implode($valor));
            }
        }
    
}
comprovarParaula();

?>