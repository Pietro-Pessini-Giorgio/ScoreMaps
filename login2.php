<?php
session_start();

include "db_connect.php";

$email = $_POST["email"] ?? "";
$pass = $_POST["pass"] ?? "";

<<<<<<< HEAD
=======
<<<<<<< Updated upstream
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
=======
>>>>>>> bot
$email = trim($email);
$pass = trim($pass);
$pass = md5($pass);

<<<<<<< HEAD
$sql = "SELECT nome, cognome 
=======
$sql = "SELECT , cognome 
>>>>>>> bot
        FROM utenti
        WHERE email = '$email' 
        AND password = '$pass'";

$resul = $conn->query($sql);

if ($resul && $resul->num_rows > 0) {
    $row = $resul->fetch_assoc();

    $_SESSION["nome"] = $row["nome"];
    $_SESSION["cognome"] = $row["cognome"];

    header("Location: homepage.php");
    exit;
} else {
    header("Location: login.php?dat=1");
    exit;
}

$conn->close();
<<<<<<< HEAD
=======
>>>>>>> Stashed changes
>>>>>>> bot
?>