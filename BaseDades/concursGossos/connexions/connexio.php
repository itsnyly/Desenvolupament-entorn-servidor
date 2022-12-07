<?php 

function connexio(){
     //connexió dins block try-catch:
    //  prova d'executar el contingut del try
    //  si falla executa el catch
    try {
        $connexio = new baseDades("localhost","dwes-niltorrent-concurs-gossos","root","");
        $pdo = new PDO ("mysql:host=$connexio->hostname;dbname=$connexio->dbname","$connexio->username");
        return $pdo;
    } catch (PDOException $e) {
        return false;
    }
}
?>