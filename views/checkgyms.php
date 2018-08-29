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
			"order": [[ 1, "asc" ]],
			"search.caseInsensitive": true,
			"columnDefs": [ {
				"targets": [3,4,5],
				"orderable": false
			}]
		});
	} );
</script>

<?php
include_once "lib/db.php";

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
	$url = $result['url'];

	if ($name === 'NOT A FORT') {
		$fortId = '';
		$name = "No Fort";
	} else if ($name === 'UNKNOWN FORT') {
		$fortId = '';
		$name = "Unknown Fort";
	}

	$data[] = array(
		'id'=>$id,
		'gym_id'=>$fortId,
		'name'=>$name,
		'gym_url'=>$url,
		'screenshot_url'=>'image/GymImage_'.$id.'.png'
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
            <th>Latest Screenshot</th>
			<th width="15%">Gym Image</th>
			<th width="15%"></th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($data as $row) {

			if ($row["name"] === "Unknown Fort") {
				$editButton = '<a href="solvegyms/'.$row["id"].'" role="button" class="btn btn-success">Match</a>';
			} else {
				$editButton = '<a href="solvegyms/'.$row["id"].'" role="button" class="btn btn-primary">Edit</a>';
			}

			echo
				'<tr>'.
				'     <td>'.$row["id"].'</td>'.
				'     <td>'.$row["name"].'</td>'.
				'     <td>'.$row["gym_id"].'</td>'.
				'     <td>'.
				'           <img src="'.$row["screenshot_url"].'" style="max-height:250px">'.
				'	  </td>'.
				'     <td>'.
				'           <img src="'.$row["gym_url"].'" style="max-height:250px; max-width:200px">'.
				'	  </td>'.
				'	  <td>'.
				'          '.$editButton.
				'           <a href="delete/gymimage/'.$row["id"].'" role="button" class="btn btn-danger">Delete</a>'.
				'	  </td>'.
				'</tr>';

		}
		?>
		</tbody>
	</table>
	<br>
</div>