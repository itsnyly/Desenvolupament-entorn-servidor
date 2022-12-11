<?php
require_once("../models/baseDades/baseDades.php");
require_once("../connexions/connexio.php");
require_once("../models/usuari/usuari.php");
require_once("../models/gos/gos.php");
require_once("../models/vot/vot.php");
require_once("../models/fase/fase.php");






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
                    $countGossos = Gos::get_count_gossos();
                    if ($countGossos != false && $countGossos < 9) {
                        $gossos = Gos::get_all_gossos();
                        if (!in_array($_POST["nom"], $gossos)) {
                            $nouGos = new Gos("", $_POST["nom"], $_POST["amo"], $_POST["raça"], $_POST["img"]);
                            $nouGos->insert_gos();
                            header("Location: ../admin.php", true, 302);
                        } else {
                            header("Location: ../admin.php", true, 303);
                        }
                    } else {
                        header("Location: ../admin.php?error=NúmeroMàximDeGossos", true, 303);
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
                    $nouGos = new Gos($_POST["id"], $_POST["nom"], $_POST["amo"], $_POST["raça"], $_POST["imatge"]);
                    $nouGos->update_gos();
                    header("Location: ../admin.php", true, 302);
                } else {
                    header("Location: ../admin.php", true, 303);
                }
            } else {
                header("Location: ../admin.php", true, 303);
            }
            break;

        case 'esborrarVotsFase':
            if (isset($_POST["fase"])) {
                if ($_POST["fase"] != "") {
                    $vot = new Vot("", $_POST["fase"], "");
                    if ($vot->count_vots_fase($_POST["fase"]) > 0 && $vot->count_vots_fase($_POST["fase"]) != false) {
                        if($vot->eliminar_vots_fase() != false){
                            $vot->eliminar_guanyadors_fase();
                            header("Location: ../admin.php", true, 302);
                        }
                        else{
                            header("Location: ../admin.php?ErrorBaseDeDades", true, 303);
                        }

                    } else {
                        header("Location: ../admin.php?NoHiHaVotsD'aquestaFase", true, 303);
                    }
                } else {
                    header("Location: ../admin.php", true, 303);
                }
            } else {
                header("Location: ../admin.php", true, 303);
            }
            break;

        case 'esborrarVots':

            $eliminar = Vot::eliminar_vots();
            if($eliminar != false){
                Vot::eliminar_guanyadors();
                header("Location: ../admin.php", true, 302);
            }
            else{
                header("Location: ../admin.php?ErrorBaseDeDades", true, 303);
            }
            break;

        case 'modificarFase':
            if (isset($_POST["dataInici"]) && isset($_POST["dataFinal"])) {
                if ($_POST["dataInici"] != "" && $_POST["dataFinal"] != "") {
                    $fase = new Fase($_POST["dataInici"], $_POST["dataFinal"], $_POST["idFase"]);
                    if ($fase->check_fase_date($_POST["dataInici"]) == null && $fase->check_fase_date($_POST["dataFinal"]) == null) {
                        $fase->update_fase_date();
                        header("Location: ../admin.php", true, 302);
                    } else if ($fase->check_fase_date($_POST["dataInici"]) == false) {
                        header("Location: ../admin.php?ErrorBaseDeDades", true, 303);
                    } else {
                        header("Location: ../admin.php?DataNoCorrecte", true, 303);
                    }
                } else {
                    header("Location: ../admin.php", true, 303);
                }
            } else {
                header("Location: ../admin.php", true, 303);
            }

        default:
            break;
    }
}
