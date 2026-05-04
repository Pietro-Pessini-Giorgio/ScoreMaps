<?php
    include "db_connect.php";

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
    if(preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i",$email)){
        if(preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/",$pass)){
            $email=trim($email);
            $pass=trim($pass);
            $pass=md5($pass);
            $sql = "INSERT INTO utenti (nome, cognome, password, admin,email)
            VALUES ('$nom', '$cogn', '$pass',0,'$email')";

            if($conn->query($sql)===TRUE){
                //setcookie("usern", $nom, time() + (86400 * 7), "/");
                $url="http://localhost/ScoreMaps/ScoreMaps/homepage.php";
                header('Location: '.$url);
                die();
            }else{
                echo "<br>";
                echo "connesione fallita".$conn->error;
            }
        }else{
            $url="http://localhost/ScoreMaps/ScoreMaps/sign-in.php?dat=1";
            header('Location: '.$url);
        }
    }else{
        $url="http://localhost/ScoreMaps/ScoreMaps/sign-in.php?dat=2";
        header('Location: '.$url); 
    }
    $conn->close();
?>