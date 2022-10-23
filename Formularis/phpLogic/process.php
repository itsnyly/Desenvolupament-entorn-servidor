<?php 
session_start();
 /**
  * Comprova que la paraula entrada sigui una funció de php, que contingui la lletra de mig i que no estigui repetida.
  * @param string $paraula Paraula entrada per l'usuari.
  */
function comprovarParaula($paraula){
    $Solucions = get_defined_functions();
    if(in_array($paraula, $_SESSION["solucions"])){
        if(isset($_SESSION["resultats"])) {
            if (!in_array($paraula, $_SESSION["resultats"])) {
                $_SESSION["resultats"][] = $paraula;
            }
            else{
                header("Location: index.php?error=jahiés&paraula=$paraula", true, 303);
                die();
            }
        }
        else{
            $_SESSION["resultats"][] = $paraula;
        }
        
    }
    else if (!preg_match('/'. $_SESSION['lletres'][3].'/', ($paraula))) {
            header("Location: index.php?error=faltalalletradelmig", true, 303);
            die();
    }else {
            header("Location: index.php?error=Noesunafuncio", true, 303);
            die();
    }
}


$dadesRebudes = ($_SERVER['REQUEST_METHOD'] == 'POST');

$dadesCorrectes = $dadesRebudes && isset($_POST['paraula']);

if ($dadesRebudes) {
    if ($dadesCorrectes && !$_POST['paraula'] == "") {
        $paraula = $_POST['paraula'];
        header("Location: index.php?paraula=$paraula", true, 302);
        comprovarParaula($paraula);
        die();
    } else {
        header("Location: index.php", true, 303);
        die();
    }
}

?>