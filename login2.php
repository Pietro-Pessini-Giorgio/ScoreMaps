<?php
    include "db_connect.php";

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
        //setcookie("usern", $nom, time() + (86400 * 7), "/");
        $url="http://localhost/ScoreMaps/ScoreMaps/homepage.php";
        header('Location: '.$url);
        die();
    }else{
        $url="http://localhost/ScoreMaps/ScoreMaps/login.php?dat=1";
        header('Location: '.$url);
    }
    $conn->close();
?>