<?php
session_start();

// Connexion à la base de données
include 'connexion.php';

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $ancien_mdp = $_POST['ancien_mdp'];
    $nouveau_mdp = $_POST['nouveau_mdp'];
    $confirmer_mdp = $_POST['confirmer_mdp'];

    // Vérifier que les deux nouveaux mots de passe correspondent
    if ($nouveau_mdp !== $confirmer_mdp) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        // Récupérer l'utilisateur actuel de la base de données
        $sql = "SELECT mot_de_passe FROM utilisateurs WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['id']]);
        $user = $stmt->fetch();

        // Vérifier que l'ancien mot de passe est correct
        if (password_verify($ancien_mdp, $user['mot_de_passe'])) {
            // Hacher le nouveau mot de passe
            $nouveau_mdp_hache = password_hash($nouveau_mdp, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe dans la base de données
            $sql = "UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nouveau_mdp_hache, $_SESSION['id']]);

            $message = "Mot de passe mis à jour avec succès.";
        } else {
            $message = "L'ancien mot de passe est incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Mot de Passe</title>
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
        .btn {
            background-color: #0288d1;
            color: white;
        }
        .btn:hover {
            background-color: #01579b;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Modifier mon Mot de Passe</h2>

        <?php if (isset($message)): ?>
            <div class="alert alert-info">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="ancien_mdp">Ancien Mot de Passe</label>
                <input type="password" class="form-control" id="ancien_mdp" name="ancien_mdp" required>
            </div>
            <div class="form-group">
                <label for="nouveau_mdp">Nouveau Mot de Passe</label>
                <input type="password" class="form-control" id="nouveau_mdp" name="nouveau_mdp" required>
            </div>
            <div class="form-group">
                <label for="confirmer_mdp">Confirmer le Nouveau Mot de Passe</label>
                <input type="password" class="form-control" id="confirmer_mdp" name="confirmer_mdp" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à Jour</button>
        </form>

        <br>
        <a href="index.php">Retour à l'accueil</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
