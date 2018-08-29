<?php

include_once '../config.php';
include_once '../lib/db.php';

$id = $_GET["id"];
$fortId = $_GET["fort_id"];

$query = "
    UPDATE gym_images
	SET fort_id = :fort_id
	WHERE id = :id
";

if ($fortId == -2) {
	$queryNotId = "
	    SELECT id 
		FROM forts
		WHERE name = 'NOT A FORT'
		LIMIT 1
	";
	$fortId = $db->query($queryNotId)->fetch(\PDO::FETCH_ASSOC)["id"];
}

$sth = $db->pdo->prepare($query);
$sth->bindParam(':fort_id', $fortId, PDO::PARAM_STR);
$sth->bindParam(':id', $id, PDO::PARAM_STR);
$sth->execute();