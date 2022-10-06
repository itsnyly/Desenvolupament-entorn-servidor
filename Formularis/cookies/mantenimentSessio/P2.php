<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pàgina 2</title>
</head>
<body>
    <h1>Pàgina 2</h1>
    <?php 
        echo "El meu Nom és : " . $_SESSION["elMeuNom"] . "</br>";
        echo "El meu Cognom és : " . $_SESSION["elMeuCognom"];
    ?>
</body>
</html>