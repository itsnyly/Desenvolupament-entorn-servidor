<?php
  //connexió dins block try-catch:
  //  prova d'executar el contingut del try
  //  si falla executa el catch
  try {
    $hostname = "localhost";
    $dbname = "dwes-niltorrent-autpdo";
    $username = "dwes-user";
    $pw = "dwes-pass";
    $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }
  $usuari = "ntorrent@boscdelacoma.cat";
  //preparem i executem la consulta
  $query = $pdo->prepare("select * FROM connexions WHERE correu_usuari ='".$usuari."'");
  $query->execute();
  $row = $query->fetch();
  if($row == false){
    print_r("hola");
  }
  
  //anem agafant les fileres d'amb una amb una
  /*
  while ( $row ) {
    print_r($row);
	$row = $query->fetch();
  }*/

  //eliminem els objectes per alliberar memòria 
  unset($pdo); 
  unset($query)
 
?>
