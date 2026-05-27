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

        $botDir = __DIR__ . "\\bot\\";
        $sqlris="SELECT * FROM `risultato`";
        $res = $conn->query($sqlris);
        $ndb = '-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 27, 2026 alle 09:31
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scoremaps`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `risultato`
--

CREATE TABLE `risultato` (
  `id` int(11) NOT NULL,
  `id_squadra1` int(11) NOT NULL,
  `id_squadra2` int(11) NOT NULL,
  `punteggio_sq1` int(11) NOT NULL,
  `punteggio_sq2` int(11) NOT NULL,
  `vincitore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `risultato`
--
-- risultato
INSERT INTO risultato (id, id_squadra1, id_squadra2, punteggio_sq1, punteggio_sq2, vincitore) VALUES ';
        while ($row = $res->fetch_assoc()) {
            $id    = $row['id'];
            $sq1   = $row['id_squadra1'];
            $sq2   = $row['id_squadra2'];
            $p1    = $row['punteggio_sq1'];
            $p2    = $row['punteggio_sq2'];
            $vinc  = $row['vincitore'];
            $ndb .= "($id, $sq1, $sq2, $p1, $p2, $vinc),\n";
        }
        $ndb .='--\n
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `risultato`
--
ALTER TABLE `risultato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_squadra1` (`id_squadra1`),
  ADD KEY `id_squadra2` (`id_squadra2`),
  ADD KEY `vincitore` (`vincitore`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `risultato`
--
ALTER TABLE `risultato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=757;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `risultato`
--
ALTER TABLE `risultato`
  ADD CONSTRAINT `risultato_ibfk_1` FOREIGN KEY (`id_squadra1`) REFERENCES `squadra` (`id`),
  ADD CONSTRAINT `risultato_ibfk_2` FOREIGN KEY (`id_squadra2`) REFERENCES `squadra` (`id`),
  ADD CONSTRAINT `risultato_ibfk_3` FOREIGN KEY (`vincitore`) REFERENCES `squadra` (`id`);
  COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
';
        file_put_contents($botDir . "risultato.sql", $ndb);

    }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: system-ui, sans-serif;
            background: #f4f4f2;
            color: #1a1a1a;
            min-height: 100vh;
            padding: 2rem;
        }

        .panel {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #ddd;
        }

        .header i { font-size: 22px; color: #666; }
        .header h1 { font-size: 20px; font-weight: 500; }

        .section-label {
            font-size: 11px;
            font-weight: 600;
            color: #999;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .bots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-bottom: 2rem;
        }

        .bot-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            cursor: pointer;
        }

        .bot-card button {
            all: unset;
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 100%;
            cursor: pointer;
        }

        .bot-card:hover { background: #f9f9f9; border-color: #bbb; }
        .bot-card:active { transform: scale(0.98); }

        .icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .ic-basket { background: #E6F1FB; color: #185FA5; }
        .ic-volley { background: #E1F5EE; color: #0F6E56; }
        .ic-rugby  { background: #FAECE7; color: #993C1D; }

        .bot-name { font-size: 13px; font-weight: 500; color: #1a1a1a; line-height: 1.3; }
        .bot-sub  { font-size: 11px; color: #aaa; }

        textarea {
            width: 100%;
            height: 220px;
            background: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px 14px;
            font-family: monospace;
            font-size: 13px;
            color: #1a1a1a;
            resize: vertical;
            outline: none;
            margin-bottom: 1rem;
        }

        textarea:focus { border-color: #aaa; }

        .footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .success-msg {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #0F6E56;
            background: #E1F5EE;
            border: 1px solid #9FE1CB;
            border-radius: 8px;
            padding: 6px 12px;
        }

        .send-btn {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 20px;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            cursor: pointer;
        }

        .send-btn:hover { background: #f4f4f2; }
        .send-btn:active { transform: scale(0.98); }
    </style>
</head>
<body>
    <div class="panel">
        <div class="header">
            <i class="ti ti-shield-lock"></i>
            <h1>Pannello admin</h1>
        </div>

        <form method="POST">
            <p class="section-label">Avvia bot</p>
            <div class="bots-grid">
                <div class="bot-card">
                    <button type="submit" name="use_bot_bm">
                        <div class="icon-wrap ic-basket"><i class="ti ti-ball-basketball"></i></div>
                        <div class="bot-name">Basket maschile</div>
                        <div class="bot-sub">bot-bsk-m</div>
                    </button>
                </div>
                <div class="bot-card">
                    <button type="submit" name="use_bot_bf">
                        <div class="icon-wrap ic-basket"><i class="ti ti-ball-basketball"></i></div>
                        <div class="bot-name">Basket femminile</div>
                        <div class="bot-sub">bot-bsk-f</div>
                    </button>
                </div>
                <div class="bot-card">
                    <button type="submit" name="use_bot_pm">
                        <div class="icon-wrap ic-volley"><i class="ti ti-ball-volleyball"></i></div>
                        <div class="bot-name">Pallavolo maschile</div>
                        <div class="bot-sub">bot-plv-m</div>
                    </button>
                </div>
                <div class="bot-card">
                    <button type="submit" name="use_bot_pf">
                        <div class="icon-wrap ic-volley"><i class="ti ti-ball-volleyball"></i></div>
                        <div class="bot-name">Pallavolo femminile</div>
                        <div class="bot-sub">bot-plv-f</div>
                    </button>
                </div>
                <div class="bot-card">
                    <button type="submit" name="use_bot_rm">
                        <div class="icon-wrap ic-rugby"><i class="ti ti-ball-american-football"></i></div>
                        <div class="bot-name">Rugby maschile</div>
                        <div class="bot-sub">bot-rgy-m</div>
                    </button>
                </div>
            </div>

            <p class="section-label">Output SQL</p>
            <textarea name="textarea" rows="20"><?php echo htmlspecialchars($sqlOutput); ?></textarea>

            <div class="footer-row">
                <?php if ($messaggio): ?>
                    <span class="success-msg">
                        <i class="ti ti-circle-check"></i>
                        <?php echo $messaggio; ?>
                    </span>
                <?php else: ?>
                    <span></span>
                <?php endif; ?>
                <button type="submit" name="invia" class="send-btn">
                    <i class="ti ti-send"></i>
                    Invia query
                </button>
            </div>
        </form>
    </div>
</body>
</html>