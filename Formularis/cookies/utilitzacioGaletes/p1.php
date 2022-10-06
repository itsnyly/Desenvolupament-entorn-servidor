<?php
if( !isset($_COOKIE["laMevaCookie"]))  { 
    //Si no s'ha creat la cookie, la creem
    setcookie ("laMevaCookie", "100"); 
}
else{

    setcookie("laMevaCookie", "101");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primera Pàgina</title>
</head>

<body>
    <h1>Primera Pàgina</h1>
</body>
</html>