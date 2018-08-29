<?php

include_once "lib/db.php";

$queryAllGymImagesCount = "
	SELECT COUNT(*) as count
	FROM gym_images
";
$allGymImagesCount = $db->query($queryAllGymImagesCount)->fetch(\PDO::FETCH_ASSOC)['count'];

$queryUnknownGymImagesCount = "
	SELECT count(*) as count
	FROM gym_images fi
    JOIN forts f ON f.id = fi.fort_id
    WHERE f.name = 'UNKNOWN FORT'
";
$unknownGymImagesCount = $db->query($queryUnknownGymImagesCount)->fetch(\PDO::FETCH_ASSOC)['count'];

$queryAllPokemonImagesCount = "
	SELECT COUNT(*) as count
	FROM pokemon_images
";
$allPokemonImagesCount = $db->query($queryAllPokemonImagesCount)->fetch(\PDO::FETCH_ASSOC)['count'];

$queryUnkownPokemonImagesCount = "
	SELECT COUNT(*) as count
	FROM pokemon_images
    WHERE pokemon_id = 0
";
$unkownPokemonImagesCount = $db->query($queryUnkownPokemonImagesCount)->fetch(\PDO::FETCH_ASSOC)['count'];

?>

<br>
<h2 align="center">Stats</h2>
<br>
<h3 align="center">Gym Images</h3>
<h5 align="center">Total: <?=$allGymImagesCount?></h5>
<h5 align="center">Unknown: <?=$unknownGymImagesCount?></h5>
<br>
<h3 align="center">Pokemon Images</h3>
<h5 align="center">Total: <?=$allPokemonImagesCount?></h5>
<h5 align="center">Unknown: <?=$unkownPokemonImagesCount?></h5>