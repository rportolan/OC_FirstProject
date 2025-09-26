<?php
require 'connexion.php';

//On vérifie que notre formulaire soit bien envoyé avec la superglobale $servers 
//La superglobale $server renvoie un tableau associatif à chaque requête
//ici, on récup la clé REQUEST_METHOD de notre tableau associatif pour voir si la méthode POST à était appelée dans la requête, si ce n'est pas le cas cela signifie que ce n'est pas un traitement de formulaire donc on quitte desuite car ça peut-être un user malveillant...
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ajouter.php");
    exit; //stoppe le script, très important !!! 
}

//verifier que tous les champs ont bien était saisies
if(empty($_POST['titre']) || empty($_POST['artiste']) || empty($_POST['image']) || empty($_POST['description'])){
    die("Tous les champs doivent être remplis.");
}

//nettoyer la saisie de nos input
$title = trim($_POST['titre']);
if ($title === '') {
    die("Le champ titre est obligatoire.");
}

$artist = trim($_POST['artiste']);
if ($artist === '') {
    die("Le champ artiste est obligatoire.");
}

$image = filter_var(trim($_POST['image']), FILTER_VALIDATE_URL); //ajoute un filtre pour vérifier que la donnée correspond bien à une url 
if ($image === false) {
    die("Le champ image est obligatoire.");
}

$description = trim($_POST['description']);
if ($description === '') {
    die("Le champ description est obligatoire.");
}
if(strlen ($description) < 5){
    die("La description doit être plus grande.");
}

//insertion des données 
$sql = "INSERT INTO artwork (artwork_title, artwork_artist, artwork_img, artwork_desc) VALUE (:title, :artiste, :image, :description)";

$stmt = $connexion->prepare($sql);
$stmt->execute([
    'title' => $title,
    'artiste' => $artist,
    'image' => $image,
    'description' => $description
]);
//redirection pour éviter le double envoi
header('Location: index.php');
exit;