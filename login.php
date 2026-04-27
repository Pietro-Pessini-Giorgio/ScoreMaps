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
    <form action="login.php" method="post">
        <p>email</p>
        <input type="text" name="email" maxlength="256" placeholder="mario@gmail.com">
        <br>
        <p>password</p>
        <input type="text" name="pass" placeholder="viva_ilBasket123?">
        <hr>
        <?php 
            if($dat1=1){
                echo "<script type='text/javascript'>alert('password o email errati prova a ricontrolarli oppure prova a registrari');</script>";
            }else{
                echo '<p></p>';
            }
        ?>
        <button type="submit">Accedi</button>
        
    </form>
    <div class="options">
        <a href="sign-in.php">effetua il login</a>
    </div>
</body>
</html>
<?php 
    $email=$_POST["email"];
    $pass=$_POST["pass"];

    $email=trim($email);
    $pass=trim($pass);
    $pass=md5($pass);

    $sql = "SELECT nome FROM utenti
    WHERE email LIKE '$email%' AND password LIKE '$pass%';";
    $resul=$conn->query($sql);
    if($resul->num_rows>0){
        $row = $resul->fetch_assoc();
        $nom=$row['nome'];
        //$_SESSION["ut"]=$nom;
        //setcookie("usern", $nom, time() + (86400 * 5), "/");
        $url="http://localhost/ScoreMaps/ScoreMaps/login.php?dat=0";
        //header('Location: '.$url);
        die();
    }else{
        $url="http://localhost/ScoreMaps/ScoreMaps/login.php?dat=1";
        header('Location: '.$url);
    }
    $conn->close();
?>