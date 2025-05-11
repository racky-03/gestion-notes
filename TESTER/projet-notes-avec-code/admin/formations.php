<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include '../connexion.php';

// Ajouter une formation
if (isset($_POST['ajouter'])) {
    $libelle = trim($_POST['libelle']);
    if (!empty($libelle)) {
        $stmt = $pdo->prepare("INSERT INTO formation (libelle) VALUES (:libelle)");
        $stmt->execute(['libelle' => $libelle]);
    }
}

// Supprimer une formation
if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);
    $stmt = $pdo->prepare("DELETE FROM formation WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

// Récupérer les formations
$stmt = $pdo->query("SELECT * FROM formation ORDER BY id DESC");
$formations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les formations</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f4f8;
            padding: 40px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            margin-top: 20px;
            gap: 10px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
        }
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #3498db;
            color: white;
        }
        .supprimer {
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .supprimer:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎓 Gestion des Formations</h1>

        <form method="POST">
            <input type="text" name="libelle" placeholder="Nom de la formation" required>
            <button type="submit" name="ajouter">Ajouter</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Libellé</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formations as $f) : ?>
                <tr>
                    <td><?= htmlspecialchars($f['id']) ?></td>
                    <td><?= htmlspecialchars($f['libelle']) ?></td>
                    <td><a href="?supprimer=<?= $f['id'] ?>" class="supprimer" onclick="return confirm('Supprimer cette formation ?')">Supprimer</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
