<?php

class Fase
{
    public $idFase;
    public $dataInici;
    public $dataFinal;
    public $gossos;

    public function __construct($dataInici, $dataFinal,$idFase)
    {
        $this->dataInici = $dataInici;
        $this->dataFinal = $dataFinal;
        $this->idFase = $idFase;
        //$this->gossos = $gossos;
    }

    static function get_all_fases()
    {
        $dbh = connexio();
        if($dbh){
            $stmt = $dbh->prepare("select id_fase,dataInici,dataFinal from fase");
            $stmt->execute();
            $row = $stmt->fetchAll();
            return $row;
        }
        else{
            return false;
        }
       
    }

    static function get_fase_by_date($dataActual){
        $dbh = connexio();
        if($dbh){
            $stmt = $dbh->prepare("SELECT id_fase,dataFinal FROM fase WHERE ? BETWEEN dataInici AND dataFinal");
            $stmt->execute(array($dataActual));
            $row = $stmt->fetch();
            return $row;
        }
        else{
            return false;
        }
    }

}

?>