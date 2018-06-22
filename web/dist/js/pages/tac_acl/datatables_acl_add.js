
var dataTable_add_acl =  $('form#addACLForm table.aclDT').DataTable( {

	//scrollX: true,
	dom: 'lrt',
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

});

$('#addACLForm').on("submit", function(e) {
	e.preventDefault();
})
