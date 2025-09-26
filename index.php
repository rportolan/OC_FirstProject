<?php
require __DIR__ . '/vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();

require 'header.php';
require 'connexion.php';

$sql = "SELECT * FROM artwork ORDER BY artwork_id DESC";
$stmt = $connexion->prepare($sql); //ici, on prépare notre requête, pdo l'envoie au moteur MySQL qui se charge de trouver une réponse pour exécuter la requête sans prendre en compte les données injectées dans la requête pour éviter les injections SQL
$stmt->execute(); //c'est ici que les données sont insérées, ici la requête est statique mais des fois il faudra rentrer des données.
$oeuvres = $stmt->fetchAll(); //attention, fetchAll renvoie une valeur constamment donc on peut avoir un tableau vide...
?>
<div id="liste-oeuvres">
  <?php foreach ($oeuvres as $oeuvre): ?> 
    <article class="oeuvre">
      <a href="oeuvre.php?id=<?= htmlspecialchars($oeuvre['artwork_id']) ?>">
        <img src="<?= htmlspecialchars($oeuvre['artwork_img']) ?>" alt="<?= htmlspecialchars($oeuvre['artwork_title']) ?>">
        <h2><?= htmlspecialchars($oeuvre['artwork_title']) ?></h2>
        <p class="description"><?= htmlspecialchars($oeuvre['artwork_artist']) ?></p>
      </a>
    </article>
  <?php endforeach; ?>
</div>
<?php require 'footer.php'; ?>
