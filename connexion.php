<?php
#connexion PDO
#variables d'environnement
$host = $_ENV['DB_HOST'];
$nameDb = $_ENV['DB_NAME'];
$passwordDb = $_ENV['DB_PASS'];
$userDb = $_ENV['DB_USER'];

$dsn = "mysql:host=$host;dbname=$nameDb;charset=utf8"; //data source name, permet de renseigner les informations de la bdd. 


try{
    $connexion = new PDO($dsn,$userDb,$passwordDb); //on créer une nouvelle instance de la classe PDO/on gère la connexion.
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //on ajoute une exception au mode erreur
}catch(PDOException $e){
    echo 'error de connexion '.$e->getMessage();
}

?>