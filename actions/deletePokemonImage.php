<?php

include_once '../config.php';
include_once '../lib/db.php';

$id = $_GET['id'];

$query = "
        DELETE
        FROM pokemon_images
        WHERE id = :id
";

$sth = $db->pdo->prepare($query);
$sth->bindParam(':id', $id, PDO::PARAM_INT);

if (!$sth->execute()) {
	http_response_code(500);
	echo "Failed to delete PokemonImages.";
}