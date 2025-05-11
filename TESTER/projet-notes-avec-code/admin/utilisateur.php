<?php
session_start();

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit();
}

$message = "";

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role'];

    // Connexion à la base de données
    include '../connexion.php';

    // Vérifier si le login existe déjà
    $query = "SELECT * FROM utilisateur WHERE login = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$login]);
    if ($stmt->rowCount() > 0) {
        $message = "⚠️ Le login existe déjà.";
    } else {
        // Ajouter l'utilisateur dans la base de données
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilisateur (login, mot_de_passe, role) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login, $mot_de_passe_hash, $role]);
        $message = "✅ Utilisateur ajouté avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <style>
        /* Styles similaires à ceux précédemment */
    </style>
</head>
<body>

<div class="container">
    <h1>Ajouter un utilisateur</h1>

    <?php if ($message): ?>
        <div><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="login">Login :</label>
        <input type="text" id="login" name="login" required><br><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>

        <label for="role">Rôle :</label>
        <select id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="etudiant">Étudiant</option>
        </select><br><br>

        <input type="submit" value="Ajouter utilisateur">
    </form>
</div>

</body>
</html>
