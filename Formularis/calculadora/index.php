<!DOCTYPE html>
<html lang="ca">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Calculadora</title>
</head>
<body>
    <div class="container">
        <form name="calc" class="calculator" action="" method="post">
            <input type="text" class="value" readonly value= "<?php echo mostrarNumero();?>"  name="resultat"/>
            <span class="num clear"><input type ="submit" value="C" name="tecla"></span>
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
            <span class="num"><input type ="submit" value="1" name="tecla"></span>
            <span class="num"><input type ="submit" value="2" name="tecla"></span>
            <span class="num"><input type ="submit" value="3" name="tecla"></span>
            <span class="num"><input type ="submit" value="0" name="tecla"></span>
            <span class="num"><input type ="submit" value="00" name="tecla"></span>
            <span class="num"><input type ="submit" value="." name="tecla"></span>
            <span class="num equal"><input type ="submit" value="=" name="tecla"></span>
        </form>
    </div>
</body>

<?php
function mostrarNumero(){
    $valor = implode($_REQUEST);
    switch(end($_REQUEST)){
        case "C":
            $valor = ""; 
            break;
        case "=":
            array_pop($_REQUEST);
            if($_REQUEST != null){
                $valor = eval("return (".implode($_REQUEST).");");
            }
            else{
                
            }
            break;      
    }
    return $valor;
}



?>