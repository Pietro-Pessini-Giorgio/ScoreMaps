<?php 
include "db_connect.php";

$dat1 = $_GET['dat'] ?? 0;
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registration.css">
    <title>Login - ScoreMaps</title>
</head>

<body>
    <div class="page-wrapper">
        <a class="brand" href="homepage.php">Score<span>Maps</span></a>

        <div class="auth-card">
            <h1>Acc<span>edi</span></h1>
            <p class="subtitle">al tuo account</p>

            <form action="login2.php" method="post">
                <div class="form-group">
                    <p>Email</p>
                    <input type="text" name="email" placeholder="mario@gmail.com" required>
                </div>

                <div class="form-group">
                    <p>Password</p>
                    <input type="password" name="pass" placeholder="viva_ilBasket123?" required>
                </div>

                <hr>

                <?php
                    if ($dat1 == 1) {
                        echo '<div class="msg-error">Password o email errati — ricontrolla o registrati.</div>';
                    }
                ?>

                <button type="submit">Accedi</button>
            </form>

            <div class="options">
                Non hai un account? <a href="sign-in.php?dat=0">Registrati</a>
            </div>
        </div>
    </div>
</body>
</html>