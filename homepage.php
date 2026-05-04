<?php
session_start();

include("db_connect.php");

// Funzione: ultimi risultati per sport
function getUltimi($conn, $id_sport, $limit = 5) {
    $id_sport = (int)$id_sport;
    $limit = (int)$limit;

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
        LIMIT $limit
    ");

    $rows = [];

    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    return $rows;
}

// Funzione: classifica per sport
function getClassifica($conn, $id_sport) {
    $id_sport = (int)$id_sport;

    $res = $conn->query("
        SELECT s.id, s.nome, s.logo,
            COUNT(r.vincitore) AS vittorie,
            (
                SELECT COUNT(*) 
                FROM risultato 
                WHERE id_squadra1 = s.id OR id_squadra2 = s.id
            ) AS partite
        FROM squadra s
        LEFT JOIN risultato r ON r.vincitore = s.id
        WHERE s.id_sport = $id_sport
        GROUP BY s.id, s.nome, s.logo
        ORDER BY vittorie DESC, s.nome ASC
    ");

    $rows = [];

    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    return $rows;
}

// Homepage: ultimi 5 risultati per ogni sport
$ultimi_basket = getUltimi($conn, 1, 5);
$ultimi_volley = getUltimi($conn, 2, 5);
$ultimi_basket_f = getUltimi($conn, 3, 5);

// Sport selezionato: ultime 10 partite
$ultimi10_basket = getUltimi($conn, 1, 10);
$ultimi10_volley = getUltimi($conn, 2, 10);
$ultimi10_basket_f = getUltimi($conn, 3, 10);

// Classifiche
$classifica_basket = getClassifica($conn, 1);
$classifica_volley = getClassifica($conn, 2);
$classifica_basket_f = getClassifica($conn, 3);

// Statistiche generali
$totPartite = $conn->query("SELECT COUNT(*) AS tot FROM risultato")->fetch_assoc()['tot'] ?? 0;
$totSport = $conn->query("SELECT COUNT(*) AS tot FROM sport")->fetch_assoc()['tot'] ?? 0;

// Helper: risultati
function renderRisultati($ultimi, $sport) {
    foreach ($ultimi as $i => $m):
        $win1 = ($m['vincitore_nome'] === $m['nome1']);
        $win2 = ($m['vincitore_nome'] === $m['nome2']);

        $placeholder = ($sport === 'volley') ? '🏐' : '🏀';
        $label = ($sport === 'volley') ? "Set &nbsp;·&nbsp; Partita #{$m['id']}" : "Partita #{$m['id']}";
?>
        <div class="match-card <?= htmlspecialchars($sport) ?>" style="animation-delay: <?= $i * .06 ?>s">

            <div class="team">
                <?php if (!empty($m['logo1']) && file_exists($m['logo1'])): ?>
                    <img class="team-logo" src="<?= htmlspecialchars($m['logo1']) ?>" alt="<?= htmlspecialchars($m['nome1']) ?>">
                <?php else: ?>
                    <div class="team-logo-placeholder"><?= $placeholder ?></div>
                <?php endif; ?>

                <div>
                    <div class="team-name"><?= htmlspecialchars($m['nome1']) ?></div>
                    <?php if ($win1): ?>
                        <div class="win-tag">✓ Vittoria</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="score-center">
                <div class="score">
                    <span class="score-s1 <?= $win1 ? 'winner' : '' ?>">
                        <?= htmlspecialchars($m['punteggio_sq1']) ?>
                    </span>

                    <span class="score-sep">–</span>

                    <span class="score-s2 <?= $win2 ? 'winner' : '' ?>">
                        <?= htmlspecialchars($m['punteggio_sq2']) ?>
                    </span>
                </div>

                <div class="match-id"><?= $label ?></div>
            </div>

            <div class="team right">
                <?php if (!empty($m['logo2']) && file_exists($m['logo2'])): ?>
                    <img class="team-logo" src="<?= htmlspecialchars($m['logo2']) ?>" alt="<?= htmlspecialchars($m['nome2']) ?>">
                <?php else: ?>
                    <div class="team-logo-placeholder"><?= $placeholder ?></div>
                <?php endif; ?>

                <div>
                    <div class="team-name"><?= htmlspecialchars($m['nome2']) ?></div>
                    <?php if ($win2): ?>
                        <div class="win-tag">✓ Vittoria</div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
<?php
    endforeach;

    if (empty($ultimi)) {
        echo '<div class="empty-message">Nessun risultato disponibile.</div>';
    }
}

// Helper: classifica
function renderClassifica($classifica, $sport) {
    $maxVic = $classifica[0]['vittorie'] ?? 1;
    $placeholder = ($sport === 'volley') ? '🏐' : '🏀';

    foreach ($classifica as $pos => $sq):
        $vittorie = (int)$sq['vittorie'];
        $partite = (int)$sq['partite'];

        $pct = $partite > 0 ? round(($vittorie / $partite) * 100) : 0;
        $barW = $maxVic > 0 ? round(($vittorie / $maxVic) * 100) : 0;

        $pc = match($pos) {
            0 => 'top1',
            1 => 'top2',
            2 => 'top3',
            default => ''
        };
?>
        <div class="rank-row">
            <div class="rank-pos <?= $pc ?>"><?= $pos + 1 ?></div>

            <?php if (!empty($sq['logo']) && file_exists($sq['logo'])): ?>
                <img class="rank-logo" src="<?= htmlspecialchars($sq['logo']) ?>" alt="<?= htmlspecialchars($sq['nome']) ?>">
            <?php else: ?>
                <div class="rank-logo-placeholder"><?= $placeholder ?></div>
            <?php endif; ?>

            <div class="rank-nome" title="<?= htmlspecialchars($sq['nome']) ?>">
                <?= htmlspecialchars($sq['nome']) ?>
            </div>

            <div class="rank-vic">
                <div class="rank-vic-num <?= htmlspecialchars($sport) ?>">
                    <?= $vittorie ?>
                </div>
                <div class="rank-vic-label">Vinte</div>
            </div>
        </div>

        <div class="win-bar-wrap">
            <div class="win-bar-bg">
                <div class="win-bar-fill <?= htmlspecialchars($sport) ?>" style="width: <?= $barW ?>%"></div>
            </div>
            <div class="win-pct"><?= $pct ?>%</div>
        </div>
<?php
    endforeach;

    if (empty($classifica)) {
        echo '<div class="empty-message">Nessuna squadra disponibile.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreMaps – Sport Italiani</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css?v=50">
</head>

<body>

<header>
    <div class="header-inner">
        <div class="logo-area">
            <div class="logo-ball">🏆</div>
            <div class="logo-text">Score<span>Maps</span></div>
        </div>

        <div class="header-actions">
            <select class="sport-select" onchange="showSport(this.value)">
                <option value="home" selected>🏠 Home</option>
                <option value="basket">🏀 Basket Maschile</option>
                <option value="volley">🏐 Pallavolo Femminile</option>
                <option value="basketf">🏀 Basket Femminile</option>
            </select>

            <?php if (isset($_SESSION["nome"]) && isset($_SESSION["cognome"])): ?>
                <div class="user-area">
                    <div class="user-greeting">
                        Ciao <?= htmlspecialchars($_SESSION["nome"]) ?> <?= htmlspecialchars($_SESSION["cognome"]) ?>!
                    </div>

                    <a class="logout-btn" href="logout.php">Logout</a>
                </div>
            <?php else: ?>
                <a class="login-btn" href="login.php?dat=0">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<section class="hero">
    <div class="hero-label">🇮🇹 Sport Italiani</div>

    <h1>
        Tutti i
        <em>Risultati</em>
    </h1>

    <div class="hero-stats">
        <div class="hstat">
            <div class="hstat-num"><?= htmlspecialchars($totPartite) ?></div>
            <div class="hstat-label">Partite totali</div>
        </div>

        <div class="hstat">
            <div class="hstat-num"><?= htmlspecialchars($totSport) ?></div>
            <div class="hstat-label">Sport</div>
        </div>
    </div>
</section>

<!-- HOME: ultimi 5 risultati per ogni sport, senza classifica -->
<div id="home-view">

    <section class="sport-section-home">
        <div class="main no-sidebar">
            <div>
                <div class="section-title basket">Ultimi 5 Risultati – Basket Maschile</div>

                <div class="risultati">
                    <?php renderRisultati($ultimi_basket, 'basket'); ?>
                </div>
            </div>
        </div>
    </section>

    <section class="sport-section-home">
        <div class="main no-sidebar">
            <div>
                <div class="section-title volley">Ultimi 5 Risultati – Pallavolo Femminile</div>

                <div class="risultati">
                    <?php renderRisultati($ultimi_volley, 'volley'); ?>
                </div>
            </div>
        </div>
    </section>

    <section class="sport-section-home">
        <div class="main no-sidebar">
            <div>
                <div class="section-title basketf">Ultimi 5 Risultati – Basket Femminile</div>

                <div class="risultati">
                    <?php renderRisultati($ultimi_basket_f, 'basketf'); ?>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- DETTAGLIO SPORT: ultime 10 partite + classifica -->
<div id="sport-detail-view">

    <section class="sport-section-detail" id="section-basket">
        <div class="main">
            <div>
                <div class="section-title basket">Ultime 10 Partite – Basket Maschile</div>

                <div class="risultati">
                    <?php renderRisultati($ultimi10_basket, 'basket'); ?>
                </div>
            </div>

            <aside class="sidebar">
                <div class="section-title basket">Classifica Basket Maschile</div>

                <div class="rank-card">
                    <div class="rank-header">
                        <div class="section-title basket small-title">Per vittorie</div>
                    </div>

                    <?php renderClassifica($classifica_basket, 'basket'); ?>
                </div>
            </aside>
        </div>
    </section>

    <section class="sport-section-detail" id="section-volley">
        <div class="main">
            <div>
                <div class="section-title volley">Ultime 10 Partite – Pallavolo Femminile</div>

                <div class="risultati">
                    <?php renderRisultati($ultimi10_volley, 'volley'); ?>
                </div>
            </div>

            <aside class="sidebar">
                <div class="section-title volley">Classifica Pallavolo Femminile</div>

                <div class="rank-card">
                    <div class="rank-header">
                        <div class="section-title volley small-title">Per vittorie</div>
                    </div>

                    <?php renderClassifica($classifica_volley, 'volley'); ?>
                </div>
            </aside>
        </div>
    </section>

    <section class="sport-section-detail" id="section-basketf">
        <div class="main">
            <div>
                <div class="section-title basketf">Ultime 10 Partite – Basket Femminile</div>

                <div class="risultati">
                    <?php renderRisultati($ultimi10_basket_f, 'basketf'); ?>
                </div>
            </div>

            <aside class="sidebar">
                <div class="section-title basketf">Classifica Basket Femminile</div>

                <div class="rank-card">
                    <div class="rank-header">
                        <div class="section-title basketf small-title">Per vittorie</div>
                    </div>

                    <?php renderClassifica($classifica_basket_f, 'basketf'); ?>
                </div>
            </aside>
        </div>
    </section>

</div>

<footer>
    &copy; <?= date('Y') ?> ScoreMaps &nbsp;·&nbsp; 🏀 Basket Maschile &amp; 🏐 Pallavolo Femminile &amp; 🏀 Basket Femminile
</footer>

<script>
function showSport(sport) {
    const homeView = document.getElementById('home-view');
    const detailView = document.getElementById('sport-detail-view');
    const detailSections = document.querySelectorAll('.sport-section-detail');
    const select = document.querySelector('.sport-select');

    detailSections.forEach(section => {
        section.classList.remove('active');
    });

    if (sport === 'home') {
        homeView.style.display = 'block';
        detailView.style.display = 'none';
    } else {
        homeView.style.display = 'none';
        detailView.style.display = 'block';

        const section = document.getElementById('section-' + sport);

        if (section) {
            section.classList.add('active');
        }
    }

    if (select) {
        select.value = sport;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    showSport('home');
});
</script>

</body>
</html>