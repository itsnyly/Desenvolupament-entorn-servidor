<?php
    session_start();
    if(isset($_SESSION["tempsMesMinut"])){
        if(time() < $_SESSION["tempsMesMinut"]){
            header("Location: hola.php",true,302);
        }
    }
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Accés</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">

</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="process.php" method="post">
                <h1>Registra't</h1>
                <span>crea un compte d'usuari</span>
                <input type="hidden" name="method" value="signup"/>
                <input name = "nom" type="text" placeholder="Nom" />
                <input name = "usuari" type="email" placeholder="Correu electronic" />
                <input name = "contrasenya" type="password" placeholder="Contrasenya" />
                <button type="submit">Registra't</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="process.php" method="post">
                <h1>Inicia la sessió</h1>
                <span>introdueix les teves credencials</span>
                <input type="hidden" name="method" value="signin"/>
                <input name = "correu" type="email" placeholder="Correu electronic" />
                <input name = "password" type="password" placeholder="Contrasenya" />
                <button>Inicia la sessió</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Ja tens un compte?</h1>
                    <p>Introdueix les teves dades per connectar-nos de nou</p>
                    <button class="ghost" id="signIn">Inicia la sessió</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Primera vegada per aquí?</h1>
                    <p>Introdueix les teves dades i crea un nou compte d'usuari</p>
                    <button class="ghost" id="signUp">Registra't</button>
                </div>
            </div>
        </div>
    </div>
</body>
<br>
<?php
    if(isset($_GET["error"])){
        switch ($_GET["error"]) {
            case 'usuariExistent':
                echo "<div class='error'><p>L'usuari ja existeix</p></div>";
                break;
            case 'campsBuits':
                echo "<div class='error'><p>Els camps no poden estar buits</p></div>";
                break;
            case 'passwordError':
                echo "<div class='error'><p>La contrasenya és incorrecte</p></div>";
                break;  
            case 'correuError':
                echo "<div class='error'><p>El correu és incorrecte</p></div>";
                break;
            case 'ConnexioFallida':
                echo "<div class='error'><p>No s'ha pogut connectar a la base de dades</p></div>";
                break;
            default:
                echo "";
                break;
        }
    }
    else{
        echo "";
    }
?>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>
</html>