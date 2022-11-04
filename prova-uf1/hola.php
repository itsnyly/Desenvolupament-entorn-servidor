<?php 
session_start();

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
    $query = $pdo->prepare("select * FROM connexions WHERE correu_usuari ='".$usuari."'");
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
function escriu(array $dades, string $file): void
{
    file_put_contents($file,json_encode($dades, JSON_PRETTY_PRINT));
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
 * Afegeix un minut de més al temps actual i comprova que el pròxim cop que s'entri no hagi passat més d'un minut.      
 */
function controlarTempsSessio(){
    if(!isset($_SESSION["tempsMesMinut"])){
        $_SESSION["tempsMesMinut"] = time()+60;
    }
    else{
        if(time() > $_SESSION["tempsMesMinut"]){
            $connexio = array("ip" => $_SERVER["REMOTE_ADDR"],"usuari" => $_SESSION["correu"],"data" => date("Y-m-d H:i:s",time()),"estat" => "tancar_sessio");
            afegirConnexio($connexio);
            session_destroy();
            header("Location: index.php",true,302);
        }
    }
}

if(isset($_SESSION["registre"])){
    if($_SESSION["registre"] == 1){
        controlarTempsSessio();
    }
    else{
        header("Location: index.php",true,303);
    }
}

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Benvingut</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">

</head>
<body>
<div class="container noheight" id="container">
    <div class="welcome-container">
        <h1>Benvingut!</h1>
        <div>Hola <?php echo $_SESSION["nomUsuari"] ?>, les teves darreres connexions són: 
        <?php
           $connexions = llegeix("connexions.json");
           echo "<br>";
            foreach ($connexions as $key => $value) {
                if($value["usuari"] == $_SESSION["correu"] && ($value["estat"] == "nou_usuari" || $value["estat"] == "autenticacio_correcte")){
                    echo $value["ip"] . " " . $value["data"] . " " . $value["estat"] . " ";
                    echo "<br>";
                }
            }
        ?>
        </div>
        <form action="process.php" method="post">
            <button type="submit">Tanca la sessió</button>
        </form>
    </div>
</div>
</body>
</html>