<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Accés</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/login.css" rel="stylesheet">

</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="controlador/loginProcess.php" method="post">
                <h1>Inicia la sessió</h1>
                <span>introdueix les teves credencials</span>
                <input type="hidden" name="method" value="signin" />
                <input name="correu" type="text" placeholder="usuari" />
                <input name="password" type="password" placeholder="Contrasenya" />
                <button>Inicia la sessió</button>
            </form>
        </div>
    </div>
</body>
<br>

</html>