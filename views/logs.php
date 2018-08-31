<style>
	table.dataTable tbody td {
		text-align: center;
		vertical-align: middle;
	}
</style>

<script>
	$(document).ready(function() {
		$('#table').DataTable( {
			"ajax": 'get/logs',
			"paging":   true,
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			"info":     false,
			"order": [[ 0, "desc" ]],
			"search.caseInsensitive": true,
			"columnDefs": [ {
				"targets": 4,
				"orderable": false
			} ],
			"drawCallback": function( settings ) {
				$("#table img:visible").unveil();
			}
		});
	} );

	function deleteLog(file, element) {
		$.post( "delete/log/"+file );
		var table = $('#table').DataTable();
		table
			.row( $(element).parents('tr') )
			.remove()
			.draw();
	}

</script>

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
		</tbody>
	</table>
	<br>
</div>