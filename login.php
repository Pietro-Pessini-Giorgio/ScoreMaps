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
    <form action="login2.php" method="post">
        <p>email</p>
        <input type="text" name="email" maxlength="256" placeholder="mario@gmail.com">
        <br>
        <p>password</p>
        <input type="text" name="pass" placeholder="viva_ilBasket123?">
        <hr>
        <?php 
            if($dat1==1){
                echo "<script type='text/javascript'>alert('password o email errati prova a ricontrolarli oppure prova a registrari');</script>";
            }else{
                echo '<p></p>';
            }
        ?>
        <button type="submit">Accedi</button>
        
    </form>
    <div class="options">
        <a href="sign-in.php?dat=0">registrarti</a>
    </div>
</body>
</html>