<?php
require_once("../models/baseDades/baseDades.php");
require_once("../connexions/connexio.php");
require_once("../models/usuari/usuari.php");
require_once("../models/gos/gos.php");




if (isset($_POST["method"]) && $_POST["method"] != "") {
    switch ($_POST["method"]) {
        case 'nouUsuari':
            if (isset($_POST["nomUsuari"]) && isset($_POST["passwordUsuari"])) {
                if ($_POST["nomUsuari"] != "" && $_POST["passwordUsuari"] != "") {
                    $usuaris = Usuari::get_all_usuaris();
                    if (!in_array($_POST["nomUsuari"], $usuaris)) {
                        $nouUsuari = new Usuari($_POST["nomUsuari"], $_POST["passwordUsuari"]);
                        $nouUsuari->insert_usuari();
                        header("Location: ../admin.php", true, 302);
                    } else {
                        header("Location: ../admin.php", true, 303);
                    }
                } else {
                    header("Location: ../admin.php", true, 303);
                }
            } else {
                header("Location: ../admin.php", true, 303);
            }
            break;
        case 'nouGos':
            if (isset($_POST["nom"]) && isset($_POST["img"]) && isset($_POST["amo"]) && isset($_POST["raça"])) {
                if ($_POST["nom"] != "" && $_POST["img"] != "" && $_POST["amo"] != "" && $_POST["raça"] != "") {
                    $gossos = Gos::get_all_gossos();
                    if (!in_array($_POST["nom"], $gossos)) {
                        $nouGos = new Gos("",$_POST["nom"], $_POST["amo"], $_POST["raça"], $_POST["img"]);
                        $nouGos->insert_gos();
                        header("Location: ../admin.php", true, 302);
                    } else {
                        header("Location: ../admin.php", true, 303);
                    }
                } else {
                    header("Location: ../admin.php", true, 303);
                }
            } else {
                header("Location: ../admin.php", true, 303);
            }
            break;
            case 'modificarGos':
                if (isset($_POST["nom"]) && isset($_POST["imatge"]) && isset($_POST["amo"]) && isset($_POST["raça"])) {
                    if ($_POST["nom"] != "" && $_POST["imatge"] != "" && $_POST["amo"] != "" && $_POST["raça"] != "") {
                            $nouGos = new Gos($_POST["id"],$_POST["nom"], $_POST["amo"], $_POST["raça"], $_POST["imatge"]);
                            $nouGos->update_gos();
                            header("Location: ../admin.php", true, 302);
                    } else {
                        header("Location: ../admin.php", true, 303);
                    }
                } else {
                    header("Location: ../admin.php", true, 303);
                }
                break;


        default:
            break;
    }
}
?>