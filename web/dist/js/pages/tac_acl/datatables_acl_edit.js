var ajaxData = {"action": "getACEs", 'name':'', 'id':''};
function dataForDatatables()
{
	return API_LINK+"tacacs/acl/edit/?name="+ajaxData.name+'&id='+ajaxData.id;
	// return ajaxData;
}
var dataTable_edit_acl =  $('form#editACLForm table.aclDT').DataTable( {

	//scrollX: true,
	//processing: true,
	//serverSide: true,
	autoWidth: false,
	orderCellsTop: true,
	paging: false,
	dom: 'lrt',
  deferLoading: 0, // here

	"columns": [
	{"name" : "line_number", "title": "Line Num","data" : "line_number", "orderable": false},
	{"name" : "action", "title": "ACE Action","data" : "action", "orderable": false},
	{"name" : "nac", "title": "NAC","data" : "nac", "orderable": false},
	{"name" : "nas", "title": "NAS","data" : "nas", "orderable": false},
	{"name" : "timerange", "title": "Time","data" : "timerange", "orderable": false},
	{"name" : "buttons", "title": "Action","data" : "buttons", "orderable": false},
	 ],

	fnServerData: function ( sSource, aoData, fnCallback ) {
			console.log(dataForDatatables());
			sSource = dataForDatatables();
			aoData = dataForDatatables;
			$.ajax( {
			"dataType": 'json',
			//"type": "GET",
			"url": sSource,
			//"data": dataForDatatables,
			"success": fnCallback,
			error: function(err){console.log(tgui_error.getStatus(err, {}));}
			} );
	},

	drawCallback: function( settings ) {
    //$("#editACL").modal("show");
  }

});

//$.fn.dataTable_add_acl.ext.errMode = 'throw';

$('#editACLForm').on("submit", function(e) {
	e.preventDefault();
})
