<?php

function creaMatriu($numero){

    for ($fila = 0; $fila < $numero; $fila++){
        for($columna = 0; $columna < $numero; $columna++){
            if($fila == $columna){
                $matriu[$fila][$columna] = "*";
            }
            else if($fila < $columna){
                $matriu[$fila][$columna] = $fila + $columna;
            }
            else{
                $matriu[$fila][$columna] = rand(10,20);
            }
        }
    }

    return $matriu;
}
function mostrarArray($matriu){

    for($fila = 0; $fila < sizeof($matriu); $fila++){
        
        for($columna=0; $columna < sizeof($matriu); $columna++){
            print_r($matriu[$fila][$columna]) ;
        }
    }

}

$array = creaMatriu(4);
mostrarArray($array);
?>