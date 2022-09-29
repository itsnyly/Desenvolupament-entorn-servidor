<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Exemple de formulari</title>

</head>

<body>

<div style="margin: 30px 10%;">
<h3>Formulari Conjetura Collatz</h3>
<form action="algorisme_3n+1.php" method="post" id="myform" name="myform">

	<label>N</label> <input type="text" value="" size="30"  name="n" /><br /><br />
   
	<button id="mysubmit" type="submit">Submit</button><br /><br />

</form>
</div>
<?php
function algorisme3n($valorN){
    $cadena = "";
    $posicions = 0;
    $numeroAlt = $valorN;
    while($valorN > 1){
        if($valorN % 2 == 0){
            $valorN = $valorN /2;
            echo $valorN . " ";
            $posicions++;
            if($valorN > $numeroAlt){
                $numeroAlt = $valorN;
            }
        }
        else{
            $valorN = ($valorN *3 +1);
            echo $valorN . " ";
            $posicions++;
            if($valorN > $numeroAlt){
                $numeroAlt = $valorN;
            }
        }
    }
    echo "<br>";
    echo "El número de passes a sigut de : " . $posicions . " ";
    echo "<br>";
    echo "El número més gran ha sigut el : " . $numeroAlt;
    
   // return $cadena;

}

echo algorisme3n($_REQUEST["n"]);

?>
</body>

</html>