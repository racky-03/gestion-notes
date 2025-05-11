<?php
// Connexion à la base de données
include '../connexion.php';

// Vérifier si le formulaire est soumis
if (isset($_POST['submit'])) {
    $nom_matiere = $_POST['nom_matiere'];
    $id_formation = $_POST['id_formation'];

    try {
        // Insérer la matière dans la base de données
        $sql = "INSERT INTO matieres (nom_matiere, id_formation) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom_matiere, $id_formation]);

        // Message de succès
        $message = "Matière ajoutée avec succès.";
        $message_type = "success";
    } catch (Exception $e) {
        // Message d'erreur en cas de problème
        $message = "Erreur : " . $e->getMessage();
        $message_type = "danger";
    }
}
?>

<style>
    body {
        background-color: #f3f4f6;
        font-family: 'Arial', sans-serif;
    }
    .container {
        margin-top: 80px;
        max-width: 600px;
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        color: #1f6feb;
        font-size: 28px;
        margin-bottom: 30px;
    }
    .form-group label {
        font-weight: bold;
        color: #333;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 12px;
        font-size: 16px;
        margin-bottom: 20px;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #1f6feb;
        box-shadow: 0 0 5px rgba(31, 111, 235, 0.6);
    }
    .btn-primary {
        background-color: #1f6feb;
        border: none;
        color: white;
        padding: 12px 30px;
        font-size: 16px;
        border-radius: 8px;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background-color: #155db8;
    }
    .alert {
        padding: 15px;
        margin-top: 20px;
        border-radius: 5px;
        font-weight: bold;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    .form-container {
        margin: 0 auto;
        padding: 20px;
    }
</style>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Matière</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Ajouter une Matière</h2>

        <!-- Affichage du message de succès ou d'erreur -->
        <?php if (isset($message)): ?>
            <div class="alert alert-<?= $message_type ?>"><?= $message ?></div>
        <?php endif; ?>

        <div class="form-container">
            <!-- Formulaire d'ajout de matière -->
            <form action="ajouter_matiere.php" method="post">
                <div class="form-group">
                    <label for="nom_matiere">Nom de la Matière</label>
                    <input type="text" class="form-control" id="nom_matiere" name="nom_matiere" required>
                </div>

                <div class="form-group">
                    <label for="id_formation">Formation Associée</label>
                    <select class="form-control" id="id_formation" name="id_formation" required>
                        <option value="">Sélectionner une formation</option>
                        <?php
                        // Récupérer les formations disponibles dans la base de données
                        $sql = "SELECT id, nom_formation FROM formations";
                        $stmt = $pdo->query($sql);
                        if ($stmt->rowCount() > 0) {
                            while ($formation = $stmt->fetch()) {
                                echo "<option value='{$formation['id']}'>{$formation['nom_formation']}</option>";
                            }
                        } else {
                            echo "<option value='' disabled>Aucune formation disponible</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Ajouter Matière</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
