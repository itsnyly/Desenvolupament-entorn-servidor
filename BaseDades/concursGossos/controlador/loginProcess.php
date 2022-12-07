<?php
require_once("../models/baseDades/baseDades.php");
require_once("../connexions/connexio.php");
require_once("../models/usuari/usuari.php");
session_start();


if (isset($_POST["correu"]) && isset($_POST["password"])) {
    $usuari = new Usuari($_POST["correu"], $_POST["password"]);
    if ($usuari->validar_usuari() != null) {
        $_SESSION["acces"] = "entra";
        header("Location: ../admin.php", true, 302);
    } else {
        header("Location: ../login.php", true, 303);

    }
}
?>