<?php 
    //include connection
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
    <form action="sign-in.php" method="post">
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
            if($dat1=1){
                echo '<p>la password deve almeno contenere un numero una maiuscola e un carattere speciale</p>';
            }else{
                if($dat1=2){
                    echo '<p>l\'email deve contenere la @ e </p>';
                }else{
                    echo '<p></p>';
                }
            }
        ?>
        <button type="submit">Accedi</button>
        
    </form>
    <div class="options">
        <a href="login.php">effetua il login</a>
    </div>
</body>
</html>
<?php
    $nom=$_POST["nom"];
    $cogn=$_POST["cogn"];
    $pass=$_POST["pass"];
    $email=$_POST["email"];
    
    $nom=trim($nom);
    $nom=strtolower($nom);
    $nom=ucfirst($nom);
    $cogn=trim($cogn);
    $cogn=strtolower($cogn);
    $cogn=ucfirst($cogn);
    if(preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i",$pass)){
        $url="http://localhost/ScoreMaps/ScoreMaps/login.php?dat=2";
        header('Location: '.$url);
    }else{
        if(preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/",$pass)){
            $url="http://localhost/ScoreMaps/ScoreMaps/login.php?dat=1";
            header('Location: '.$url);
        }else{
            $email=trim($email);
            $pass=trim($pass);
            $pass=md5($pass);
            $sql = "INSERT INTO utenti (nome, cognome, password, admin,email)
            VALUES ('$nom', '$cogn', '$pass',0,'$email')";

            if($conn->query($sql)===TRUE){
                //$_SESSION["ut"]=$nom;
                //setcookie("usern", $nom, time() + (86400 * 5), "/");
                //$url="http://localhost/ScoreMaps/ScoreMaps/index.php";
                //header('Location: '.$url);
                //die();
                echo "riuscita";
            }else{
                echo "<br>";
                echo "connesione fallita".$conn->error;
            }
        } 
    }
    $conn->close();
?>