<?php

include_once '../config.php';
include_once '../lib/db.php';
include_once '../lib/functions.php';

$data = array();

$query = "
	SELECT id, pokemon_id, form
	FROM pokemon_images
";
$results = $db->query($query)->fetchAll(\PDO::FETCH_ASSOC);

foreach ($results as $result) {
	$id = $result['id'];
	$pokemonId = $result['pokemon_id'];
	$form = $result['form'];
	$screenshotUrl = 'image/PokemonImage_'.$id.'.png';
	if (is_null($form)) {
		$formString = '?';
	} else {
		$formString = sprintf('%02d',$form);;
	}
	if ($pokemonId == 0) {
		$name = 'Unknown Pokemon';
		$pokemonId = '';
		$formString ='';
		$url = '';
	} else if ($pokemonId == -2 ) {
		$name = 'No Pokemon';
		$pokemonId = '';
		$formString ='';
		$url = '';
	} else {
		$pokemonId = sprintf('%03d',$pokemonId);
		$name = getPokemonName($pokemonId, $form);
		$url = getPokemonURL($pokemonId, $form);
	}

	if ($name === "Unknown Pokemon") {
		$editButton = '<a href="solvepokemon/'.$id.'" role="button" class="btn btn-success">Match</a>';
	} else {
		$editButton = '<a href="solvepokemon/'.$id.'" role="button" class="btn btn-primary">Edit</a>';
	}
	$buttons = $editButton.'<a onclick="deletePokemonImage(\''.$id.'\',this)"  role="button" class="btn btn-danger" style="color:white;">Delete</a>';
	$screenshotImage = '<img data-src="'.$screenshotUrl.'" style="max-height:250px">';
	$pokemonImage = '<img data-src="'.$url.'" style="max-height:250px; max-width:200px">';
	$data[] = array($id, $name, $pokemonId, $formString, $screenshotImage, $pokemonImage, $buttons);
}

header('Content-Type: application/json');
echo json_encode(array("data"=>$data));