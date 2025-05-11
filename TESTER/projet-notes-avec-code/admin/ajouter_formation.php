<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

$message = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libelle = trim($_POST['libelle']);

    if (!empty($libelle)) {
        try {
            // Connexion directe sans fichier externe
            $pdo = new PDO("mysql:host=localhost;dbname=gestion_notes", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insertion de la formation
            $sql = "INSERT INTO formation (libelle) VALUES (?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$libelle]);

            $message = "✅ Formation ajoutée avec succès.";
        } catch (PDOException $e) {
            $message = "❌ Erreur : " . $e->getMessage();
        }
    } else {
        $message = "❗ Veuillez entrer un libellé valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une formation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            width: 400px;
        }
        h1 {
            text-align: center;
            color: #00796b;
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        input[type="submit"] {
            background-color: #26a69a;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #00796b;
        }
        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            color: #00695c;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #00796b;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Ajouter une formation</h1>
        
        <!-- Message d'erreur ou succès -->
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Formulaire pour ajouter une formation -->
        <form method="post">
            <label for="libelle">Libellé de la formation :</label>
            <input type="text" name="libelle" id="libelle" required>
            <input type="submit" value="Ajouter">
        </form>

        <!-- Lien vers le tableau de bord -->
        <a href="dashboard.php">← Retour au tableau de bord</a>
    </div>
</body>
</html>
