<?php
require 'connexion.php';

if($_SERVER['REQUEST_METHOD'] !== "POST"){
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php?error=invalid_id');
    exit;
}

$sql = "DELETE FROM artwork WHERE artwork_id = :id";
$stmt = $connexion->prepare($sql);
$stmt->execute([':id' => $_POST['id']]);
header('Location: index.php');
exit;

?>