<style>
	table.dataTable tbody td {
		text-align: center;
		vertical-align: middle;
	}
</style>

<script>
	$(document).ready(function() {
		$('#table').DataTable( {
			"ajax": 'get/devices',
			"paging":   true,
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],			"info":     false,
			"order": [[ 0, "asc" ]],
			"search.caseInsensitive": true,
			"columnDefs": [ {
				"targets": 3,
				"orderable": false
			} ],
			"drawCallback": function( settings ) {
				$("#table img:visible").unveil();
			}
		});
	} );
</script>

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
		</tbody>
	</table>
	<br>
</div>