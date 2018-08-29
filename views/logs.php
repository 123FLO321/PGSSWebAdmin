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
			"order": [[ 0, "desc" ]],
			"search.caseInsensitive": true,
			"columnDefs": [ {
				"targets": 4,
				"orderable": false
			} ]
		});
	} );
</script>



<?php

$data = array();

$files = array_diff(scandir(PGSS_ROOT_DIR.'/logs'), array('.', '..'));
foreach ($files as $file) {
	if ((substr($file, - 4) !== '.log')) {
		continue;
	} else {
		$splited = explode('_', $file);

		if ($splited[2] === 'raidscan.log') {
			$type = 'raidscan';
			$device = '';
		} else if ($splited[3] === 'xcodebuild.log') {
			$type = 'xcodebuild';
			$device = $splited[2];
		} else {
			continue;
		}

		$time = $splited[0].' '.str_replace('-', ':', $splited[1]);

		$size = number_format(filesize(PGSS_ROOT_DIR.'/logs/'.$file) / 1048576, 2);

		$data[] = array("time"=>$time, "type"=>$type, "device"=>$device, "size"=> $size, "filename"=>$file);
	}
}


?>

<div style="width:90%; margin-left:calc(5%);">
	<br>
	<table id="table" class="table table-striped table-bordered dt-responsive nowrap" style="position: center; width:100%">
		<thead>
			<tr>
				<th>Time</th>
				<th>Type</th>
				<th>Device</th>
				<th>Size</th>
				<th width="15%"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($data as $row) {
				echo
					'<tr>'.
					'     <td>'.$row["time"].'</td>'.
					'     <td>'.$row["type"].'</td>'.
					'     <td>'.$row["device"].'</td>'.
					'     <td>'.$row["size"].' MB</td>'.
					'     <td>'.
					'           <a href="log/'.$row["filename"].'" role="button" class="btn btn-success">View</a>'.
					'           <a href="download/log/'.$row["filename"].'" role="button" class="btn btn-primary">Download</a>'.
					'           <a href="delete/log/'.$row["filename"].'" role="button" class="btn btn-danger">Delete</a>'.
					'	  </td>'.
					'</tr>';

			}
			?>
		</tbody>
	</table>
	<br>
</div>