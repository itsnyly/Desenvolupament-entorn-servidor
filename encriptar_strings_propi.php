<?php 

function getIp(){
     $ip = 0;
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
         $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
         $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
         $ip = $_SERVER['REMOTE_ADDR'];
    }
    if($ip == "::1"){
     return "127.0.0.1";
    }
}

function partirArray($text){
     $llargada = strlen($text);
     $cadenaPartida = str_split($text, $llargada/2);
     $cadenaGirada = array();
     $cadenaGirada[0] = $cadenaPartida[1];
     $cadenaGirada[1] = $cadenaPartida[0];
     $cadena = $cadenaGirada[0] . $cadenaGirada[1];
     return $cadena;
}


function encrypt($text,$ipNumero){
     $posicioNumero = 0;
     $cadenaCanviada = "";
     $cadena = partirArray($text);
     $caracters64 = base64_encode($cadena);
     //echo $caracters64 . "\n";
     $valorHexa = bin2hex($caracters64);
     $caractersHexa = str_split($valorHexa,1);  
     for($i = count($caractersHexa) -1; $i>0; $i--){
          if(!is_numeric($caractersHexa[$i])){
               $posicioNumero++;
          }
          else{
               $posicioNumero++;
               break;
          }
     }
     $ipSeparada = str_split($ipNumero[0],1);
     $caractersHexa[count($caractersHexa) - $posicioNumero] =  intval($ipSeparada[0]) + intval($ipSeparada[1]) - intval($ipNumero[3]);
     for ($i = 0; $i < count($caractersHexa); $i++){
          $cadenaCanviada .= $caractersHexa[$i];
     }
     $valorBin = hex2bin($cadenaCanviada);
     $resultatCodi = base64_encode($valorBin);
     return $resultatCodi;
 
}
function decrypt($text,$ipNumero){
    $cadenaHexCanviada = "";
    $numeroPosicio = 0;
    $valorDecode = base64_decode($text);
    $valorsHexadecimal = bin2hex($valorDecode);
    $caractersHexadecimal = str_split($valorsHexadecimal,1);

    for($i = count($caractersHexadecimal) -1; $i>0; $i--){
          if(!is_numeric($caractersHexadecimal[$i])){
               $numeroPosicio++;
          }
          else{
               $numeroPosicio++;
               break;
          }
     }
     $ipSeparada = str_split($ipNumero[0],1);
    
     $caractersHexadecimal[count($caractersHexadecimal) - $numeroPosicio] = intval($ipSeparada[0]) + intval($ipSeparada[1]) + intval($ipNumero[3]);

     for ($i = 0; $i < count($caractersHexadecimal); $i++){
          $cadenaHexCanviada .= $caractersHexadecimal[$i];
     }
     $valorsBin = hex2bin($cadenaHexCanviada);
     $resultat = base64_decode($valorsBin);
     $resultatFinal = partirArray($resultat);
     echo $resultatFinal;

}


$ip = getIp();
$ipNumero = explode(".",$ip);
$text = "Operació completada !!";

echo  "Text Original ---> " . $text;
echo "\n";
$textEncriptat = encrypt($text,$ipNumero);
echo "Text Encriptat ---> " . $textEncriptat;
echo "\n";
echo "Text Desencriptat ---> ";
echo decrypt($textEncriptat,$ipNumero);
//echo "\n";


?> 
