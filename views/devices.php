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
			"order": [[ 0, "asc" ]],
			"search.caseInsensitive": true,
			"columnDefs": [ {
				"targets": 3,
				"orderable": false
			} ]
		});
	} );
</script>

<?php
include_once "lib/db.php";

$data = array();

$query = "
	SELECT device_uuid, MAX(timestamp) as max_timestamp 
	FROM device_location_history 
	GROUP BY device_uuid
";
$results = $db->query($query)->fetchAll(\PDO::FETCH_ASSOC);

foreach ($results as $result) {
	$deviceUUID = $result['device_uuid'];
	$maxTimestamp = $result['max_timestamp'];
	$lastTeleportDate = date('Y-m-d H:i:s', $maxTimestamp);
	$screenshotFile = PGSS_ROOT_DIR.'/web_img/Device_'.$deviceUUID.'.png';
	$lastScreenshotDate = date('Y-m-d H:i:s', filemtime($screenshotFile));

	$data[] = array('device_uuid'=>$deviceUUID, 'last_teleport_date'=>$lastTeleportDate, 'last_screenshot_date'=> $lastScreenshotDate, 'img_url'=>'image/Device_'.$deviceUUID.'.png');
}

?>

<div style="width:90%; margin-left:calc(5%);">
	<br>
	<table id="table" class="table table-striped table-bordered dt-responsive nowrap" style="position: center; width:100%">
		<thead>
		<tr>
			<th>Device</th>
			<th>Last Teleport Date</th>
			<th>Last Screenshot Date</th>
			<th width="15%">Latest Screenshot</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($data as $row) {
			echo
				'<tr>'.
				'     <td>'.$row["device_uuid"].'</td>'.
				'     <td>'.$row["last_teleport_date"].'</td>'.
				'     <td>'.$row["last_screenshot_date"].'</td>'.
				'     <td>'.
				'           <img src="'.$row["img_url"].'" style="max-height:400px">'.
				'	  </td>'.
				'</tr>';

		}
		?>
		</tbody>
	</table>
	<br>
</div>