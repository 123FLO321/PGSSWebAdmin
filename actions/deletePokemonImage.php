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

if ($sth->execute()) {
	header('Location: /checkpokemon');
} else {
	echo "Failed to delete PokemonImages.";
}