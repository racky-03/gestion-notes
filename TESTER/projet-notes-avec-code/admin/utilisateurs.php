<?php
session_start();

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Connexion à la base de données
include '../connexion.php';

// Récupérer uniquement les utilisateurs avec le rôle 'etudiant'
$query = "SELECT * FROM utilisateur WHERE role = 'etudiant'";
$stmt = $pdo->prepare($query);
$stmt->execute();
$etudiants = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #1976d2;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #1976d2;
            color: white;
        }
        .btn {
            padding: 8px 12px;
            background-color: #1976d2;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
            display: inline-block;
        }
        .btn:hover {
            background-color: #0d47a1;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestion des étudiants</h1>

    <a href="ajouter_utilisateur.php" class="btn">Ajouter un utilisateur</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etudiants as $etudiant): ?>
                <tr>
                    <td><?= htmlspecialchars($etudiant['id']) ?></td>
                    <td><?= htmlspecialchars($etudiant['login']) ?></td>
                    <td><?= htmlspecialchars($etudiant['role']) ?></td>
                    <td>
                        <a href="modifier_utilisateur.php?id=<?= $etudiant['id'] ?>" class="btn">Modifier</a>
                        <a href="supprimer_utilisateur.php?id=<?= $etudiant['id'] ?>" class="btn" style="background-color: #d32f2f;">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
