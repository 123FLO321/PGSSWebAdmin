<?php

include_once '../config.php';
include_once '../lib/db.php';

$id = $_GET["id"];
$pokemon_id = $_GET["pokemon_id"];
$form = $_GET["form"];

if ($pokemon_id == -2) {
	$form = NULL;
}

print $form;

$query = "
    UPDATE pokemon_images
	SET pokemon_id = :pokemon_id, form = :form
	WHERE id = :id
";

$sth = $db->pdo->prepare($query);
$sth->bindParam(':pokemon_id', $pokemon_id, PDO::PARAM_STR);
$sth->bindParam(':form', $form, PDO::PARAM_INT);
$sth->bindParam(':id', $id, PDO::PARAM_STR);
$sth->execute();