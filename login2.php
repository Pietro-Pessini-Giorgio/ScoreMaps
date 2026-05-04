<?php
session_start();

include "db_connect.php";

$email = $_POST["email"] ?? "";
$pass = $_POST["pass"] ?? "";

$email = trim($email);
$pass = trim($pass);
$pass = md5($pass);

$sql = "SELECT nome, cognome 
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
?>