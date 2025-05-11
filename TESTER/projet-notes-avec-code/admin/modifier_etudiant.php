<?php
// Connexion à la base de données
include '../connexion.php';

// Vérifier si l'ID de l'étudiant est passé en paramètre
if (isset($_GET['id'])) {
    $id_etudiant = $_GET['id'];

    // Récupérer les informations de l'étudiant
    $sql = "SELECT * FROM etudiants WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_etudiant]);
    $etudiant = $stmt->fetch();

    // Vérifier si l'étudiant existe
    if (!$etudiant) {
        die("Étudiant introuvable.");
    }
} else {
    die("ID de l'étudiant non spécifié.");
}

// Si le formulaire est soumis, mettre à jour l'étudiant
if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
}
