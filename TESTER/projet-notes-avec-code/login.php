<?php
session_start();

$error_message = "";

// Vérifier si le formulaire de connexion est soumis
if (isset($_POST['login']) && isset($_POST['mot_de_passe'])) {
    $login = $_POST['login'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Vérification des identifiants (login = admin et mot de passe = admin)
    if ($login === 'admin' && $mot_de_passe === 'admin') {
        // L'utilisateur est authentifié, créer une session
        $_SESSION['user'] = [
            'login' => $login,
            'role' => 'admin'
        ];

        // Redirection après connexion
        if (isset($_SESSION['redirect_url'])) {
            $redirect_url = $_SESSION['redirect_url'];
            unset($_SESSION['redirect_url']);
            header("Location: $redirect_url");
        } else {
            header("Location: admin/dashboard.php");
        }
        exit();
    } else {
        $error_message = "❌ Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e3f2fd;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
            width: 350px;
        }
        h2 {
            text-align: center;
            color: #1976d2;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background: #1976d2;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background: #0d47a1;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Connexion Admin</h2>

    <?php if (!empty($error_message)) : ?>
        <div class="error"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="login">Login :</label>
        <input type="text" id="login" name="login" required>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <input type="submit" value="Se connecter">
    </form>
</div>

</body>
</html>
