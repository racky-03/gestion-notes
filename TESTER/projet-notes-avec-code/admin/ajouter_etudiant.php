<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_notes";
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer tous les étudiants
$sql = "SELECT login, role FROM utilisateur WHERE role = 'etudiant'";
$result = $conn->query($sql);

// Vérifier si des étudiants existent
if ($result->num_rows > 0) {
    $etudiants = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $etudiants = [];
}

$conn->close();
?>

<!-- Formulaire HTML pour ajouter un utilisateur -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            overflow-x: auto;
        }
        h2 {
            text-align: center;
            color: #0066cc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Liste des étudiants</h2>

    <?php if (count($etudiants) > 0): ?>
        <table>
            <tr>
                <th>Login</th>
                <th>Rôle</th>
            </tr>
            <?php foreach ($etudiants as $etudiant): ?>
            <tr>
                <td><?= htmlspecialchars($etudiant['login']) ?></td>
                <td><?= htmlspecialchars($etudiant['role']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun étudiant n'a été trouvé.</p>
    <?php endif; ?>

</div>

</body>
</html>
