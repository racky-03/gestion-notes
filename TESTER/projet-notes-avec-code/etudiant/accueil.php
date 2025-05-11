<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'etudiant') {
    header('Location: ../index.php');
    exit();
}

include '../connexion.php';

// Récupérer les notes de l'étudiant connecté
$id_utilisateur = $_SESSION['user']['id'];

$query = "SELECT f.libelle AS formation, n.valeur AS note
          FROM notes n
          JOIN formation f ON n.formation_id = f.id
          WHERE n.utilisateur_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_utilisateur]);
$notes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Notes</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #3498db; color: white; }
        .logout {
            display: block;
            text-align: center;
            margin-top: 30px;
            text-decoration: none;
            background: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mes Notes</h1>

        <table>
            <thead>
                <tr>
                    <th>Formation</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($notes) > 0): ?>
                    <?php foreach ($notes as $note): ?>
                        <tr>
                            <td><?= htmlspecialchars($note['formation']) ?></td>
                            <td><?= htmlspecialchars($note['note']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">Aucune note enregistrée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="../logout.php" class="logout">🚪 Se déconnecter</a>
    </div>
</body>
</html>
