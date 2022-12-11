<?php

class Gos
{
  public $id;
  public $nom;
  public $imatge;
  public $amo;
  public $raça;

  public function __construct($id, $nom, $amo, $raça, $imatge)
  {
    $this->id = $id;
    $this->nom = $nom;
    $this->imatge = $imatge;
    $this->amo = $amo;
    $this->raça = $raça;
  }


  static function get_all_gossos()
  {
    $dbh = connexio();

    if (!$dbh) {
      return false;
    } else {
      $stmt = $dbh->prepare("SELECT id_gos,nom,imatge,amo,raça FROM gos");
      $stmt->execute();
      $row = $stmt->fetchAll();
      return $row;
    }
  }

  static function get_gossos_guanyadors_primeraFase($idGos)
  {
    $dbh = connexio();

    if (!$dbh) {
      return false;
    } else {
      $stmt = $dbh->prepare("SELECT id_gos,nom,imatge,amo,raça FROM gos WHERE id_gos != ?");
      $stmt->execute(array($idGos));
      $row = $stmt->fetchAll();
      return $row;
    }
  }
  static function get_gossos_guanyadors($idFase,$idGos)
  {
    $dbh = connexio();

    $dbh = connexio();

    if (!$dbh) {
      return false;
    } else {
      $stmt = $dbh->prepare("SELECT id_gos,nom,imatge,amo,raça FROM guanyadors WHERE numFase = ? AND id_gos != ?");
      $stmt->execute(array($idFase,$idGos));
      $row = $stmt->fetchAll();
      return $row;
    }
  }

  static function get_count_gossos()
  {
    $dbh = connexio();

    if (!$dbh) {
      return false;
    } else {
      $stmt = $dbh->prepare("SELECT COUNT(id_gos) FROM gos");
      $stmt->execute();
      $row = $stmt->fetch();
      return $row;
    }
  }
  function insert_gos()
  {
    $dbh = connexio();

    try {
      $stmt = $dbh->prepare("INSERT INTO gos (nom, amo, raça, imatge) VALUES(?,?,?,?)");
      $stmt->execute(array($this->nom, $this->amo, $this->raça, $this->imatge));
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . " Desfem</br>";
    }
  }

  function update_gos()
  {
    $dbh = connexio();

    try {
      $stmt = $dbh->prepare("UPDATE gos SET nom = ?, amo = ?, raça = ?, imatge = ? WHERE id_gos = ?");
      $stmt->execute(array($this->nom, $this->amo, $this->raça, $this->imatge, $this->id));
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . " Desfem</br>";
    }
  }

  function insert_gos_guanyador($idFase,$vots)
  {
    $dbh = connexio();

    try {
      $stmt = $dbh->prepare("INSERT INTO guanyadors (numFase,id_gos,nom, amo, raça, imatge, numVots) VALUES(?,?,?,?,?,?,?)");
      $stmt->execute(array($idFase, $this->id, $this->nom, $this->amo, $this->raça, $this->imatge, $vots));
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . " Desfem</br>";
    }
  }

  static function get_llistat_gossos_guanyadors($idFase)
  {
    $dbh = connexio();

    if (!$dbh) {
      return false;
    } else {
      $stmt = $dbh->prepare("SELECT id_gos,nom,imatge,amo,raça,numVots FROM guanyadors WHERE numFase = ?");
      $stmt->execute(array($idFase));
      $row = $stmt->fetchAll();
      return $row;
    }
  }
}
