<?php
session_start();
$_SESSION["nomUsuari"] = "";

if(isset($_POST["method"]) && $_POST["method"] == "signup"){
    if(isset($_POST["nom"]) && isset($_POST["usuari"]) && isset($_POST["contrasenya"])){
        if($_POST["nom"] != "" && $_POST["usuari"] != "" && $_POST["contrasenya"] != ""){
        $usuaris = llegeix("users.json");
        if(!isset($usuaris[$_POST["usuari"]])){
            $_SESSION["nomUsuari"] = $_POST["nom"];
            $usuaris[$_POST["usuari"]] = [$_POST["nom"],$_POST["usuari"],$_POST["contrasenya"]];
            escriu($usuaris,"users.json");
            header("Location: hola.php",true,302);
        }
        else{
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
    unset($_SESSION["nomUsuari"]);
    header("Location: index.php", true, 302);
}

/**
 * Comprova que l'usuari existeix dins del llistat d'usuaris registrats
 * @param string $usuari l'usuari que es comprovarà
 */
function comprovarAutenticacio($usuari,$password){
   
    $resultatLectura = llegeix("users.json");
    if(isset($resultatLectura[$usuari])){
        if($resultatLectura[$usuari][2] == $password){
            $_SESSION["nomUsuari"] = $resultatLectura[$usuari][0];
            header("Location: hola.php", true, 302);
        }
        else{
            header("Location: index.php?error=passwordError", true, 303);
        }
    }
    else{
        header("Location: index.php?error=correuError", true, 303);
    }
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