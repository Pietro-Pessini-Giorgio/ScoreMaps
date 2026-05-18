<?php
session_start();
include "db_connect.php";

$email = trim($_POST["email"] ?? "");
$pass  = trim($_POST["pass"]  ?? "");
$pass  = md5($pass); // ⚠️ considera password_hash() in futuro

// Prepared statement per evitare SQL injection
$sql  = "SELECT nome, cognome FROM utenti WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $pass);
$stmt->execute();
$resul = $stmt->get_result();

if ($resul && $resul->num_rows > 0) {
    $row = $resul->fetch_assoc();
    $_SESSION["nome"]    = $row["nome"];
    $_SESSION["cognome"] = $row["cognome"];
    header("Location: homepage.php");
} else {
    header("Location: login.php?dat=1");
}

$stmt->close();
$conn->close();
exit;
?>