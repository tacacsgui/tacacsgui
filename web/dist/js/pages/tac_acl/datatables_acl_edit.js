var ajaxData = {"action": "getACEs", 'name':'', 'id':''};
function dataForDatatables()
{
	return ajaxData;
}
var dataTable_edit_acl =  $('#aclDataTable_edit').DataTable( {
				
	//scrollX: true,	
	//processing: true,
	//serverSide: true,
	autoWidth: false,
	orderCellsTop: true,
	paging: false,
	
	"createdRow": function( row, data, dataIndex){
		//if(data['disabled']==1) $(row).addClass('disabledRow');
	},
	
	"columns": [ 
	{"name" : "line_number", "title": "Line Num","data" : "line_number", "orderable": false},
	{"name" : "action", "title": "ACE Action","data" : "action", "orderable": false},
	{"name" : "nac", "title": "NAC","data" : "nac", "orderable": false},
	{"name" : "nas", "title": "NAS","data" : "nas", "orderable": false},
	{"name" : "timerange", "title": "Time","data" : "timerange", "orderable": false},
	{"name" : "buttons", "title": "Action","data" : "buttons", "orderable": false},
	 ],
	 
	ajax: {"url": API_LINK+"tacacs/acl/edit/",
		"type": "GET",
		"data": dataForDatatables,
	}, // json datasource

});

//$.fn.dataTable_add_acl.ext.errMode = 'throw';
				
$("#aclDataTable_edit_filter").css("display","none");  // hiding global search box

$('#editACLForm').on("submit", function(e) {
	e.preventDefault();
})