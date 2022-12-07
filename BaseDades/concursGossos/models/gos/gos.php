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

    if(!$dbh){
      return false;
    }else{
        $stmt = $dbh->prepare("SELECT id_gos,nom,imatge,amo,raça FROM gos");
        $stmt->execute();
        $row = $stmt->fetchAll();
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

}

?>