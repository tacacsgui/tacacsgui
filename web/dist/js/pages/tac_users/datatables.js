$("#filterButton").click(function() {

	if ($("#filterFields").css('display') != 'none') {
		$("#filterFields").hide("slow");
		return;
	};
	if ($("#filterFields").css('display') == 'none') {$("#filterFields").show("slow"); return;};

});

var dataTable =  $('#usersDataTable').DataTable( {

	processing: true,
	serverSide: true,
	autoWidth: false,
	orderCellsTop: true,

	"createdRow": function( row, data, dataIndex){
		if(data['disabled']==1) $(row).addClass('disabledRow');
	},

	"columns": [
	{
		"className":      'details-control',
		"orderable":      false,
		"data":           null,
		"defaultContent": ''
	},
	{"title": "ID","data" : "id"},
	{"title": "Username","data" : "username"},
	{"title": "Group","data" : "group", "searchable": false},
	{"title": "Action","data" : "buttons","searchable": false},
	 ],

	"columnDefs": [
	{
		"targets": [ 2 ],
		"createdCell": function (td, cellData, rowData, row, col) {
			//console.log(rowData.enable)
			if (rowData.message) $(td).append(' <small class="label bg-gray" data-toggle="tooltip" data-placement="top" title="Message configured" style="margin:3px">m</small>')
			if (rowData.enable) $(td).append(' <small class="label bg-yellow" data-toggle="tooltip" data-placement="top" title="Enable password configured" style="margin:3px">e</small>')
			if (rowData.disabled) $(row).addClass('text-muted')
		},
	},
	{
		"targets": [ 3 ],
		"createdCell": function (td, cellData, rowData, row, col) {
			//console.log(rowData.group)
			if (rowData.group == null) {$(td).append("-Not set-"); return;}
			if (rowData.groupMessage) $(td).append(' <small class="label bg-gray" data-toggle="tooltip" data-placement="top" title="Message configured" style="margin:3px">m</small>')
			if (rowData.groupEnable) $(td).append(' <small class="label bg-yellow" data-toggle="tooltip" data-placement="top" title="Enable password configured" style="margin:3px">e</small>')
		},
	},
	{
		"targets": [3,4],
		"orderable": false
	} ],

	"lengthMenu": [ 10, 25, 50, 75, 100 ],
	"order": [[1, 'asc']],

	ajax: {"url": API_LINK+"tacacs/user/datatables/",
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
				var inputElement=$('<input searchCol_id="' + i + '" class="search-input form-control">')
				filterRowElement.append(filter.append(inputElement))
			}
			filterRow+=filter;
		}
        $('#usersDataTable thead').append(filterRowElement);
		tguiInit.tooltips();
    }

});

$.fn.dataTable.ext.errMode = 'throw';

$("#usersDataTable_filter").css("display","none");  // hiding global search box

$(document).on('keyup click change', '.search-input', function(){
	var i =$(this).attr('searchCol_id');  // getting column index
	var v =$(this).val();  // getting search input value
	dataTable.columns(i).search(v).draw();
} );

$('#usersDataTable tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = dataTable.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
        row.child( '<pre class="partial_config partial_config_'+row.data().id+'">Loading...</pre>' ).show();
        tr.addClass('shown');
				row.child( tgui_supplier.showConfiguration(row.data(), 'user') ).show();
    }
} );
