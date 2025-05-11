<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

$message = "";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestion_notes", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les étudiants et matières
    $etudiants = $pdo->query("SELECT matricule, nom FROM etudiant")->fetchAll();
    $matieres = $pdo->query("SELECT id, libelle FROM matiere")->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $matricule = $_POST['matricule'];
        $matiere_id = $_POST['matiere_id'];
        $note = $_POST['note'];

        $sql = "INSERT INTO note (matricule_etudiant, matiere_id, note) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$matricule, $matiere_id, $note]);

        $message = "Note ajoutée avec succès.";
    }

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une note</title>
</head>
<body>
    <h1>Ajouter une note</h1>
    <?php if ($message): ?>
        <p style="color:green"><?= $message ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Étudiant :</label><br>
        <select name="matricule" required>
            <?php foreach ($etudiants as $e): ?>
                <option value="<?= $e['matricule'] ?>"><?= $e['matricule'] ?> - <?= $e['nom'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Matière :</label><br>
        <select name="matiere_id" required>
            <?php foreach ($matieres as $m): ?>
                <option value="<?= $m['id'] ?>"><?= $m['libelle'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Note :</label><br>
        <input type="number" step="0.01" name="note" required><br><br>

        <input type="submit" value="Ajouter">
    </form>

    <br><a href="dashboard.php">Retour</a>
</body>
</html>
