<style>
	table.dataTable tbody td {
		text-align: center;
		vertical-align: middle;
	}
</style>

<script>
	$(document).ready(function() {
		$('#table').DataTable( {
			"ajax": 'get/pokmeonimages',
			"paging":   true,
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
            "info":     false,
			"order": [[ 2, "asc" ]],
			"search.caseInsensitive": true,
			"columnDefs": [ {
				"targets": [4,5,6],
				"orderable": false
			}],
			"drawCallback": function( settings ) {
				$("#table img:visible").unveil();
			}
		});
	} );

	function deletePokemonImage(id, element) {
		$.post( "delete/pokemonimage/"+id );
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
		</tbody>
	</table>
	<br>
</div>