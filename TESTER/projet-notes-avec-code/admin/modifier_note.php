<?php
// Connexion à la base de données
include '../connexion.php';

// Vérifier si l'ID de la note est passé en paramètre
if (isset($_GET['id'])) {
    $id_note = $_GET['id'];

    // Récupérer les informations de la note
    $sql = "SELECT * FROM notes WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_note]);
    $note = $stmt->fetch();

    // Vérifier si la note existe
    if (!$note) {
        die("Note introuvable.");
    }
} else {
    die("ID de la note non spécifié.");
}

// Si le formulaire est soumis, mettre à jour la note
if (isset($_POST['submit'])) {
    $id_etudiant = $_POST['id_etudiant'];
    $id_matiere = $_POST['id_matiere'];
    $note_valeur = $_POST['note'];

    // Mettre à jour la note dans la base de données
    $update_sql = "UPDATE notes SET id_utilisateur = ?, matiere = ?, note = ? WHERE id = ?";
    $stmt = $pdo->prepare($update_sql);
    $stmt->execute([$id_etudiant, $id_matiere, $note_valeur, $id_note]);

    // Vérifier si la mise à jour a réussi
    if ($stmt->rowCount() > 0) {
        echo "Note mise à jour avec succès!";
    } else {
        echo "Erreur lors de la mise à jour de la note.";
    }
}
?>

<!-- Formulaire HTML pour modifier la note -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Note</title>
</head>
<body>
    <h2>Modifier la Note</h2>

    <form method="POST" action="">
        <!-- Champ pour l'ID de l'étudiant -->
        <label for="id_etudiant">Étudiant :</label>
        <select name="id_etudiant" required>
            <?php
            // Récupérer les étudiants disponibles
            $sql_etudiants = "SELECT id, login FROM utilisateur WHERE role = 'etudiant'";
            $stmt_etudiants = $pdo->query($sql_etudiants);
            while ($etudiant = $stmt_etudiants->fetch()) {
                // Pré-selectionner l'étudiant actuel
                $selected = $etudiant['id'] == $note['id_utilisateur'] ? 'selected' : '';
                echo "<option value='{$etudiant['id']}' $selected>{$etudiant['login']}</option>";
            }
            ?>
        </select><br><br>

        <!-- Champ pour la matière -->
        <label for="id_matiere">Matière :</label>
        <select name="id_matiere" required>
            <?php
            // Récupérer les matières disponibles
            $sql_matieres = "SELECT id, nom_matiere FROM matieres";
            $stmt_matieres = $pdo->query($sql_matieres);
            while ($matiere = $stmt_matieres->fetch()) {
                // Pré-selectionner la matière actuelle
                $selected = $matiere['id'] == $note['id_matiere'] ? 'selected' : '';
                echo "<option value='{$matiere['id']}' $selected>{$matiere['nom_matiere']}</option>";
            }
            ?>
        </select><br><br>

        <!-- Champ pour la note -->
        <label for="note">Note :</label>
        <input type="number" step="0.01" name="note" value="<?php echo $note['note']; ?>" required><br><br>

        <input type="submit" name="submit" value="Mettre à jour la note">
    </form>
</body>
</html>
