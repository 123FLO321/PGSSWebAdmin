<?php

include_once '../config.php';
include_once '../lib/db.php';

$term = $_GET["term"];

$query = "
    SELECT name, id, url
	FROM forts
	WHERE name LIKE :term
	LIMIT 25
";

$sth = $db->pdo->prepare($query);
$term = '%'.$term.'%';
$sth->bindParam(':term', $term, PDO::PARAM_STR);
$sth->execute();
$results = $sth->fetchAll();

$retrunArray = array();

foreach ($results as $result) {
	$retrunArray[] = array("name"=>$result["name"], "url"=>$result["url"], "id"=>$result["id"]);
}

header('Content-Type: application/json');
echo json_encode($retrunArray);
