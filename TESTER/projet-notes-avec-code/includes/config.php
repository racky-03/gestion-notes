<?php
$mysqli = new mysqli('localhost', 'root', '', 'gestion_notes');
if ($mysqli->connect_error) {
    die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>
