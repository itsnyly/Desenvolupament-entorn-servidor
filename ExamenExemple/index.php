<?php
if( !isset($_COOKIE["laMevaCookie"]))  { 
    //Si no s'ha creat la cookie, la creem
    $val = 1;
    setcookie ("laMevaCookie", $val); 
}
else{

    $val = $_COOKIE["laMevaCookie"] +1;
    setcookie("laMevaCookie", $val);
    
}

//incloure altres fitxers
include_once "funcions.php";

//retrieving
$var = llegeix_de_disc();
//afegir dades darrera connexió
$ip_remota = $_SERVER["REMOTE_ADDR"];
$navegador = $_SERVER["HTTP_USER_AGENT"];
$txt = "Connexió $val des de $ip_remota using $navegador";
$var[] = $txt;

//mostrar totes les connexions al navegador
foreach ($var as $key => $value) {
    echo " ";
    print_r($value);
}
//storing
persisteix_a_disc($var);

?>
