<?php

$sp = "kfhxivrozziuortghrvxrrkcrozxlwflrh";
$mr = " hv ovxozwozv vj o vfrfjvivfj h vmzvlo e hrxvhlmov oz ozx.vw z xve hv loqvn il hv lmnlg izxvwrhrvml ,hv b lh mv,rhhv mf w zrxvlrh.m";


function comprovarString($string)
{
    return ($string === strtolower($string));
}


function convertirString($frase)
{
    
    for ($i = 0; $i < strlen($frase); $i++)
    {
        $ch = $frase[$i];

        if(!ctype_alpha($ch)){
            echo ($ch);
        }
        else if (comprovarString($ch)){
            $ch = chr(122 - ord($ch) + 97);
            echo ($ch);
        }
        
    }
}

function decrypt($cadena){
    $grup = str_split($cadena, 3);

    foreach ($grup as $valor) {
        $grupCanviat = strrev($valor) ;
        convertirString($grupCanviat);
      }
  
}


decrypt($sp);
echo "\n";
decrypt($mr);


/*function separarCadena($cadena){
    //Separa la cadena amb grups de 3
    $arrayCadena = str_split($cadena, 3);
    $arrayGirada = array();
    $i = 0;
    foreach ($arrayCadena as $valor){
        //Gira l'ordre dels caràcters.
        $arrayGirada[$i] = strrev($valor);
        //echo $arrayGirada[$i];
        $i++; 
        convertirString($arrayGirada); 
    }
}*/
/*function canviarValor($array){
    $i = 0;
    $valorCanviat = "";
    $cadenaGirada = implode("",$array);
    $caracter = str_split($cadenaGirada, 1);
    for($x = 0; $x < count($caracter); $x++){
        echo $caracter[$x] . " ";
    }
    $numeroCaracters = count($caracter);

    for($j = 0; $j<$numeroCaracters; $j++){
        if (ctype_alpha($caracter[$j])){
            //Transforma el caràcter en el seu respectiu numero de la taula ASCII.
            $numeroAscii = ord($caracter[$j]);
            $numeroNou = calculAscii($numeroAscii);
            //echo $numeroNou . " ";
            //Transforma el numero a lletra
            $lletra = chr($numeroNou);
            echo $lletra . " ";
           // $valorCanviat .= $lletra;
            $j++;
        }
        else{
            //$valorCanviat .= $caracter[$j];
            echo $caracter[$j];
            $j++;
        }
    }
    echo $valorCanviat;
    /*foreach($array as $valor){
        //echo $valor;
        $valorCanviat = "";
        //Separa els grups de 3 caràcter per caràcter.
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
        //echo $valorCanviat;
        $i++;
    }
 }*/
 /*function calculAscii($numero){
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
 }*/

 

?>
