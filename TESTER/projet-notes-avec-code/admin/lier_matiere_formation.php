<?php
$host = 'localhost';
$dbname = 'gestion_notes';
$username = 'root';  // Ton nom d'utilisateur
$password = '';      // Ton mot de passe (si c'est vide, laisse-le ainsi)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    die();
}
?>
