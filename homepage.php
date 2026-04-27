<?php
include("db_connect.php");

// Classifica: vittorie per squadra
$classifica = [];
$res = $conn->query("
    SELECT s.id, s.nome, s.logo,
        COUNT(r.vincitore) AS vittorie,
        (SELECT COUNT(*) FROM risultato WHERE id_squadra1 = s.id OR id_squadra2 = s.id) AS partite
    FROM squadra s
    LEFT JOIN risultato r ON r.vincitore = s.id
    GROUP BY s.id
    ORDER BY vittorie DESC
");
while ($row = $res->fetch_assoc()) {
    $classifica[] = $row;
}

// Ultimi 10 risultati
$ultimi = [];
$res = $conn->query("
    SELECT r.id, r.punteggio_sq1, r.punteggio_sq2,
        s1.nome AS nome1, s1.logo AS logo1,
        s2.nome AS nome2, s2.logo AS logo2,
        sv.nome AS vincitore_nome
    FROM risultato r
    JOIN squadra s1 ON s1.id = r.id_squadra1
    JOIN squadra s2 ON s2.id = r.id_squadra2
    JOIN squadra sv ON sv.id = r.vincitore
    ORDER BY r.id DESC
    LIMIT 10
");
while ($row = $res->fetch_assoc()) {
    $ultimi[] = $row;
}

// Statistiche generali
$totPartite = $conn->query("SELECT COUNT(*) AS tot FROM risultato")->fetch_assoc()['tot'];
$totSquadre = $conn->query("SELECT COUNT(*) AS tot FROM squadra")->fetch_assoc()['tot'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreMaps – Basket Italiano</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        
    </style>
</head>
<body>

<!-- HEADER -->
<header>
    <div class="header-inner">
        <div class="logo-area">
            <div class="logo-ball">🏀</div>
            <div class="logo-text">Score<span>Maps</span></div>
        </div>
        <nav>
            <a href="#risultati">Risultati</a>
            <a href="#classifica">Classifica</a>
            <a href="login.php?dat=0">Login</a>
        </nav>
    </div>
</header>

<!-- HERO -->
<div class="hero">
    <div class="hero-label">🏀 Lega Basket Italia</div>
    <h1>Tutti i<em>Risultati</em></h1>
    <div class="hero-stats">
        <div class="hstat">
            <div class="hstat-num"><?= $totPartite ?></div>
            <div class="hstat-label">Partite giocate</div>
        </div>
        <div class="hstat">
            <div class="hstat-num"><?= $totSquadre ?></div>
            <div class="hstat-label">Squadre</div>
        </div>
        <div class="hstat">
            <div class="hstat-num"><?= count($classifica) > 0 ? htmlspecialchars($classifica[0]['nome']) : '—' ?></div>
            <div class="hstat-label">1ª in classifica</div>
        </div>
    </div>
</div>

<!-- MAIN GRID -->
<div class="main">

    <!-- RISULTATI -->
    <div>
        <div class="section-title" id="risultati">Ultimi Risultati</div>
        <div class="risultati">
            <?php foreach ($ultimi as $i => $m):
                $win1 = ($m['vincitore_nome'] === $m['nome1']);
                $win2 = ($m['vincitore_nome'] === $m['nome2']);
            ?>
            <div class="match-card" style="animation-delay: <?= $i * .06 ?>s">

                <!-- Squadra 1 -->
                <div class="team">
                    <?php if (file_exists($m['logo1'])): ?>
                        <img class="team-logo" src="<?= htmlspecialchars($m['logo1']) ?>" alt="<?= htmlspecialchars($m['nome1']) ?>">
                    <?php else: ?>
                        <div class="team-logo-placeholder">🏀</div>
                    <?php endif; ?>
                    <div>
                        <div class="team-name"><?= htmlspecialchars($m['nome1']) ?></div>
                        <?php if ($win1): ?><div class="win-tag">✓ VITTORIA</div><?php endif; ?>
                    </div>
                </div>

                <!-- Score -->
                <div class="score-center">
                    <div class="score">
                        <span class="score-s1 <?= $win1 ? 'winner' : '' ?>"><?= $m['punteggio_sq1'] ?></span>
                        <span class="score-sep">–</span>
                        <span class="score-s2 <?= $win2 ? 'winner' : '' ?>"><?= $m['punteggio_sq2'] ?></span>
                    </div>
                    <div class="match-id">Partita #<?= $m['id'] ?></div>
                </div>

                <!-- Squadra 2 -->
                <div class="team right">
                    <?php if (file_exists($m['logo2'])): ?>
                        <img class="team-logo" src="<?= htmlspecialchars($m['logo2']) ?>" alt="<?= htmlspecialchars($m['nome2']) ?>">
                    <?php else: ?>
                        <div class="team-logo-placeholder">🏀</div>
                    <?php endif; ?>
                    <div>
                        <div class="team-name"><?= htmlspecialchars($m['nome2']) ?></div>
                        <?php if ($win2): ?><div class="win-tag">✓ VITTORIA</div><?php endif; ?>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- SIDEBAR CLASSIFICA -->
    <div class="sidebar" id="classifica">
        <div class="section-title">Classifica</div>
        <div class="rank-card">
            <div class="rank-header">
                <div class="section-title" style="margin:0; font-size:1rem;">Per vittorie</div>
            </div>

            <?php
            $maxVic = $classifica[0]['vittorie'] ?? 1;
            foreach ($classifica as $pos => $sq):
                $pct = $sq['partite'] > 0 ? round(($sq['vittorie'] / $sq['partite']) * 100) : 0;
                $barW = $maxVic > 0 ? round(($sq['vittorie'] / $maxVic) * 100) : 0;
                $posClass = match($pos) { 0 => 'top1', 1 => 'top2', 2 => 'top3', default => '' };
            ?>
            <div class="rank-row">
                <div class="rank-pos <?= $posClass ?>"><?= $pos + 1 ?></div>

                <?php if (file_exists($sq['logo'])): ?>
                    <img class="rank-logo" src="<?= htmlspecialchars($sq['logo']) ?>" alt="<?= htmlspecialchars($sq['nome']) ?>">
                <?php else: ?>
                    <div class="rank-logo-placeholder">🏀</div>
                <?php endif; ?>

                <div class="rank-nome" title="<?= htmlspecialchars($sq['nome']) ?>"><?= htmlspecialchars($sq['nome']) ?></div>

                <div class="rank-vic">
                    <div class="rank-vic-num"><?= $sq['vittorie'] ?></div>
                    <div class="rank-vic-label">Vinte</div>
                </div>
            </div>
            <!-- Win % bar -->
            <div class="win-bar-wrap">
                <div class="win-bar-bg">
                    <div class="win-bar-fill" style="width: <?= $barW ?>%"></div>
                </div>
                <div class="win-pct"><?= $pct ?>%</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

<footer>
    &copy; <?= date('Y') ?> ScoreMaps – Lega Basket Italia &nbsp;·&nbsp; Tutti i diritti riservati
</footer>

</body>
</html>