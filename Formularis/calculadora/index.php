<!DOCTYPE html>
<html lang="ca">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Calculadora</title>
</head>
<?php

function mostrarNumero(){
    $valor = implode($_POST);
    if (isset($_REQUEST["resultat"]) && (str_contains($_REQUEST['resultat'], "INF")) || (str_contains($_REQUEST['resultat'], "ERROR"))) {

        $valor = str_replace("INF","",$valor);
        $valor = str_replace("ERROR","",$valor);
    }
   
    switch(end($_POST)){
        case "C":
            $valor = ""; 
            break;
        case "=":
            try{
                array_pop($_POST);
                preg_match('/(0-9)*}', 'ac', $matches);
                eval("$valor= (".implode($_POST).");");
                if(is_float($valor) && (int)strlen(substr(strrchr($valor, "."), 1)) > 4 ){
                    $valor = number_format((float)$valor, 4, '.', '');
                }
            }
            catch(DivisionByZeroError $e){
                $valor = "INF";
            }
            catch(Throwable $ex){
                $valor = "ERROR";
            }
            break;      
    }
    return $valor;
}
?>
<body>
    <div class="container">
        <form name="calc" class="calculator" action="" method="post">
            <input type="text" class="value" readonly value="<?= mostrarNumero()?>" name="resultat" />
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

