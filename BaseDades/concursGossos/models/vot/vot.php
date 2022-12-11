<?php

class Vot
{
    public $sessio;
    public $fase;
    public $gos;

    public function __construct($sessio, $fase, $gos)
    {
        $this->sessio = $sessio;
        $this->fase = $fase;
        $this->gos = $gos;
    }

    function eliminar_vots_fase()
    {

        $dbh = connexio();

        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("DELETE FROM fasevots WHERE id_fase = ?");
            $stmt->execute(array($this->fase));
        }
    }

    function eliminar_guanyadors_fase()
    {

        $dbh = connexio();

        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("DELETE FROM guanyadors WHERE id_fase = ?");
            $stmt->execute(array($this->fase));
        }
    }

    static function eliminar_vots()
    {
        $dbh = connexio();

        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("DELETE FROM fasevots");
            $stmt->execute();
            return true;
        }
    }

    static function eliminar_guanyadors(){
        $dbh = connexio();

        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("DELETE FROM guanyadors");
            $stmt->execute();
            return true;
        }
    }

    static function count_vots_fase($nFase)
    {

        $dbh = connexio();
        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("SELECT COUNT(id_fase) AS Vots FROM fasevots WHERE id_fase = ?");
            $stmt->execute(array($nFase));
            $row = $stmt->fetch();
            return $row;
        }
    }

    function min_vots()
    {
        $dbh = connexio();
        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("SELECT COUNT(id_fase) AS Vots FROM fasevots WHERE id_fase = ? GROUP BY id_gos ORDER BY Vots ASC LIMIT 1;");
            $stmt->execute(array($this->fase));
            $row = $stmt->fetch();
            return $row;
        }
    }

    function vots_by_gos($idGos)
    {
        $dbh = connexio();
        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("SELECT COUNT(id_fase) AS Vots FROM fasevots WHERE id_fase = ? AND id_gos = ?;");
            $stmt->execute(array($this->fase, $idGos));
            $row = $stmt->fetch();
            return $row;
        }
    }

    static function vots_totals_gos($idGos){
        $dbh = connexio();
        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("SELECT COUNT(id_fase) AS Vots FROM fasevots WHERE id_gos = ?;");
            $stmt->execute(array($idGos));
            $row = $stmt->fetch();
            return $row;
        }
    }



    function trobar_gos_eliminat_by_fase($vots)
    {
        $dbh = connexio();
        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("SELECT id_gos FROM fasevots WHERE id_fase = ? GROUP BY id_gos HAVING COUNT(id_fase) = ?;");
            $stmt->execute(array($this->fase, $vots));
            $row = $stmt->fetchAll();
            return $row;
        }
    }

    function votar_gos()
    {
        $dbh = connexio();
        if ($dbh) {
            $stmt = $dbh->prepare("INSERT INTO fasevots (id_sessio, id_fase, id_gos) VALUES(?,?,?)");
            $stmt->execute(array($this->sessio, $this->fase, $this->gos));
            return true;
        } else {
            return false;
        }
    }
    static function search_gos_by_max_vots($maxVots){
        $dbh = connexio();
        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("SELECT COUNT(id_fase) AS Vots,id_gos FROM fasevots GROUP BY id_gos HAVING Vots = ?;");
            $stmt->execute(array($maxVots));
            $row = $stmt->fetchAll();
            return $row;
        }
    }


    function update_vot_gos(){
        $dbh = connexio();
        if ($dbh) {
            $stmt = $dbh->prepare("UPDATE fasevots SET id_gos = ? where id_sessio = ? AND id_fase = ?;");
            $stmt->execute(array($this->gos, $this->sessio, $this->fase));
            return true;
        } else {
            return false;
        }
    }
    function get_info_vot(){
        $dbh = connexio();
        if (!$dbh) {
            return false;
        } else {
            $stmt = $dbh->prepare("SELECT id_gos FROM fasevots WHERE id_fase = ? AND id_sessio = ?;");
            $stmt->execute(array($this->fase, $this->sessio));
            $row = $stmt->fetch();
            return $row;
        }
    }
}
