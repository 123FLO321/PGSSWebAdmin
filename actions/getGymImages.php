<?php

include_once '../config.php';
include_once '../lib/db.php';

$data = array();

$query = "
	SELECT fi.id, fi.fort_id, f.name, f.url
	FROM gym_images fi
	JOIN forts f ON f.id = fi.fort_id
";
$results = $db->query($query)->fetchAll(\PDO::FETCH_ASSOC);

foreach ($results as $result) {
	$id = $result['id'];
	$fortId = $result['fort_id'];
	$name = $result['name'];
	$gymUrl = $result['url'];
	$screenshotUrl = 'image/GymImage_'.$id.'.png';

	if ($name === 'NOT A FORT') {
		$fortId = '';
		$name = "No Fort";
	} else if ($name === 'UNKNOWN FORT') {
		$fortId = '';
		$name = "Unknown Fort";
	}

	if ($name === "Unknown Fort") {
		$editButton = '<a href="solvegyms/'.$id.'" role="button" class="btn btn-success">Match</a>';
	} else {
		$editButton = '<a href="solvegyms/'.$id.'" role="button" class="btn btn-primary">Edit</a>';
	}

	$screenshotUrl = '<img data-src="'.$screenshotUrl.'" style="max-height:250px">';
	$gymUrl = '<img data-src="'.$gymUrl.'" style="max-height:250px; max-width:200px">';
	$buttons = $editButton.'<a onclick="deleteGymImage(\''.$id.'\',this)"  role="button" class="btn btn-danger" style="color:white;">Delete</a>';
	$data[] = array($id, $name, $fortId, $screenshotUrl, $gymUrl, $buttons);

}

header('Content-Type: application/json');
echo json_encode(array("data"=>$data));