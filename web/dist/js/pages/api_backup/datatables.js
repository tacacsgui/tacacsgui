$("#filterButton").click(function() {

	if ($("#filterFields").css('display') != 'none') {
		$("#filterFields").hide("slow");
		return;
	};
	if ($("#filterFields").css('display') == 'none') {$("#filterFields").show("slow"); return;};

});

var dataTable =  $('#accountingDataTable').DataTable( {

	//scrollX: true,
	processing: true,
	serverSide: true,
	autoWidth: false,
	orderCellsTop: true,

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

	"order":[[0,'desc']],

	"lengthMenu": [10, 25, 50, 75, 100 ],

	ajax: {"url": API_LINK+"backup/datatables/",
		"type": "POST",
		"data": {
			"temp": "acc"
		}
	}, // json datasource

});

$.fn.dataTable.ext.errMode = 'throw';

$("#accountingDataTable_filter").css("display","none");  // hiding global search box

$(document).on('keyup click change', '.search-input', function(){
	var i =$(this).attr('searchCol_id');  // getting column index
	var v =$(this).val();  // getting search input value
	dataTable.columns(i).search(v).draw();
} );
