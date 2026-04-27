<?php
include("db_connect.php");

// Funzione: ultimi 10 risultati per sport
function getUltimi($conn, $id_sport) {
    $res = $conn->query("
        SELECT r.id, r.punteggio_sq1, r.punteggio_sq2,
            s1.nome AS nome1, s1.logo AS logo1,
            s2.nome AS nome2, s2.logo AS logo2,
            sv.nome AS vincitore_nome
        FROM risultato r
        JOIN squadra s1 ON s1.id = r.id_squadra1
        JOIN squadra s2 ON s2.id = r.id_squadra2
        JOIN squadra sv ON sv.id = r.vincitore
        WHERE s1.id_sport = $id_sport AND s2.id_sport = $id_sport
        ORDER BY r.id DESC
        LIMIT 10
    ");
    $rows = [];
    while ($row = $res->fetch_assoc()) $rows[] = $row;
    return $rows;
}

// Funzione: classifica per sport
function getClassifica($conn, $id_sport) {
    $res = $conn->query("
        SELECT s.id, s.nome, s.logo,
            COUNT(r.vincitore) AS vittorie,
            (SELECT COUNT(*) FROM risultato WHERE (id_squadra1 = s.id OR id_squadra2 = s.id)) AS partite
        FROM squadra s
        LEFT JOIN risultato r ON r.vincitore = s.id
        WHERE s.id_sport = $id_sport
        GROUP BY s.id
        ORDER BY vittorie DESC
    ");
    $rows = [];
    while ($row = $res->fetch_assoc()) $rows[] = $row;
    return $rows;
}

// Dati Basket (id_sport = 1)
$ultimi_basket     = getUltimi($conn, 1);
$classifica_basket = getClassifica($conn, 1);

// Dati Pallavolo (id_sport = 2)
$ultimi_volley     = getUltimi($conn, 2);
$classifica_volley = getClassifica($conn, 2);

// Dati Basket Femminile (id_sport = 3)
$ultimi_basket_f     = getUltimi($conn, 3);
$classifica_basket_f = getClassifica($conn, 3);

// Statistiche generali
$totPartite = $conn->query("SELECT COUNT(*) AS tot FROM risultato")->fetch_assoc()['tot'];
$totSport   = $conn->query("SELECT COUNT(*) AS tot FROM sport")->fetch_assoc()['tot'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreMaps – Sport Italiani</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<!-- HEADER -->
<header>
    <div class="header-inner">
        <div class="logo-area">
            <div class="logo-ball">🏆</div>
            <div class="logo-text">Score<span>Maps</span></div>
        </div>
        <nav>
            <a href="#" onclick="showSport('basket')">🏀 Basket</a>
            <a href="#" onclick="showSport('volley')" class="volley">🏐 Pallavolo</a>
            <a href="#" onclick="showSport('basket-f')" class="basket-f">🏀 Basket F</a>
        </nav>
    </div>
</header>

<!-- HERO -->
<div class="hero">
    <div class="hero-label">🇮🇹 Sport Italiani</div>
    <h1>Tutti i<em>Risultati</em></h1>
    <div class="hero-stats">
        <div class="hstat">
            <div class="hstat-num"><?= $totPartite ?></div>
            <div class="hstat-label">Partite totali</div>
        </div>
        <div class="hstat">
            <div class="hstat-num"><?= $totSport ?></div>
            <div class="hstat-label">Sport</div>
        </div>
    </div>
</div>

<!-- TAB PILLS -->
<div class="sport-tabs">
    <div class="sport-pill basket active" onclick="showSport('basket')">🏀 Basket</div>
    <div class="sport-pill volley" onclick="showSport('volley')">🏐 Pallavolo Femminile</div>
    <div class="sport-pill basket-f" onclick="showSport('basket-f')">🏀 Basket Femminile</div>
</div>

<!-- ══════════ BASKET ══════════ -->
<div class="sport-section active" id="section-basket">
<div class="main">

    <div>
        <div class="section-title basket">Ultimi Risultati – Basket</div>
        <div class="risultati">
            <?php foreach ($ultimi_basket as $i => $m):
                $win1 = ($m['vincitore_nome'] === $m['nome1']);
                $win2 = ($m['vincitore_nome'] === $m['nome2']);
            ?>
            <div class="match-card basket" style="animation-delay:<?= $i*.06 ?>s">
                <div class="team">
                    <?php if (file_exists($m['logo1'])): ?>
                        <img class="team-logo" src="<?= htmlspecialchars($m['logo1']) ?>" alt="">
                    <?php else: ?>
                        <div class="team-logo-placeholder">🏀</div>
                    <?php endif; ?>
                    <div>
                        <div class="team-name"><?= htmlspecialchars($m['nome1']) ?></div>
                        <?php if ($win1): ?><div class="win-tag">✓ VITTORIA</div><?php endif; ?>
                    </div>
                </div>

                <div class="score-center">
                    <div class="score">
                        <span class="score-s1 <?= $win1?'winner':'' ?>"><?= $m['punteggio_sq1'] ?></span>
                        <span class="score-sep">–</span>
                        <span class="score-s2 <?= $win2?'winner':'' ?>"><?= $m['punteggio_sq2'] ?></span>
                    </div>
                    <div class="match-id">Partita #<?= $m['id'] ?></div>
                </div>

                <div class="team right">
                    <?php if (file_exists($m['logo2'])): ?>
                        <img class="team-logo" src="<?= htmlspecialchars($m['logo2']) ?>" alt="">
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

    <div class="sidebar">
        <div class="section-title basket">Classifica Basket</div>
        <div class="rank-card">
            <div class="rank-header">
                <div class="section-title basket" style="margin:0;font-size:1rem;">Per vittorie</div>
            </div>
            <?php
            $maxVic = $classifica_basket[0]['vittorie'] ?? 1;
            foreach ($classifica_basket as $pos => $sq):
                $pct  = $sq['partite'] > 0 ? round(($sq['vittorie']/$sq['partite'])*100) : 0;
                $barW = $maxVic > 0 ? round(($sq['vittorie']/$maxVic)*100) : 0;
                $pc   = match($pos){0=>'top1',1=>'top2',2=>'top3',default=>''};
            ?>
            <div class="rank-row">
                <div class="rank-pos <?= $pc ?>"><?= $pos+1 ?></div>
                <?php if (file_exists($sq['logo'])): ?>
                    <img class="rank-logo" src="<?= htmlspecialchars($sq['logo']) ?>" alt="">
                <?php else: ?>
                    <div class="rank-logo-placeholder">🏀</div>
                <?php endif; ?>
                <div class="rank-nome" title="<?= htmlspecialchars($sq['nome']) ?>"><?= htmlspecialchars($sq['nome']) ?></div>
                <div class="rank-vic">
                    <div class="rank-vic-num basket"><?= $sq['vittorie'] ?></div>
                    <div class="rank-vic-label">Vinte</div>
                </div>
            </div>
            <div class="win-bar-wrap">
                <div class="win-bar-bg"><div class="win-bar-fill basket" style="width:<?= $barW ?>%"></div></div>
                <div class="win-pct"><?= $pct ?>%</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
</div>

<!-- ══════════ PALLAVOLO ══════════ -->
<div class="sport-section" id="section-volley">
<div class="main">

    <div>
        <div class="section-title volley">Ultimi Risultati – Pallavolo Femminile</div>
        <div class="risultati">
            <?php foreach ($ultimi_volley as $i => $m):
                $win1 = ($m['vincitore_nome'] === $m['nome1']);
                $win2 = ($m['vincitore_nome'] === $m['nome2']);
            ?>
            <div class="match-card volley" style="animation-delay:<?= $i*.06 ?>s">
                <div class="team">
                    <?php if (file_exists($m['logo1'])): ?>
                        <img class="team-logo" src="<?= htmlspecialchars($m['logo1']) ?>" alt="">
                    <?php else: ?>
                        <div class="team-logo-placeholder">🏐</div>
                    <?php endif; ?>
                    <div>
                        <div class="team-name"><?= htmlspecialchars($m['nome1']) ?></div>
                        <?php if ($win1): ?><div class="win-tag">✓ VITTORIA</div><?php endif; ?>
                    </div>
                </div>

                <div class="score-center">
                    <div class="score">
                        <span class="score-s1 <?= $win1?'winner':'' ?>"><?= $m['punteggio_sq1'] ?></span>
                        <span class="score-sep">–</span>
                        <span class="score-s2 <?= $win2?'winner':'' ?>"><?= $m['punteggio_sq2'] ?></span>
                    </div>
                    <div class="match-id">Set &nbsp;·&nbsp; Partita #<?= $m['id'] ?></div>
                </div>

                <div class="team right">
                    <?php if (file_exists($m['logo2'])): ?>
                        <img class="team-logo" src="<?= htmlspecialchars($m['logo2']) ?>" alt="">
                    <?php else: ?>
                        <div class="team-logo-placeholder">🏐</div>
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

    <div class="sidebar">
        <div class="section-title volley">Classifica Pallavolo</div>
        <div class="rank-card">
            <div class="rank-header">
                <div class="section-title volley" style="margin:0;font-size:1rem;">Per vittorie</div>
            </div>
            <?php
            $maxVic = $classifica_volley[0]['vittorie'] ?? 1;
            foreach ($classifica_volley as $pos => $sq):
                $pct  = $sq['partite'] > 0 ? round(($sq['vittorie']/$sq['partite'])*100) : 0;
                $barW = $maxVic > 0 ? round(($sq['vittorie']/$maxVic)*100) : 0;
                $pc   = match($pos){0=>'top1',1=>'top2',2=>'top3',default=>''};
            ?>
            <div class="rank-row">
                <div class="rank-pos <?= $pc ?>"><?= $pos+1 ?></div>
                <?php if (file_exists($sq['logo'])): ?>
                    <img class="rank-logo" src="<?= htmlspecialchars($sq['logo']) ?>" alt="">
                <?php else: ?>
                    <div class="rank-logo-placeholder">🏐</div>
                <?php endif; ?>
                <div class="rank-nome" title="<?= htmlspecialchars($sq['nome']) ?>"><?= htmlspecialchars($sq['nome']) ?></div>
                <div class="rank-vic">
                    <div class="rank-vic-num volley"><?= $sq['vittorie'] ?></div>
                    <div class="rank-vic-label">Vinte</div>
                </div>
            </div>
            <div class="win-bar-wrap">
                <div class="win-bar-bg"><div class="win-bar-fill volley" style="width:<?= $barW ?>%"></div></div>
                <div class="win-pct"><?= $pct ?>%</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
</div>

<!-- ══════════ BASKET FEMMINILE ══════════ -->
<div class="sport-section" id="section-basket-f">
<div class="main">

    <div>
        <div class="section-title basket-f">Ultimi Risultati – Basket Femminile</div>
        <div class="risultati">
            <?php foreach ($ultimi_basket_f as $i => $m):
                $win1 = ($m['vincitore_nome'] === $m['nome1']);
                $win2 = ($m['vincitore_nome'] === $m['nome2']);
            ?>
            <div class="match-card basket-f" style="animation-delay:<?= $i*.06 ?>s">
                <div class="team">
                    <?php if (file_exists($m['logo1'])): ?>
                        <img class="team-logo" src="<?= htmlspecialchars($m['logo1']) ?>" alt="">
                    <?php else: ?>
                        <div class="team-logo-placeholder">🏀</div>
                    <?php endif; ?>
                    <div>
                        <div class="team-name"><?= htmlspecialchars($m['nome1']) ?></div>
                        <?php if ($win1): ?><div class="win-tag">✓ VITTORIA</div><?php endif; ?>
                    </div>
                </div>

                <div class="score-center">
                    <div class="score">
                        <span class="score-s1 <?= $win1?'winner basket-f':'' ?>"><?= $m['punteggio_sq1'] ?></span>
                        <span class="score-sep">–</span>
                        <span class="score-s2 <?= $win2?'winner basket-f':'' ?>"><?= $m['punteggio_sq2'] ?></span>
                    </div>
                    <div class="match-id">Partita #<?= $m['id'] ?></div>
                </div>

                <div class="team right">
                    <?php if (file_exists($m['logo2'])): ?>
                        <img class="team-logo" src="<?= htmlspecialchars($m['logo2']) ?>" alt="">
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

    <div class="sidebar">
        <div class="section-title basket-f">Classifica Basket Femminile</div>
        <div class="rank-card">
            <div class="rank-header">
                <div class="section-title basket-f" style="margin:0;font-size:1rem;">Per vittorie</div>
            </div>
            <?php
            $maxVic = $classifica_basket_f[0]['vittorie'] ?? 1;
            foreach ($classifica_basket_f as $pos => $sq):
                $pct  = $sq['partite'] > 0 ? round(($sq['vittorie']/$sq['partite'])*100) : 0;
                $barW = $maxVic > 0 ? round(($sq['vittorie']/$maxVic)*100) : 0;
                $pc   = match($pos){0=>'top1',1=>'top2',2=>'top3',default=>''};
            ?>
            <div class="rank-row">
                <div class="rank-pos <?= $pc ?>"><?= $pos+1 ?></div>
                <?php if (file_exists($sq['logo'])): ?>
                    <img class="rank-logo" src="<?= htmlspecialchars($sq['logo']) ?>" alt="">
                <?php else: ?>
                    <div class="rank-logo-placeholder">🏀</div>
                <?php endif; ?>
                <div class="rank-nome" title="<?= htmlspecialchars($sq['nome']) ?>"><?= htmlspecialchars($sq['nome']) ?></div>
                <div class="rank-vic">
                    <div class="rank-vic-num basket-f"><?= $sq['vittorie'] ?></div>
                    <div class="rank-vic-label">Vinte</div>
                </div>
            </div>
            <div class="win-bar-wrap">
                <div class="win-bar-bg"><div class="win-bar-fill basket-f" style="width:<?= $barW ?>%"></div></div>
                <div class="win-pct"><?= $pct ?>%</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
</div>

<footer>
    &copy; <?= date('Y') ?> ScoreMaps &nbsp;·&nbsp; 🏀 Basket &amp; 🏐 Pallavolo &amp; 🏀 Basket Femminile
</footer>

<script>
function showSport(sport) {
    document.querySelectorAll('.sport-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.sport-pill').forEach(p => p.classList.remove('active'));
    document.getElementById('section-' + sport).classList.add('active');
    document.querySelector('.sport-pill.' + sport).classList.add('active');
}
</script>

</body>
</html>