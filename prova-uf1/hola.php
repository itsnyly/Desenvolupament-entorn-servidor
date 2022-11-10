<?php 
session_start();
include_once("connexio.php");

/**
 * Llegeix les dades de la taula usuaris. Retorna els resultats.
 *
 * @param string $usuari
 * @return $row
 */
function llegeix(string $usuari)
{
    $pdo = connexio();
    //preparem i executem la consulta
    $query = $pdo->prepare("select ip_connexio, data_connexio, estat_connexio FROM connexions WHERE correu_usuari = ? AND estat_connexio IN ('autenticacio_correcte','nou_usuari')");
    $query->execute(array($usuari));
    $row = $query->fetchAll();
    return $row;
}

/**
 * Guarda les dades d'una connexió a la base de dades
 *
 * @param string $ip
 * @param string $usuari
 * @param string $data
 * @param string $estat
 */
function escriuConnexio(string $ip,string $usuari,string $data,string $estat): void
{
    $dbh = connexio();
      
      try {
        //cadascun d'aquests interrogants serà substituit per un paràmetre.
        $stmt = $dbh->prepare("INSERT INTO connexions (ip_connexio, correu_usuari, data_connexio, estat_connexio) VALUES(?,?,?,?)"); 
        //a l'execució de la sentència li passem els paràmetres amb un array 
        $stmt->execute( array($ip, $usuari, $data, $estat)); 
      } catch(PDOException $e) { 
        print "Error!: " . $e->getMessage() . " Desfem</br>"; 
      } 
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
            EscriuConnexio($_SERVER["REMOTE_ADDR"],$_SESSION["correu"],date("Y-m-d H:i:s",time()),"tancar_sessio");
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
           $connexions = llegeix($_SESSION["correu"]);
           if($connexions != null){
            echo "<br>";
            foreach ($connexions as $key => $value) {
                    echo $value["ip_connexio"] . " " . $value["data_connexio"] . " " . $value["estat_connexio"] . " ";
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