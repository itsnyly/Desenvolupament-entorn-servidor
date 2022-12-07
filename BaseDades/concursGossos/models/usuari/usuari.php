<?php
class Usuari
{
    public $nomUsuari;
    public $password;

    public function __construct($nomUsuari, $password)
    {
        $this->nomUsuari = $nomUsuari;
        $this->password = $password;
    }

    static function get_all_usuaris()
    {
        $dbh = connexio();
        if($dbh){
            $stmt = $dbh->prepare("select nom_usuari,password_usuari from usuari");
            $stmt->execute();
            $row = $stmt->fetchAll();
            return $row;
        }
        else{
            return false;
        }
    }

    function get_usuari()
    {
        $dbh = connexio();

        try {
            $stmt = $dbh->prepare("select nom_usuari,password_usuari from usuari where nom_usuari = ? ");
            $stmt->execute(array($this->nomUsuari));
            $row = $stmt->fetch();
            return $row;

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . " Desfem</br>";
        }
    }

    function insert_usuari()
    {
        $dbh = connexio();

        try {
            $stmt = $dbh->prepare("INSERT INTO usuari (nom_usuari, password_usuari) VALUES(?,?)");
            $stmt->execute(array($this->nomUsuari, $this->password));

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . " Desfem</br>";
        }
    }

    function validar_usuari()
    {

        $infoUsuari = $this->get_usuari();
        if ($infoUsuari != null) {
            if ($infoUsuari["password_usuari"] == $this->password) {
                return $infoUsuari;
            }

        }

    }


}

?>