<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 80px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        a {
            display: block;
            margin: 15px 0;
            padding: 12px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        a:hover {
            background-color: #2980b9;
        }
        .logout {
            background-color: #e74c3c;
        }
        .logout:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenue, <?= htmlspecialchars($_SESSION['user']['login']) ?> 👋</h1>
        <p>Vous êtes connecté en tant qu'administrateur.</p>

        <a href="utilisateurs.php">👤 Gérer les utilisateurs</a>
        <a href="notes.php">📘 Gérer les notes</a>
        <a href="formations.php">🎓 Gérer les formations</a>
        <a href="../logout.php" class="logout">🚪 Se déconnecter</a>
    </div>
</body>
</html>
