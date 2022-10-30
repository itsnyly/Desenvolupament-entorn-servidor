<?php
session_start();
$_SESSION["nomUsuari"] = "";

if(isset($_POST["method"]) && $_POST["method"] == "signup"){
    if(isset($_POST["nom"]) && isset($_POST["usuari"]) && isset($_POST["contrasenya"])){
        if($_POST["nom"] != "" && $_POST["usuari"] != "" && $_POST["contrasenya"] != ""){
        $usuaris = llegeix("users.json");
            if(!isset($usuaris[$_POST["usuari"]])){
                $_SESSION["nomUsuari"] = $_POST["nom"];
                $_SESSION["correu"] = $_POST["usuari"];
                $_SESSION["registre"] = 1;
                $usuaris[$_POST["usuari"]] = [$_POST["nom"],$_POST["usuari"],$_POST["contrasenya"]];
                escriu($usuaris,"users.json");
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
function llegeix(string $file) : array
{
    $var = [];
    if ( file_exists($file) ) {
        $var = json_decode(file_get_contents($file), true);
    }
    return $var;
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
?>