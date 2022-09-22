<?php
$i = 12;
$coma = 12.33;
$boolea = true;
$cadena = "Nil Torrent";
$tipus_de_i = gettype( $i );
$tipus_de_coma = gettype($coma);
$tipus_de_boolea = gettype($boolea);
$tipus_de_cadena = gettype($cadena);
echo "La variable \$i 
      conté el valor $i
	  i és del tipus $tipus_de_i ";
echo "La variable \$coma
      conté el valor $coma
      i és del tipus $tipus_de_coma ";
echo "La variable \$boolea
      conté el valor $boolea
      i és del tipus $tipus_de_boolea ";
echo "La variable \$cadena
      conté el valor $cadena
      i és del tipus $tipus_de_cadena ";
?>