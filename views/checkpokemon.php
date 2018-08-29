<style>
	table.dataTable tbody td {
		text-align: center;
		vertical-align: middle;
	}
</style>

<script>
	$(document).ready(function() {
		$('#table').DataTable( {
			"paging":   false,
			"info":     false,
			"order": [[ 2, "asc" ]],
			"search.caseInsensitive": true,
			"columnDefs": [ {
				"targets": [4,5,6],
				"orderable": false
			}]
		});
	} );
</script>

<?php
include_once "lib/db.php";
include_once "lib/functions.php";

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

	$data[] = array(
		'id'=>$id,
		'name'=>$name,
		'pokemon_id'=>$pokemonId,
		'form'=>$formString,
		'pokemon_url'=>$url,
		'screenshot_url'=>'image/PokemonImage_'.$id.'.png'
	);
}

?>

<div style="width:90%; margin-left:calc(5%);">
	<br>
	<table id="table" class="table table-striped table-bordered dt-responsive nowrap" style="position: center; width:100%">
		<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>ID</th>
			<th>Form</th>
			<th>Latest Screenshot</th>
			<th width="15%">Pokemon Image</th>
			<th width="15%"></th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($data as $row) {

			if ($row["name"] === "Unknown Pokemon") {
				$editButton = '<a href="/solvepokemon/'.$row["id"].'" role="button" class="btn btn-success">Match</a>';
			} else {
				$editButton = '<a href="/solvepokemon/'.$row["id"].'" role="button" class="btn btn-primary">Edit</a>';
			}

			echo
				'<tr>'.
				'     <td>'.$row["id"].'</td>'.
				'     <td>'.$row["name"].'</td>'.
				'     <td>'.$row["pokemon_id"].'</td>'.
				'     <td>'.$row["form"].'</td>'.
				'     <td>'.
				'           <img src="'.$row["screenshot_url"].'" style="max-height:250px">'.
				'	  </td>'.
				'     <td>'.
				'           <img src="'.$row["pokemon_url"].'" style="max-height:250px; max-width:200px">'.
				'	  </td>'.
				'	  <td>'.
				'          '.$editButton.
				'           <a href="/delete/pokemonimage/'.$row["id"].'" role="button" class="btn btn-danger">Delete</a>'.
				'	  </td>'.
				'</tr>';

		}
		?>
		</tbody>
	</table>
	<br>
</div>