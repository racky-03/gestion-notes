<?php
session_start();
require_once "../includes/config.php";

// Retire ou commente la vérification de session
// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
//     header('Location: ../index.php');
//     exit();
// }

try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestion_notes", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT e.matricule, e.nom, e.prenom, e.adresse, e.telephone, f.libelle AS formation
            FROM etudiant e
            LEFT JOIN formation f ON e.formation_id = f.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Liste des étudiants inscrits</h1>

    <?php if (count($etudiants) > 0): ?>
        <table>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Formation</th>
            </tr>
            <?php foreach ($etudiants as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['matricule']) ?></td>
                <td><?= htmlspecialchars($e['nom']) ?></td>
                <td><?= htmlspecialchars($e['prenom']) ?></td>
                <td><?= htmlspecialchars($e['adresse']) ?></td>
                <td><?= htmlspecialchars($e['telephone']) ?></td>
                <td><?= htmlspecialchars($e['formation']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun étudiant n'a été trouvé dans la base de données.</p>
    <?php endif; ?>

    <br>
    <a href="dashboard.php">Retour à l'administration</a>
</body>
</html>
