<?php

include_once '../config.php';
include_once '../lib/db.php';

$id = $_GET['id'];

$query = "
        DELETE
        FROM gym_images
        WHERE id = :id
    ";

$sth = $db->pdo->prepare($query);
$sth->bindParam(':id', $id, PDO::PARAM_INT);

if ($sth->execute()) {
	header('Location: ../../checkgyms');
} else {
	echo "Failed to delete GymImage.";
}