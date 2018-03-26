
var dataTable_add_acl =  $('#aclDataTable_add').DataTable( {
				
	//scrollX: true,	
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

//$.fn.dataTable_add_acl.ext.errMode = 'throw';
				
$("#aclDataTable_add_filter").css("display","none");  // hiding global search box

$('#addACLForm').on("submit", function(e) {
	e.preventDefault();
})

var aceEditor = false;

function validateIp(ipAddr)
{
	console.log(ipAddr);
	if (ipAddr=='0.0.0.0/0') return true;
	if (/^([1-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\/([1-9]|[1-3][0-9])$/.test(ipAddr)) return true;
	console.log(/^([1-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\/([1-9]|[1-3][0-9])$/.test(ipAddr))
	return false;
}

function checkACEEditor()
{
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	if ($('.btn-createACE').length) {
		$('.btn-createACE').closest('tr[role="row"]').addClass('blockAnimation');
		setTimeout(function(){$('.blockAnimation').removeClass('blockAnimation')},3000)
		return true;
	}
	
	return false;
}

function addACE(addTo,form)
{
	if (checkACEEditor()) {return;}
	dt = (form == 'addForm') ? dataTable_add_acl : dataTable_edit_acl;
	aceEditor = true;
	var inputElement = document.createElement('input')
	var line_number = 1
	if (addTo == 'down') line_number = (dt.row(':last').data() == undefined) ? 1 : dt.row(':last').data().line_number + 1;
	console.log(addTo)
	if (addTo == 'top'){
		rowsData = dt.rows().data()
		rowsData = rowsData.map(function(val){val.line_number++; return val;})
		dt.clear();
		dt.rows.add(rowsData).draw();
	}
	dt.row.add({
		"line_number" : line_number,
		"action" : '<div class="form-group"><select class="form-control action"><option value="permit" selected>permit</option><option value="deny">deny</option></select></div>',
		"nac" : '<div class="form-group"><input class="form-control nac" placeholder="0.0.0.0/0"></div>',
		"nas" : '<div class="form-group"><input class="form-control nas" placeholder="0.0.0.0/0"></div>',
		"timerange" : '<input class="form-control timerange" placeholder="timeRange" disabled>',
		"buttons" : '<button class="btn btn-success btn-createACE" onclick="createRow(event, '+line_number+',\''+form+'\')">Create</button>',
	}).draw(); //create row and set index to rowIndex variable
}

function createRow(event, line_number,form)
{
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	var formName = form;
	var dt = (form == 'addForm') ? dataTable_add_acl : dataTable_edit_acl;
		form = (form == 'addForm') ? addForm : editForm;
	var row = event.srcElement.closest('tr');
	var action = $(form+' select.action').val();
	var nac = ($(form+' input.nac').val() == '') ? '0.0.0.0/0' : $(form+' input.nac').val();
	var nas = ($(form+' input.nas').val() == '') ? '0.0.0.0/0' : $(form+' input.nas').val();
	var timerange = $(form+' input.timerange').val()
	console.log(nac+' '+nas+' '+timerange)
	var errorMessage='Incorrect ip addr or prefix';
	var errorFlag=false;
	if (!validateIp(nac)) {
		$('input.nac').parent().addClass('has-error').append('<p class="text-red">'+errorMessage+'</p>'); 
		errorFlag=true;
	}
	if (!validateIp(nas)) {
		$('input.nas').parent().addClass('has-error').append('<p class="text-red">'+errorMessage+'</p>'); 
		errorFlag=true;
	}
	if (errorFlag) return;
	
	var rowDataOld = dt.row(row).data()
	
	var rowData = {
		"line_number" : line_number,
		"action" : action,
		"nac" : nac,
		"nas" : nas,
		"timerange" : timerange,
		"buttons" : '<div class="btn-group text-center">'+
		'<button type="button" class="btn btn-default" onclick="moveRow(event, \'down\',\''+formName+'\')"><i class="fa fa-caret-down"></i></button>'+
		'<button type="button" class="btn btn-default" onclick="moveRow(event, \'up\',\''+formName+'\')"><i class="fa fa-caret-up"></i></button>'+
		'<button type="button" class="btn btn-warning" onclick="editRow(event,\''+formName+'\')"><i class="fa fa-edit"></i></button>'+
		'<button type="button" class="btn btn-danger" onclick="deleteRow(event,\''+formName+'\')"><i class="fa fa-trash"></i></button>'+
		'</div>',
	}
	
	if (rowDataOld.id != undefined) rowData.id = rowDataOld.id;
	
	dt.row(row).data(rowData)
	console.log(dt.row(row).data())
	$('.blockAnimation').removeClass('blockAnimation')
}

var deletedRow=[];

function deleteRow(event,form)
{
	if (checkACEEditor()) {return;}
	var dt = (form == 'addForm') ? dataTable_add_acl : dataTable_edit_acl;
	var line_number = 1;
	var row = event.srcElement.closest('tr')
	console.log(form)
	if (dt.row(row).data().id != undefined) deletedRow.push(dt.row(row).data().id)
	dt.row(row).remove().draw();
	rowsData = dt.rows().data()
	rowsData = rowsData.map(function(val){val.line_number = line_number; line_number++; return val;})
	dt.clear();
	dt.rows.add(rowsData).draw();
}

function editRow(event,form)
{
	if (checkACEEditor()) {return;}
	var dt = (form == 'addForm') ? dataTable_add_acl : dataTable_edit_acl;
	var row = event.srcElement.closest('tr');
	console.log(dt.row(row))
	var rowData = dt.row(row).data()
	newRowData = {
		"line_number" : rowData.line_number,
		"action" : '<div class="form-group"><select class="form-control action"><option value="permit" '+ ((rowData.action == 'permit') ? 'selected' : '') +'>permit</option><option value="deny" '+ ((rowData.action == 'deny') ? 'selected' : '') +'>deny</option></select></div>',
		"nac" : '<input class="form-control nac" placeholder="0.0.0.0/0" value="'+rowData.nac+'">',
		"nas" : '<input class="form-control nas" placeholder="0.0.0.0/0" value="'+rowData.nas+'">',
		"timerange" : '<input class="form-control timerange" placeholder="timeRange" disabled>',
		"buttons" : '<button class="btn btn-warning btn-createACE" onclick="createRow(event, '+rowData.line_number+')">Edit</button>',
	}
	console.log(rowData);
	if (rowData.id != undefined) newRowData.id = rowData.id;
	console.log(newRowData);
	dt.row(row).data(newRowData)
}

function moveRow(event, dir,form)
{
	if (checkACEEditor()) {return;}
	var dt = (form == 'addForm') ? dataTable_add_acl : dataTable_edit_acl;
	dt.row(event.srcElement.closest('tr')).data().line_number = dir;
	rowsData = dt.rows().data()
	var prevElement = -1;
	rowsData = rowsData.map(function(val,index){
		//console.log(val);console.log(index);
		if (val.line_number == 'up') {
			if (prevElement == -1) {val.line_number = 1; return val;}
			val.line_number = rowsData[prevElement].line_number;
			rowsData[prevElement].line_number++
			return val;
		}
		if (val.line_number == 'down') {
			if (rowsData[index+1] == undefined) {
				if (prevElement == -1) {val.line_number = 1; return val;}
				val.line_number = rowsData[prevElement].line_number + 1; 
				return val;
			}
			val.line_number = rowsData[index+1].line_number;
			rowsData[index+1].line_number-- 
			return val;
		}
		prevElement=index;
		return val;
	})
	dt.clear();
	dt.rows.add(rowsData).draw();
}