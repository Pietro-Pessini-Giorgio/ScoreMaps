<?php
session_start();
include "db_connect.php";

$email = trim($_POST["email"] ?? "");
$pass  = trim($_POST["pass"]  ?? "");
$pass  = md5($pass);

// Aggiunto "admin" e "email" nella SELECT
$sql  = "SELECT nome, cognome, email, admin FROM utenti WHERE email = '$email' AND password = '$pass';";
$resul = $conn->query($sql);

if ($resul && $resul->num_rows > 0) {
    $row = $resul->fetch_assoc();
    $_SESSION["nome"]    = $row["nome"];
    $_SESSION["cognome"] = $row["cognome"];
    $_SESSION["email"]   = $row["email"];
    $_SESSION["admin"]   = (bool)$row["admin"];
    header("Location: homepage.php");
} else {
    header("Location: login.php?dat=1");
}

$conn->close();
exit;
?>