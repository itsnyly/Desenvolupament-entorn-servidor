<?php
session_start();
$_SESSION["nomUsuari"] = "";

if(isset($_POST["method"]) && $_POST["method"] == "signup"){
    if(isset($_POST["nom"]) && isset($_POST["usuari"]) && isset($_POST["contrasenya"])){
        if($_POST["nom"] != "" && $_POST["usuari"] != "" && $_POST["contrasenya"] != ""){
            $usuariTrobat = llegeix($_POST["usuari"]);
            if($usuariTrobat == null){
                $_SESSION["nomUsuari"] = $_POST["nom"];
                $_SESSION["correu"] = $_POST["usuari"];
                $_SESSION["registre"] = 1;
                escriuUsuari($_POST["nom"],$_POST["usuari"],$_POST["contrasenya"]);
                escriuConnexio($_SERVER["REMOTE_ADDR"],$_POST["usuari"],date("Y-m-d H:i:s"),"nou_usuari");
                header("Location: hola.php",true,302);
            }
            else{
                escriuConnexio($_SERVER["REMOTE_ADDR"],$_POST["usuari"],date("Y-m-d H:i:s"),"creacio_fallida");
                header("Location: index.php?error=usuariExistent",true,303);
            }
        }
        else{
            header("Location: index.php?error=campsBuits",true,303);
        }
    }
    else{
        header("Location: index.php",true,303);
    }
}
    
elseif(isset($_POST["method"]) && $_POST["method"] == "signin"){
    if(isset($_POST["correu"]) && isset($_POST["password"])){
        comprovarAutenticacio($_POST["correu"],$_POST["password"]);
    }
}
else{
    session_destroy();
    header("Location: index.php", true, 302);
}

/**
 * Comprova que l'usuari existeix dins del llistat d'usuaris registrats
 * @param string $usuari l'usuari que es comprovarà
 * @param string $password la contrasenya que es comprovarà
 */
function comprovarAutenticacio($usuari,$password){
   
    $usuariTrobat = llegeix($_POST["correu"]);
    if($usuariTrobat != null){
        if($usuariTrobat["password_usuari"] == md5($password)){
            $_SESSION["nomUsuari"] = $usuariTrobat["nom_usuari"];
            $_SESSION["correu"] = $usuari;
            $_SESSION["registre"] = 1;
            //escriuConnexio($_SERVER["REMOTE_ADDR"],$_POST["correu"],date("Y-m-d H:i:s"),"autenticacio_correcte");
            //header("Location: hola.php", true, 302);
        }
        else{
            escriuConnexio($_SERVER["REMOTE_ADDR"],$_POST["correu"],date("Y-m-d H:i:s"),"contrasenya_incorrecte");
            header("Location: index.php?error=passwordError", true, 303);
        }
    }
    else{
        escriuConnexio($_SERVER["REMOTE_ADDR"],$_POST["correu"],date("Y-m-d H:i:s"),"usuari_incorrecte");
        //header("Location: index.php?error=correuError", true, 303);
    }
}

/**
 * Escriu tant els intents de connexió com les connexions correctes que ha realitzat l'usuari
 * @param string $connexioEntrant la connexió que es guardarà
 */
function afegirConnexio($connexioEntrant){
    try {
        $hostname = "localhost";
        $dbname = "dwes-niltorrent-autpdo";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $dbh = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
      } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
      }
      
      try {
        //cadascun d'aquests interrogants serà substituit per un paràmetre.
        $stmt = $dbh->prepare("INSERT INTO usuaris (nom_usuari, correu_usuari, password_usuari) VALUES(?,?,md5(?))"); 
        //a l'execució de la sentència li passem els paràmetres amb un array 
        $stmt->execute( array($nom, $correu, $password)); 
      } catch(PDOException $e) { 
        print "Error!: " . $e->getMessage() . " Desfem</br>"; 
      } 
    //escriu($connexions,"connexions.json");
}

/**
 * Llegeix les dades del fitxer. Si el document no existeix torna un array buit.
 *
 * @param string $file
 * @return array
 */
function llegeix(string $usuari)
{
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
  
    //preparem i executem la consulta
    $query = $pdo->prepare("select nom_usuari, correu_usuari, password_usuari FROM usuaris WHERE correu_usuari = ?");
    $resultat = $query->execute(array($usuari));
    print_r($resultat);
    if(!$resultat){
      return null;
    }
    else{
      $row = $query->fetch();
      return $row;
    }
 
}

/**
 * Guarda les dades d'un usuari a la base de dades
 *
 * @param array $dades
 * @param string $file
 */
function escriuUsuari(string $nom,string $correu,string $password): void
{
    try {
        $hostname = "localhost";
        $dbname = "dwes-niltorrent-autpdo";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $dbh = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
      } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
      }
      
      try {
        //cadascun d'aquests interrogants serà substituit per un paràmetre.
        $stmt = $dbh->prepare("INSERT INTO usuaris (nom_usuari, correu_usuari, password_usuari) VALUES(?,?,md5(?))"); 
        //a l'execució de la sentència li passem els paràmetres amb un array 
        $stmt->execute( array($nom, $correu, $password)); 
      } catch(PDOException $e) { 
        print "Error!: " . $e->getMessage() . " Desfem</br>"; 
      } 
}

/**
 * Guarda les dades d'una connexió a la base de dades
 *
 * @param array $dades
 * @param string $file
 */
function escriuConnexio(string $ip,string $usuari,string $data,string $estat): void
{
    try {
        $hostname = "localhost";
        $dbname = "dwes-niltorrent-autpdo";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $dbh = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
      } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
      }
      
      try {
        //cadascun d'aquests interrogants serà substituit per un paràmetre.
        $stmt = $dbh->prepare("INSERT INTO connexions (ip_connexio, correu_usuari, data_connexio, estat_connexio) VALUES(?,?,?,?)"); 
        //a l'execució de la sentència li passem els paràmetres amb un array 
        $stmt->execute( array($ip, $usuari, $data, $estat)); 
      } catch(PDOException $e) { 
        print "Error!: " . $e->getMessage() . " Desfem</br>"; 
      } 
}
?>