<!DOCTYPE html>
<html lang="ca">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Calculadora</title>
</head>

<?php

/** 
 * Funció principal. S'encarrega de mostrar per pantalla les tecles seleccionades.
 * @return valor resultat que es mostra per pantalla.
*/
function mostarNumero() {

    $valor = implode($_POST);

    if (isset($_POST["resultat"]) && ($_POST["resultat"] == "ERROR" || $_POST["resultat"] == "INF")) {
        $valor = str_replace("INF","",$valor);
        $valor = str_replace("ERROR","",$valor);
    }
    else{
        $valor = comprovarOperacio($valor);
    }

    switch (end($_POST)) {
        case 'Sin':
            $valor = '';
            break;
        case 'C':
            $valor = '';
            break;
        case '=':
            array_pop($_POST);
            $valor = calcular(implode($_POST));
            break;    
    }

     return $valor;

  }

  /**
   * Funció la qual comprova la cadena d'operació a executar per evitar que s'introdueixin 
   * dos símbols d'operacions iguals de manera simultània.
   * @param operacio string
   * @return operacioPartida string
   */

  function comprovarOperacio($operacio){

    $operacioPartida = str_split($operacio);
    for ($i=0; $i < sizeof($operacioPartida)-1; $i++) { 
       if($operacioPartida[$i] == $operacioPartida[$i +1] && !is_numeric($operacioPartida[$i]) && $operacioPartida[$i] != '(' && $operacioPartida[$i] != ')' && !preg_match('/[A-Za-z]/', $operacioPartida[$i])){
            array_pop($operacioPartida);
            return implode($operacioPartida);
       }
    }
    return implode($operacioPartida);
}

  /**
   * Executa la cadena ,passada per paràmetres, de manera literal per tal d'obtenir el resultat de la operació.
   * Possa un màxim de 4 decimals de les operacions amb fracció decimal.
   * Primerament recull l'excepció causada al dividir per zero i llavors recull els altre errors a 
   * través d'una excepció global. 
   * * Si s'intenta introduir codi php et mostrarà ERROR per pantalla.
   * @param operació string
   * @return valor resultat de la operació
   */

  function calcular($operacio) {
    try {
        if(preg_match('/^[0-9()+.\-*\(SIN)(COS)\/]+$/', $operacio)){
                    
            $valor = eval("return (".$operacio.");");
            if(is_float($valor) && (int)strlen(substr(strrchr($valor, "."), 1)) > 4 ){
                $valor = number_format((float)$valor, 4, '.', '');
            }

        }else{
            $valor = "ERROR";
        }
        
    } catch (DivisionByZeroError $ex) {

        $valor = "INF";

    } catch (Throwable $ex) {

        $valor = "ERROR";
    }
    return $valor;

}

?>
<body>
    <div class="container">
        <form name="calc" class="calculator" action="index.php" method="post">
            <input type="text" class="value" readonly value="<?=mostarNumero()?>" name="resultat" />
            <span class="num petit"><input type ="submit" value="(" name="tecla"></span>
            <span class="num petit"><input type ="submit" value=")" name="tecla"></span>
            <span class="num petit"><input type ="submit" value="SIN" name="tecla"></span>
            <span class="num petit"><input type ="submit" value="COS" name="tecla"></span>
            <span class="num clear" ><input type ="submit" value="C"name="tecla"></span>
            <span class="num"><input type ="submit" value="/" name="tecla"></span>
            <span class="num"><input type ="submit" value="*" name="tecla"></span>
            <span class="num"><input type ="submit" value="7" name="tecla"></span>
            <span class="num"><input type ="submit" value="8" name="tecla"></span>
            <span class="num"><input type ="submit" value="9" name="tecla"></span>
            <span class="num"><input type ="submit" value="-" name="tecla"></span>
            <span class="num"><input type ="submit" value="4" name="tecla"></span>
            <span class="num"><input type ="submit" value="5" name="tecla"></span>
            <span class="num"><input type ="submit" value="6" name="tecla"></span>
            <span class="num plus"><input type ="submit" value="+" name="tecla"></span>
            <span class="num"><input type ="submit" value="1"name="tecla"> </span>
            <span class="num"><input type ="submit" value="2"name="tecla"></span>
            <span class="num"><input type ="submit" value="3"name="tecla"></span>
            <span class="num"><input type ="submit" value="0"name="tecla"></span>
            <span class="num"><input type ="submit" value="00"name="tecla"></span>
            <span class="num"><input type ="submit" value="."name="tecla"></span>
            <span class="num equal"><input type ="submit" value="="name="tecla"></span>
        </form>
    </div>
</body>


