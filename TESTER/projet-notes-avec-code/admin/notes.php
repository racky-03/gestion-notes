<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include '../connexion.php';

// Récupérer les notes avec les infos utilisateurs et formations
$query = "SELECT n.id, n.note, u.login AS etudiant, f.libelle AS formation
          FROM notes n
          JOIN utilisateur u ON n.utilisateur_id = u.id
          JOIN formation f ON n.formation_id = f.id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$notes = $stmt->fetchAll();
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des notes</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        .btn {
            padding: 8px 12px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestion des notes des étudiants</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Étudiant</th>
                    <th>Formation</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tbody>
    <?php foreach ($notes as $note): ?>
        <tr>
            <td><?php htmlspecialchars($note['id']) ?></td>
            <td><?php htmlspecialchars($note['etudiant']) ?></td>
            <td><?php htmlspecialchars($note['formation']) ?></td>
            <td><?php htmlspecialchars($note['note']) ?></td>
            <td>
                <a href="modifier_note.php?id=<?php $note['id'] ?>" class="btn">Modifier</a>
                <a href="supprimer_note.php?id=<?php $note['id'] ?>" class="btn" style="background-color: #e74c3c;">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

            </tbody>
        </table>
    </div>
</body>
</html>
