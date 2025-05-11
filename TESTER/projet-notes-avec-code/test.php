<?php
require_once "includes/config.php";

$sql = "SELECT * FROM utilisateur";
$result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "Login : " . $row['login'] . "<br>";
    echo "Mot de passe : " . $row['mot_de_passe'] . "<br>";
    echo "Role : " . $row['role'] . "<hr>";
}

?>
