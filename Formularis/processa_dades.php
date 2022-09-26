<?php

foreach ($_REQUEST as $clau => $valor){

    echo "Clau: $clau <br/>";
    $es_array = (gettype($valor) == "array");

    if($es_array){
        echo "Valor(s): ";

        foreach($valor as $valorArray){
            echo "$valorArray, ";
        }
    }
    else{
        echo "Valor: $valor "; 
    }

    echo "<br/>";
    echo "<br/>";

   
}

?>