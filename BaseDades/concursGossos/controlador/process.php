<?php
session_start();
require_once("../models/baseDades/baseDades.php");
require_once("../connexions/connexio.php");

if (isset($_POST["poll"])) {
  if ($_POST["poll"] != "") {
    votar_gos($_POST["poll"]);
  }
}

function votar_gos()
{
  $dbh = connexio();
  $idGos = $_POST["poll"];
  if($dbh){
    try {
      $stmt = $dbh->prepare("INSERT INTO fasevots (id_sessio, id_fase, id_gos) VALUES(?,?,?)");
      //SQLESTATE[23000] primary key violation
      $stmt->execute(array(session_id(), 1, $idGos));
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . " Desfem</br>";
    }
  }

  
}


function get_gos($nomGos)
{
  $dbh = connexio();
  if($dbh){
    try {

      //cadascun d'aquests interrogants serà substituit per un paràmetre.
      $stmt = $dbh->prepare("select id_gos,nom from gos where nom = ?");
      //a l'execució de la sentència li passem els paràmetres amb un array 
      $stmt->execute(array($nomGos));
      $row = $stmt->fetch();
      return $row;
  
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . " Desfem</br>";
    }
  }
  else{
    return false;
  }

  
}


function get_vots_gos($id)
{
  $dbh = connexio();
  if($dbh){
    try {

      //cadascun d'aquests interrogants serà substituit per un paràmetre.
      $stmt = $dbh->prepare("select id_gos,id_fase,vots from fasevots where id_gos = ?");
      //a l'execució de la sentència li passem els paràmetres amb un array 
      $stmt->execute(array($id));
      $row = $stmt->fetch();
      return $row;
  
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . " Desfem</br>";
    }
  }
  else{
    return false;
  }

  
}
?>