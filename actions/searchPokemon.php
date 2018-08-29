<?php

include_once '../config.php';
include_once '../lib/functions.php';

$term = $_GET["term"];

$retrunArray = searchPokemon($term);

header('Content-Type: application/json');
echo json_encode($retrunArray);