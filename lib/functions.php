<?php

function getPokemonURL($pokemonId, $form) {
	if (is_null($form)) {
		if ($pokemonId == 201 || $pokemonId == 351 || $pokemonId == 386 || $pokemonId == 327 || $pokemonId == 421 || $pokemonId == 487 || $pokemonId == 492) {
			$formReal = 11;
		} else {
			$formReal = 0;
		}	} else {
		$formReal = $form;
	}
	return 'https://raw.githubusercontent.com/ZeChrales/PogoAssets/master/pokemon_icons/pokemon_icon_'.sprintf('%03d',$pokemonId).'_'.sprintf('%02d',$formReal).'.png';
}

function getPokemonName($pokemonId, $form) {
	if (is_null($form)) {
		if ($pokemonId == 201 || $pokemonId == 351 || $pokemonId == 386 || $pokemonId == 327) {
			$formReal = 11;
		} else {
			$formReal = 0;
		}
	} else {
		$formReal = $form;
	}
	if ($formReal < 11) {
		$formReal = 0;
	}

	$pokemonData = json_decode(file_get_contents(__DIR__.'/../data/pokemon.json'), true);

	$entryString = sprintf('%03d',$pokemonId).'_'.sprintf('%02d',$formReal);

	if (array_key_exists($entryString, $pokemonData)) {
		return $pokemonData[$entryString];
	} else {
		return 'Pokemon: '.sprintf('%03d',$pokemonId).' Form: '.sprintf('%02d',$formReal);
	}

}

function searchPokemon($term) {
	$resultArray = array();
	$pokemonData = json_decode(file_get_contents(__DIR__.'/../data/pokemon.json'), true);

	foreach ($pokemonData as $key=>$pokemon) {
		$split = explode('_', $key);
		$pokemonId = $split[0];
		$pokemonForm = $split[1];
		$pokemonName = $pokemon;
		$searchId = sprintf('%03d',$pokemonId).'_'.sprintf('%02d',$pokemonForm);

		if ($term == $pokemonId or str_contains($pokemonName, $term)) {
			$resultArray[] = array("name"=>$pokemonName, "url"=>getPokemonURL($pokemonId,$pokemonForm), "id"=>$searchId);
		}

	}
	return $resultArray;
}

function str_contains($string, $substring){
	return strpos(strtolower($string), strtolower($substring)) !== false;
}
