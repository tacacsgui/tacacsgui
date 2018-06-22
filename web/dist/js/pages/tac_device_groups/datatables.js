$("#filterButton").click(function() {

	if ($("#filterFields").css('display') != 'none') {
		$("#filterFields").hide("slow");
		return;
	};
	if ($("#filterFields").css('display') == 'none') {$("#filterFields").show("slow"); return;};

});

var dataTable =  $('#deviceGroupsDataTable').DataTable( {

	//scrollX: true,
	processing: true,
	serverSide: true,
	autoWidth: false,

	"createdRow": function( row, data, dataIndex){
		if(data['default_flag']) $(row).addClass('greenRow');
	},
	"columns": [
	{"title": "ID", "data" : "id"},
	{"title": "Name", "data" : "name"},
	{"title": "Action", "data" : "buttons", "searchable": false},
	 ],
	"columnDefs": [
	{
		"targets": [ 1 ],
		"createdCell": function (td, cellData, rowData, row, col) {
			if (rowData.key) $(td).append(' <small class="label bg-green" data-toggle="tooltip" data-placement="top" title="Key configured" style="margin:3px">k</small>')
			if (rowData.enable) $(td).append(' <small class="label bg-yellow" style="margin:3px" data-toggle="tooltip" data-placement="top" title="Enable password configured">e</small>')
		},
	},
	{
		"targets": [2],
		"orderable": false
	} ],
	"lengthMenu": [ 10, 25, 50, 75, 100 ],

	ajax: {"url": API_LINK+"tacacs/device/group/datatables/",
		"type": "POST",
		"data": {
			"temp": "acc"
		}
	}, // json datasource

	"drawCallback": function( settings ) {
		var filterRow='';
		var filterRowElement=$('<tr role="row" id="filterFields" style="display: none;"></tr>')
		for (i = 0; i < settings.aoColumns.length; i++) {
			filter='<td></td>';
			if (settings.aoColumns[i].bSearchable)
			{
				var filter = $("<td></td>");
				var inputElement=$('<input searchCol_id="'+i+'" class="search-input form-control">')
				filterRowElement.append(filter.append(inputElement))
			}
			filterRow+=filter;
		}
        $('#deviceGroupsDataTable thead').append(filterRowElement);
		tguiInit.tooltips();
    }

});

$.fn.dataTable.ext.errMode = 'throw';

$("#deviceGroupsDataTable_filter").css("display","none");  // hiding global search box

$(document).on('keyup click change', '.search-input', function(){
	var i =$(this).attr('searchCol_id');  // getting column index
	var v =$(this).val();  // getting search input value
	dataTable.columns(i).search(v).draw();
} );
