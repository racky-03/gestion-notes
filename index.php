<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: ' . ($_SESSION['user']['role'] === 'admin' ? 'admin/dashboard.php' : 'etudiant/accueil.php'));
    exit();
}
if ($role === 'etudiant') {
    $_SESSION['user'] = ['id' => $id, 'login' => $login, 'role' => 'etudiant'];
    header("Location: etudiant/accueil.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Gestion des Notes</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #2980b9, #6dd5fa);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 25px;
            color: #333;
        }

        .login-container label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            text-align: left;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            margin-top: 25px;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            background-color: #2980b9;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background-color: #2573a6;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Portail de Gestion</h1>
        <form action="login.php" method="post">
            <label for="login">Login :</label>
            <input type="text" name="login" id="login" required>

            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required>

            <input type="submit" value="Connexion">
        </form>
    </div>
</body>
</html>
