<?php 
    include "db_connect.php";
    $dat1=$_GET['dat'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registration.css">
    <title>Document</title>
</head>
<body>
    <div class="page-wrapper">
        <a class="brand" href="homepage.php">Score<span>Maps</span></a>
        <div class="auth-card">
            <h1>Regis<span>trati</span></h1>
            <p class="subtitle">crea il tuo account</p>
            <form action="sign-in2.php" method="post">
                <div class="form-group">
                    <p>Nome</p>
                    <input type="text" name="nom" maxlength="100" placeholder="Mario">
                </div>
                <div class="form-group">
                    <p>Cognome</p>
                    <input type="text" name="cogn" maxlength="100" placeholder="Rossi">
                </div>
                <div class="form-group">
                    <p>Email</p>
                    <input type="text" name="email" maxlength="256" placeholder="rossi@gmail.com">
                </div>
                <div class="form-group">
                    <p>Password</p>
                    <input type="text" name="pass" placeholder="viva_ilBasket123?">
                </div>
                <hr>
                <?php 
                if ($dat1 == 1){
                    echo'
                    <div class="msg-error">
                        La password deve essere di almeno 8 caratteri e contenere un numero, una maiuscola e un carattere speciale.
                    </div>
                    ';
                }else{
                    if ($dat1 == 2){
                        echo'
                        <div class="msg-error">
                            L\'email deve contenere la @ e un dominio valido.
                        </div>
                        ';
                    }
                }
                ?>
                <button type="submit">Registrati</button>
            </form>
            <div class="options">
                Hai già un account? <a href="login.php?dat=0">Effettua il login</a>
            </div>
        </div>
    </div>
</body>
</html>
