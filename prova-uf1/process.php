<?php
session_start();
$arrayUsuaris = [];
if(isset($_POST["method"]) && $_POST["method"] == "signup"){
    if(isset($_POST["nom"]) && isset($_POST["usuari"]) && isset($_POST["contrasenya"])){
        array_push($arrayUsuaris,$_POST["nom"]);
        array_push($arrayUsuaris,$_POST["usuari"]);
        array_push($arrayUsuaris,$_POST["contrasenya"]);
    };
    if(!empty($arrayUsuaris)){
        if(!isset($usuaris)){
            $usuaris = [];
        }
        else{
            if(!empty(llegeix("users.json"))){
                $usuaris = json_decode(file_get_contents($file), true);
            }
        }
        array_push($usuaris,$_POST["usuari"],$arrayUsuaris);
    }
    
    if(sizeof($usuaris) > 0){
        $resultatLectura = llegeix("users.json");
        if(!empty($resultatLectura)){
            if(!in_array($_POST["usuari"],$resultatLectura)){
                escriu($usuaris,"users.json");
            }
        }
        else{
            escriu($usuaris,"users.json");

        }
    }
}

elseif(isset($_POST["method"]) && $_POST["method"] == "signin"){
    if(isset($_POST["correu"]) && isset($_POST["password"])){
        comprovarAutenticacio($_POST["correu"]);
    }
}


/**
 * Comprova que l'usuari existeix dins del llistat d'usuaris registrats
 * @param string $usuari l'usuari que es comprovarà
 */
function comprovarAutenticacio($usuari){
    $resultatLectura = llegeix("users.json");
    if(in_array($usuari,$resultatLectura)){
        if(!isset($_SESSION["nomUsuari"])){
            $_SESSION["nomUsuari"] = "";
        }
        else{
        
           foreach ($resultatLectura as $key => $value) {
                if($value == $usuari){
                    $_SESSION["nomUsuari"] = $value;
                }
           }

        }
        header("Location: hola.php", true, 302);
        die();     
    }
    else{
        header("Location: index.php", true, 303);
        die();
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