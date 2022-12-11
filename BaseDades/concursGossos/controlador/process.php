<?php
session_start();
require_once("../models/baseDades/baseDades.php");
require_once("../connexions/connexio.php");
require_once("../models/fase/fase.php");
require_once("../models/vot/vot.php");

function numero_fase()
{
  $fase = Fase::get_fase_by_date($_SESSION["dataActual"]);
  $dataUltimaFase = Fase::get_fase_by_id(8);
  if ($fase) {
    return $fase["id_fase"];
  } else if ($_SESSION["dataActual"] > $dataUltimaFase["dataFinal"]) {
    return 8;
  } else {
    return false;
  }
}

function comprovar_vot_usuari()
{
  if (isset($_SESSION["votacioRealitzada"])) {
    return false;
  } else {
    $_SESSION["votacioRealitzada"] = session_id();
    return true;
  }
}

if (isset($_POST["poll"])) {
  if ($_POST["poll"] != "") {
    $numFase = numero_fase();
    print_r($numFase);
    if ($numFase) {
      $vot = new Vot(session_id(), $numFase, $_POST["poll"]);
      if (comprovar_vot_usuari() == true) {
        if ($vot->votar_gos() != false) {
          header("Location: ../index.php", true, 302);
        } else {
          header("Location: ../index.php?VotNoValid", true, 303);
        }
      } else {
        if ($vot->update_vot_gos() != false) {
          header("Location: ../index.php", true, 302);
        } else {
          header("Location: ../index.php?VotNoValid", true, 303);
        }
      }
    }
  }
}
