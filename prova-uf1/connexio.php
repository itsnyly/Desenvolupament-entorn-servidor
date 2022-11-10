<?php 

function connexio(){
     //connexió dins block try-catch:
    //  prova d'executar el contingut del try
    //  si falla executa el catch
    try {
        $hostname = "localhost";
        $dbname = "dwes-niltorrent-autpdo";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
        return $pdo;
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        header("Location: index.php?error=ConnexioFallida", true, 303);
        exit;
    }
    
}
?>
