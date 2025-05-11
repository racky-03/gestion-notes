<?php
session_start();

// Connexion à la base de données
include 'connexion.php';

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les notes de l'utilisateur connecté
$id_utilisateur = $_SESSION['id'];
$sql = "SELECT n.id, n.note, n.date, m.nom AS matiere, f.nom AS formation
        FROM notes n
        JOIN matieres m ON n.id_matiere = m.id
        JOIN formations f ON m.id_formation = f.id
        WHERE n.id_utilisateur = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_utilisateur]);
$notes = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir mes Notes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f8ff; /* Bleu très clair */
        }
        .container {
            margin-top: 50px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #0288d1;
        }
        table {
            margin-top: 20px;
        }
        .btn {
            background-color: #0288d1;
            color: white;
        }
        .btn:hover {
            background-color: #01579b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Mes Notes</h2>

        <?php if (empty($notes)): ?>
            <p>Aucune note disponible pour le moment.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Note</th>
                        <th>Matière</th>
                        <th>Formation</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notes as $note): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($note['note']); ?></td>
                            <td><?php echo htmlspecialchars($note['matiere']); ?></td>
                            <td><?php echo htmlspecialchars($note['formation']); ?></td>
                            <td><?php echo htmlspecialchars($note['date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <br>
        <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
