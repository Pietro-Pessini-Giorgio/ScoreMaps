<?php 
    include "db_connect.php";
    $dat1=$_GET['dat'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="sign-in2.php" method="post">
        <p>nome</p>
        <input type="text" name="nom" maxlength="100" placeholder="mario">
        <br>
        <p>cognome</p>
        <input type="text" name="cogn" maxlength="100" placeholder="rossi">
        <br>
        <p>email</p>
        <input type="text" name="email" maxlength="256" placeholder="rossi@gmail.com">
        <br>
        <p>password</p>
        <input type="text" name="pass" placeholder="viva_ilBasket123?">
        <hr>
        <?php 
            if($dat1==1){
                echo '<p>la password deve essere di almeno 8 caratteri ed avere un numero una, maiuscola e un carattere speciale</p>';
            }else{
                if($dat1==2){
                    echo '<p>l\'email deve contenere la @ e </p>';
                }else{
                    echo '<p></p>';
                }
            }
        ?>
        <button type="submit">Accedi</button>
        
    </form>
    <div class="options">
        <a href="http://localhost/ScoreMaps/ScoreMaps/login.php?dat=0">effetua il login</a>
    </div>
</body>
</html>
