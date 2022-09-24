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
function creaMatriuNoQuadrada($numFila, $numCol){

    for ($fila = 0; $fila < $numFila; $fila++){
        for($columna = 0; $columna < $numCol; $columna++){
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
    $taula = '<table border = 1 >';
    foreach ( $matriu as $fila ) {
        $taula .= '<tr>';
        foreach ( $fila as $columna ) {
                $taula .= '<td>'.$columna.'</td>';
        }
        $taula .= '</tr>';
}
    $taula .= '</table>';
    return $taula;
}

$array = creaMatriu(4);
$matriu2B = creaMatriuNoQuadrada(2,8);
$taulaCreada = mostrarArray($matriu2B);
echo $taulaCreada;
?>