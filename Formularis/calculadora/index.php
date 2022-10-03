<!DOCTYPE html>
<html lang="ca">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Calculadora</title>
</head>

<?php

function mostarNumero() {
    $valor = implode($_POST);
    if (isset($_POST["resultat"]) && ($_POST["resultat"] == "ERROR" || $_POST["resultat"] == "INF")) {
        $valor = str_replace("INF","",$valor);
        $valor = str_replace("ERROR","",$valor);
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
  
  function calcular($operacio) {

    try {
        if(preg_match('/^[0-9()+.\-*\(SIN)(COS)\/]+$/', $operacio)){
                    
            $valor = eval("return (".$operacio.");");
        }else{
            $valor = "ERROR";
        }
        
        if(is_float($valor) && (int)strlen(substr(strrchr($valor, "."), 1)) > 4 ){
            $valor = number_format((float)$valor, 4, '.', '');
        }
    } catch (DivisionByZeroError $e) {

        $valor = "INF";

    } catch (Throwable $e) {

        $valor = "ERROR";
    }

    return $valor;

}
 
?>
<body>
    <div class="container">
        <form name="calc" class="calculator" action="index.php" method="post">
            <input type="text" class="value" readonly value="<?=mostarNumero()?>" name="resultat" />
            <span class="num"><input type ="submit" value="(" name="tecla"></span>
            <span class="num"><input type ="submit" value=")" name="tecla"></span>
            <span class="num"><input type ="submit" value="SIN" name="tecla"></span>
            <span class="num"><input type ="submit" value="COS" name="tecla"></span>
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


