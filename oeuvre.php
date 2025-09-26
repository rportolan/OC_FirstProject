<?php
require __DIR__ . '/vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();
require 'connexion.php';

//Vérifier que l'id est bien un entier, qu'il existe et n'est pas inférieur à 1.
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header('Location: index.php', true, 302);
    exit;
}

$sql = "SELECT * FROM artwork WHERE artwork_id = :id";
$stmt = $connexion->prepare($sql); 
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //ici on insère les données : voir index.php
$stmt->execute();

$oeuvre = $stmt->fetch(); //pas de fecthAll (tableau vide), plus simple pour gérer nos erreurs 

if ($oeuvre === false) {
    header('Location: index.php', true, 302); //on redirige vers index.php si aucune oeuvre n'est trouvée
    exit;
}
//pourquoi mettre le require ici ?????
//Car il y a un header (en-tête) juste au dessus, lorsqu'une requête est envoyée(juste au-dessus de nous, nous avons une requête du style : "Si l'oeuvre n'existe pas en base de donnée, tu arrêtes de lire le contenu de cette page et tu rediriges vers la page index.php"), il y a deux parties : l'en-tête et le corp (c'est là où se trouve le HTML, JSON aussi...) fin bref, l'en-tête (header) s'exécute toujours en premier et ensuite le corp donc si on déclenche un header, alors il ne faut pas lire le corps, c'est donc pour cette raison qu'on ne mets jamais du HTML avant un header... => Sinon erreur de PHP... 
require 'header.php';
?>
<article id="detail-oeuvre">
  <div id="img-oeuvre">
      <img src="<?= htmlspecialchars($oeuvre['artwork_img']) ?>"
           alt="<?= htmlspecialchars($oeuvre['artwork_title']) ?>">
  </div>
  <div id="contenu-oeuvre">
      <h1><?= htmlspecialchars($oeuvre['artwork_title']) ?></h1>
      <p class="description"><?= htmlspecialchars($oeuvre['artwork_artist']) ?></p>
      <p class="description-complete">
           <?= nl2br(htmlspecialchars($oeuvre['artwork_desc'])) ?>
      </p>
      <form id="formDelete" action="supprimer.php" method="POST">
        <input type="hidden" name="id" value="<?= (int)$oeuvre['artwork_id'] ?>">
        <input type="submit" id="inputSupprimerOeuvre" value="Supprimer cet oeuvre" name="supprimerOeuvre"></input>
      </form>
      
  </div>
  
</article>
<?php require 'footer.php'; ?>
