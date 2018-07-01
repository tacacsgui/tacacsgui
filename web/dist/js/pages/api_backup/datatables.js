$("#filterButton").click(function() {

	if ($("#filterFields").css('display') != 'none') {
		$("#filterFields").hide("slow");
		return;
	};
	if ($("#filterFields").css('display') == 'none') {$("#filterFields").show("slow"); return;};

});
var dataTables = {};

var baseConfiguration = function(){

	return {
		processing: true,
		serverSide: true,
		autoWidth: false,
		orderCellsTop: true,
		dom: 'lrtip',

		"columns": [
		{"title": "File", "data" : "fileName"},
		{"title": "Version", "data" : "version"},
		{"title": "Size", "data" : "size"},
		{"title": "Action", "data" : "buttons"},
		 ],

		"columnDefs": [
		{
			"targets": [1,2,3],
			"orderable": false
		} ],

		"order":[[0,'asc']],

		"lengthMenu": [10, 25, 50, 75, 100 ],

		ajax: {"url": API_LINK+"backup/datatables/",
			"type": "POST",
			"data": {
				type: "tcfg"
			}
		}, // json datasource
	}
}
var tcfgConfiguration = new baseConfiguration();
var apicfgConfiguration = new baseConfiguration();
apicfgConfiguration.ajax.data.type = 'apicfg';
var fullConfiguration = new baseConfiguration();
fullConfiguration.ajax.data.type = 'full';

dataTables.tcfg =  $('#tcfgDataTable').DataTable( tcfgConfiguration );
dataTables.apicfg =  $('#apicfgDataTable').DataTable( apicfgConfiguration );
dataTables.full =  $('#fullDataTable').DataTable( fullConfiguration );

$.fn.dataTable.ext.errMode = 'throw';

$(document).on('keyup click change', '.search-input', function(){
	var i =$(this).attr('searchCol_id');  // getting column index
	var v =$(this).val();  // getting search input value
	dataTable.columns(i).search(v).draw();
} );
