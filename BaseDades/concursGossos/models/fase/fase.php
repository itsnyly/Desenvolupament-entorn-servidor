<?php
//BETWEEN dataInici AND dataFinal AND ? BETWEEN dataInici AND dataFinal
class Fase
{
    public $idFase;
    public $dataInici;
    public $dataFinal;

    public function __construct($dataInici, $dataFinal, $idFase)
    {
        $this->dataInici = $dataInici;
        $this->dataFinal = $dataFinal;
        $this->idFase = $idFase;
    }

    static function get_all_fases()
    {
        $dbh = connexio();
        if ($dbh) {
            $stmt = $dbh->prepare("select id_fase,dataInici,dataFinal from fase");
            $stmt->execute();
            $row = $stmt->fetchAll();
            return $row;
        } else {
            return false;
        }
    }

    static function get_fase_by_id($idFase){
        $dbh = connexio();
        if ($dbh) {
            $stmt = $dbh->prepare("SELECT id_fase,dataInici,dataFinal FROM fase WHERE id_fase = ?");
            $stmt->execute(array($idFase));
            $row = $stmt->fetch();
            return $row;
        } else {
            return false;
        }
    }

    static function get_fase_by_date($dataActual)
    {
        $dbh = connexio();
        if ($dbh) {
            $stmt = $dbh->prepare("SELECT id_fase,dataFinal FROM fase WHERE ? BETWEEN dataInici AND dataFinal");
            $stmt->execute(array($dataActual));
            $row = $stmt->fetch();
            return $row;
        } else {
            return false;
        }
    }

    static function get_fases_by_date($dataActual)
    {
        $dbh = connexio();
        if ($dbh) {
            $stmt = $dbh->prepare("SELECT id_fase FROM fase WHERE dataFinal < ? ");
            $stmt->execute(array($dataActual));
            $row = $stmt->fetchAll();
            return $row;
        } else {
            return false;
        }
    }

    function check_fase_date($dataEnviada)
    {
        $dbh = connexio();
        if ($dbh) {
            $stmt = $dbh->prepare("SELECT id_fase FROM fase WHERE dataInici <= ? and dataFinal >= ? and id_fase != ? ");
            $stmt->execute(array($dataEnviada,$dataEnviada ,$this->idFase));
            $row = $stmt->fetch();
            return $row;
        } else {
            return false;
        }
    }

    function update_fase_date()
    {
        $dbh = connexio();
        if ($dbh) {
            $stmt = $dbh->prepare("UPDATE fase SET dataInici = ?, dataFinal = ? WHERE id_fase = ?");
            $stmt->execute(array($this->dataInici, $this->dataFinal,$this->idFase));
            return true;
        } else {
            return false;
        }
    }

   
}
