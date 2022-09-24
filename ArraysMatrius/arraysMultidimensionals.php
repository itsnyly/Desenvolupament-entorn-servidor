<?php
/**
 * Crea una matriu amb el mateix nombre de columnes i files.
 * Crea una diagonal amb * i realitza la suma dels index de l'array per determinar el valor de les posicions que es troben a d'alt de la diagonal
 * i per les posicions d'abaix crea un valor random entre 10 i 20.
 * @param numero numero conjunt per les files i les columnes.
 * @return matriu matriu creada.
 */
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

/**
 * Crea una matriu amb el nombre de files i de columnes diferent.
 * @param numFila numero de files.
 * @param numCol numero de columnes.
 * @return matriu matriu creada.
 */
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

/**
 * Mostra la informació d'una matriu amb format de taula html.
 * @param matriu matriu plena.
 * @return taula un string amb la composició d'atributs per mostrar la matriu amb html.
 */
function mostrarArray($matriu){
    if(sizeof($matriu) > 0){
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
    else{
        return false;
    }
}

/**
 * Canvia els valors de les files i de les columnes entre ells.
 * @param matriu matriu plena.
 * @return matriuCanviada matriu amb els valors canviats.
 */
function transposaMatriu($matriu){
    if(sizeof($matriu) > 0){
        for ($fila = 0; $fila < sizeof($matriu); $fila++){
            for($columna = 0; $columna < sizeof($matriu[0]); $columna++){
                    $matriuCanviada[$columna][$fila] = $matriu[$fila][$columna];
            }
        }
        return $matriuCanviada;
    }
    else{
        return false;
    }   
}

$array = creaMatriu(4);
$matriu2B = creaMatriuNoQuadrada(2,8);
$matriuCanviada = transposaMatriu($matriu2B);
$taulaCreada1 = mostrarArray($array);
$taulaCreada2 = mostrarArray($matriu2B);
$taulaCreada3 = mostrarArray($matriuCanviada);

echo "Exercici 2a";
echo $taulaCreada1;
echo "<br>";
echo "Exercici 2b";
echo $taulaCreada2;
echo "<br>";
echo "Exercici 2c";
echo $taulaCreada3;

?>