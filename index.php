<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameSpark</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php';?>

    <main class="main">
       <?php
// ---------- Instellingen: pas deze aan op jouw omgeving ----------
const DB_HOST   = 'localhost';
const DB_NAME   = 'jouw_database';   // naam van de database in phpMyAdmin
const DB_USER   = 'root';
const DB_PASS   = '';
const DB_TABLE  = 'games';           // naam van de tabel met de games
const UPLOAD_DIR = 'uploads/';       // map waar afbeeldingen staan
const ADD_PAGE  = 'toevoegen.php';   // pagina met je formulier
const EDIT_PAGE = 'bewerken.php';    // ?id=... wordt toegevoegd
const DEL_PAGE  = 'verwijderen.php'; // ?id=... wordt toegevoegd
// -----------------------------------------------------------------

function e(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

$platforms = ['pc' => 'PC', 'playstation' => 'PlayStation', 'nintendo' => 'Nintendo', 'xbox' => 'Xbox'];
$statuses  = [
    'wishlist'   => 'Wishlist',
    'inbezit'    => 'In bezit',
    'speeltnu'   => 'Speel ik nu',
    'uitgespeeld' => 'Uitgespeeld',
];

$games = [];
$error = null;
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $games = $pdo->query('SELECT * FROM `' . DB_TABLE . '` ORDER BY created_at DESC, id DESC')->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    $error = 'Kan de games niet laden. Controleer de databasegegevens bovenin index.php.';
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mijn games</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrap">
  <h1>Mijn games</h1>

  <a class="add-btn" href="<?= e(ADD_PAGE) ?>">+ Game toevoegen</a>

  <?php if ($error): ?>
    <div class="error"><?= e($error) ?></div>
  <?php elseif (!$games): ?>
    <div class="empty">Nog geen games toegevoegd.</div>
  <?php else: ?>
    <ul class="list">
      <?php foreach ($games as $g):
        $platformKey = strtolower((string)$g['platform']);
        $platform = $platforms[$platformKey] ?? ucfirst($platformKey);
        $genre    = ucfirst((string)$g['genre']);
        $statusKey = strtolower((string)$g['status']);
        $status   = $statuses[$statusKey] ?? ucfirst($statusKey);
        $rating   = max(0, min(5, (int)$g['rating']));
        $release  = $g['release_date'] ? date('d-m-Y', strtotime($g['release_date'])) : '';
        $img      = trim((string)($g['afbeelding'] ?? ''));
      ?>
      <li class="game">
        <div class="thumb">
          <?php if ($img !== ''): ?>
            <img src="<?= e(UPLOAD_DIR . basename($img)) ?>" alt="<?= e($g['game_name']) ?>">
          <?php else: ?>
            🎮
          <?php endif; ?>
        </div>

        <div class="info">
          <h2 class="name"><?= e($g['game_name']) ?></h2>
          <div class="meta">
            <?= e($platform) ?> · <?= e($genre) ?><?= $release ? ' · ' . e($release) : '' ?>
          </div>
          <div class="row">
            <span class="stars" aria-label="Beoordeling <?= $rating ?> van 5">
              <?= str_repeat('★', $rating) ?><span class="off"><?= str_repeat('★', 5 - $rating) ?></span>
            </span>
            <span class="badge <?= e($statusKey) ?>"><?= e($status) ?></span>
          </div>
          <?php if (!empty($g['notitie'])): ?>
            <div class="note"><?= e($g['notitie']) ?></div>
          <?php endif; ?>
        </div>

        <div class="actions">
          <a class="icon" title="Bewerken" href="<?= e(EDIT_PAGE) ?>?id=<?= (int)$g['id'] ?>">
            <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zm17.71-10.21a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
          </a>
          <a class="icon del" title="Verwijderen" href="<?= e(DEL_PAGE) ?>?id=<?= (int)$g['id'] ?>"
             onclick="return confirm('Weet je zeker dat je deze game wilt verwijderen?');">
            <svg viewBox="0 0 24 24"><path d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
          </a>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>
</body>
</html>
    </main>

    <?php include 'footer.php';?>
    
</body>
</html>