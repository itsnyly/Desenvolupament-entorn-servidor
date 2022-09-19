<?php

$sp = "kfhxivrozziuortghrvxrrkcrozxlwflrh";
$mr = " hv ovxozwozv vj o vfrfjvivfj h vmzvlo e hrxvhlmov oz ozx.vw z xve hv loqvn il hv lmnlg izxvwrhrvml ,hv b lh mv,rhhv mf w zrxvlrh.m";

function decrypt($cadena){
    separarCadena($cadena);
      
}
function separarCadena($cadena){
    //Separa la cadena amb grups de 3
    $arrayCadena = str_split($cadena, 3);
    $arrayGirada = array();
    $i = 0;
    foreach ($arrayCadena as $valor){
        //Gira l'ordre dels caràcters.
        $arrayGirada[$i] = strrev($valor);
        //echo $arrayGirada[$i];
        $i++;  
    }
    canviarValor($arrayGirada);

}
function canviarValor($array){
    $i = 0;
    foreach($array as $valor){
        //echo $valor;
        $valorCanviat = "";
        //Separa els grups de 3 caràcter per caràcter.
        $caracter = str_split($valor, 1);
        $j = 0;
        for ($x = 0; $x < strlen($valor); $x++){
            //echo $caracter[$j] . " " . ctype_alpha($caracter[$j]) . " ";
            //Comprova que el caràcter sigui alfanumèric
            if(ctype_alpha($caracter[$j])){
                //Transforma el caràcter en el seu respectiu numero de la taula ASCII.
                $numeroAscii = ord($caracter[$j]);
                $numeroNou = calculAscii($numeroAscii);
                //echo $numeroNou . " ";
                //Transforma el numero a lletra
                $lletra = chr($numeroNou);
                $valorCanviat .= $lletra;
                $j++;
            }
            else{
                $valorCanviat .= $caracter[$j];
            }
        }
        echo $valorCanviat;
        $i++;
        
    }
 }
 function calculAscii($numero){
    $primerNumero = 97;
    $distancia = 25;
    $numeroFinal = 0;
    if($numero != 97){
        $restaRespectePrimer = $numero - $primerNumero;
        $restaRespecteDistancia = $distancia - $restaRespectePrimer;
        $numeroFinal = $primerNumero + $restaRespecteDistancia;
    }
    else{
        $numeroFinal = 122;
    }
    return $numeroFinal;
 }
decrypt($sp);
echo "\n";
decrypt($mr);

?>
