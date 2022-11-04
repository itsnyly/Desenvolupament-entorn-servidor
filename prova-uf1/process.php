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
                escriu($_POST["nom"],$_POST["usuari"],$_POST["contrasenya"]);
                $connexio = array("ip" => $_SERVER["REMOTE_ADDR"],"usuari" => $_POST["usuari"],"data" => date("Y-m-d H:i:s"),"estat" => "nou_usuari");
                afegirConnexio($connexio);
                header("Location: hola.php",true,302);
            }
            else{
                $connexio = array("ip" => $_SERVER["REMOTE_ADDR"],"usuari" => $_POST["usuari"],"data" => date("Y-m-d H:i:s"),"estat" => "creacio_fallida");
                afegirConnexio($connexio);
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
   
    $resultatLectura = llegeix("users.json");
    if(isset($resultatLectura[$usuari])){
        if($resultatLectura[$usuari][2] == $password){
            $_SESSION["nomUsuari"] = $resultatLectura[$usuari][0];
            $_SESSION["correu"] = $usuari;
            $_SESSION["registre"] = 1;
            $connexio = array("ip" => $_SERVER["REMOTE_ADDR"],"usuari" => $usuari,"data" => date("Y-m-d H:i:s"),"estat" => "autenticacio_correcte");
            afegirConnexio($connexio);
            header("Location: hola.php", true, 302);
        }
        else{
            $connexio = array("ip" => $_SERVER["REMOTE_ADDR"],"usuari" => $usuari,"data" => date("Y-m-d H:i:s"),"estat" => "contrasenya_incorrecte");
            afegirConnexio($connexio);
            header("Location: index.php?error=passwordError", true, 303);
        }
    }
    else{
        $connexio = array("ip" => $_SERVER["REMOTE_ADDR"],"usuari" => $usuari,"data" => date("Y-m-d H:i:s"),"estat" => "usuari_incorrecte");
        afegirConnexio($connexio);
        header("Location: index.php?error=correuError", true, 303);
    }
}

/**
 * Escriu tant els intents de connexió com les connexions correctes que ha realitzat l'usuari
 * @param string $connexioEntrant la connexió que es guardarà
 */
function afegirConnexio($connexioEntrant){
    $connexions = llegeix("connexions.json");
    $connexions[] = $connexioEntrant;
    escriu($connexions,"connexions.json");
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
    $query = $pdo->prepare("select * FROM usuaris WHERE correu_usuari ='".$usuari."'");
    $query->execute();
    $row = $query->fetch();
    return $row;
}

/**
 * Guarda les dades a un fitxer
 *
 * @param array $dades
 * @param string $file
 */
function escriu(string $nom,string $correu,string $password): void
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
          $stmt = $dbh->prepare("INSERT INTO usuaris (nom_usuari, correu_usuari, password_usuari) VALUES(".$nom.",".$correu.",".$password.")"); 
        //a l'execució de la sentència li passem els paràmetres amb un array 
        $stmt->execute( array('13', 'caco')); 
        echo "Insertat!"; 
      } catch(PDOException $e) { 
        print "Error!: " . $e->getMessage() . " Desfem</br>"; 
      } 
}
?>