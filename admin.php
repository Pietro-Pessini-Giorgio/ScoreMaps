<?php
    include("db_connect.php");
    $sqlOutput = "";
    $messaggio = "";

    if (isset($_POST['use_bot_bm'])) {
        $scriptPath = __DIR__ . "\\bot\\bot-bsk-m.py";
        if (!file_exists($scriptPath)) {
            $sqlOutput = "file non trovato in: " . $scriptPath;
        } else {
            $cmd = "python " . escapeshellarg($scriptPath) . " 2>&1";
            $sqlOutput = shell_exec($cmd);

            if (is_null($sqlOutput)) {
                $sqlOutput = "ERRORE: shell_exec ha restituito NULL";
            } elseif (empty($sqlOutput)) {
                $sqlOutput = "ERRORE: nessun output dallo script";
            }
            $sqlOutput = $sqlOutput."\n";
        }
    }

    if (isset($_POST['use_bot_bf'])) {
        $scriptPath = __DIR__ . "\\bot\\bot-bsk-f.py";
        if (!file_exists($scriptPath)) {
            $sqlOutput = "file non trovato in: " . $scriptPath;
        } else {
            $cmd = "python " . escapeshellarg($scriptPath) . " 2>&1";
            $sqlOutput = shell_exec($cmd);

            if (is_null($sqlOutput)) {
                $sqlOutput = "ERRORE: shell_exec ha restituito NULL";
            } elseif (empty($sqlOutput)) {
                $sqlOutput = "ERRORE: nessun output dallo script";
            }
            $sqlOutput = $sqlOutput."\n";
        }
    }

    if (isset($_POST['use_bot_pf'])) {
        $scriptPath = __DIR__ . "\\bot\\bot-plv-f.py";
        if (!file_exists($scriptPath)) {
            $sqlOutput = "file non trovato in: " . $scriptPath;
        } else {
            $cmd = "python " . escapeshellarg($scriptPath) . " 2>&1";
            $sqlOutput = shell_exec($cmd);

            if (is_null($sqlOutput)) {
                $sqlOutput = "ERRORE: shell_exec ha restituito NULL";
            } elseif (empty($sqlOutput)) {
                $sqlOutput = "ERRORE: nessun output dallo script";
            }
            $sqlOutput = $sqlOutput."\n";
        }
    }

    if (isset($_POST['use_bot_rm'])) {
        $scriptPath = __DIR__ . "\\bot\\bot-rgy-m.py";
        if (!file_exists($scriptPath)) {
            $sqlOutput = "file non trovato in: " . $scriptPath;
        } else {
            $cmd = "python " . escapeshellarg($scriptPath) . " 2>&1";
            $sqlOutput = shell_exec($cmd);

            if (is_null($sqlOutput)) {
                $sqlOutput = "ERRORE: shell_exec ha restituito NULL";
            } elseif (empty($sqlOutput)) {
                $sqlOutput = "ERRORE: nessun output dallo script";
            }
            $sqlOutput = $sqlOutput."\n";
        }
    }

    if (isset($_POST['invia']) && !empty($_POST['textarea'])) {
        $sql = $_POST['textarea'];
        foreach (explode(";", $sql) as $stmt) {
            $stmt = trim($stmt);
            if (!empty($stmt)) {
                $conn->query($stmt);
            }
        }
        $messaggio = "INSERT eseguiti con successo!";
        $sqlOutput = $_POST['textarea'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pagina admin</title>
</head>
<body>
    <?php if ($messaggio): ?>
        <p style="color:green"><?php echo $messaggio; ?></p>
    <?php endif; ?>

    <form method="POST">
        <button type="submit" name="use_bot_bm">use bot bascket maschile</button> 
        <button type="submit" name="use_bot_bf">use bot basket femminile</button> 
        <button type="submit" name="use_bot_pm">use bot pallavolo maschile</button> 
        <button type="submit" name="use_bot_pf">use bot pallavolo femminile</button>
        <button type="submit" name="use_bot_rm">use bot rugby maschile</button>
        <br><br>
        <textarea name="textarea" rows="20" cols="80"><?php echo htmlspecialchars($sqlOutput); ?></textarea>
        <br><br>
        <button type="submit" name="invia">invia</button>
    </form>
</body>
</html>