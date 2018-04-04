var editForm='form#editGroupForm';
var addForm='form#addGroupForm';
////SELECTION OF ACL/////////START///
//////TEMPLATE FUNCTIONS/////
function selectionTemplate_acl(data){
	
	var output='<div class="selectAclOption">';
		output += '<text>'+data.text+'</text>';
		output += '</div>'
	return output;
}
function resultTemplate_acl(data){
	console.log(data)
	return 222;
}
////////////////////////////
var select_acl_add = $(addForm + ' .select_acl')
var select_acl_edit = $(editForm + ' .select_acl')
var generalSelect2Data_acl = {
	ajax:{
		url: API_LINK+"tacacs/acl/list/",
		dataType: 'json',
		processResults: function (data) {
			// Tranforms the top-level key of the response object from 'items' to 'results'
			console.log(data)
			return {
				results: data.items
			};
		},
		result: function(data){
		console.log(data)
		}
	},
	escapeMarkup: function(markup){ return markup;},
	templateResult: selectionTemplate_acl,
	templateSelection: selectionTemplate_acl,
	minimumResultsForSearch: Infinity,
}
select_acl_add.select2(generalSelect2Data_acl)
select_acl_edit.select2(generalSelect2Data_acl)
function preSelection_acl(aclId, selector)
{
	if (aclId == 0)
	{
		var output='<div class="selectAclOption">';
				output += '<text>None</text>';
				output += '</div>'
			var option = new Option(output, 0, true, true)
			if (selector == 'addModal') select_acl_add.append(option).trigger('change');
			if (selector == 'editModal') select_acl_edit.append(option).trigger('change');
		return;
	}
	var data = {
		"action": "GET",
		"aclId": aclId,
		"test" : "none"
		};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/acl/list/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			var output='<div class="selectAclOption">';
				output += '<text>'+data.item.text+'</text>';
				output += '</div>'
			var option = new Option(output, data.item.id, true, true)
			if (selector == 'addModal') select_acl_add.append(option).trigger('change');
			if (selector == 'editModal') select_acl_edit.append(option).trigger('change');
			
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
$('#addGroup').on('show.bs.modal', function(){
	preSelection_acl(0, 'addModal');
})
////SELECTION OF ACL/////////END///
////////////////////////////////////
////SELECTION OF SERVICE/////////START///
//////TEMPLATE FUNCTIONS/////
function selectionTemplate_service(data){
	
	var output='<div class="selectAclOption">';
		output += '<text>'+data.text+'</text>';
		output += '</div>'
	return output;
}
function resultTemplate_acl(data){
	console.log(data)
	return 222;
}
////////////////////////////
var select_service_add = $(addForm + ' .select_service')
var select_service_edit = $(editForm + ' .select_service')
var generalSelect2Data_service = {
	ajax:{
		url: API_LINK+"tacacs/services/list/",
		dataType: 'json',
		processResults: function (data) {
			// Tranforms the top-level key of the response object from 'items' to 'results'
			console.log(data)
			return {
				results: data.items
			};
		},
		result: function(data){
		console.log(data)
		}
	},
	escapeMarkup: function(markup){ return markup;},
	templateResult: selectionTemplate_service,
	templateSelection: selectionTemplate_service,
	minimumResultsForSearch: Infinity,
}
select_service_add.select2(generalSelect2Data_service)
select_service_edit.select2(generalSelect2Data_service)
function preSelection_service(serviceId, selector)
{
	if (serviceId == 0)
	{
		var output='<div class="selectAclOption">';
				output += '<text>None</text>';
				output += '</div>'
			var option = new Option(output, 0, true, true)
			if (selector == 'addModal') select_service_add.append(option).trigger('change');
			if (selector == 'editModal') select_service_edit.append(option).trigger('change');
		return;
	}
	var data = {
		"action": "GET",
		"serviceId": serviceId,
		"test" : "none"
		};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/services/list/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			var output='<div class="selectAclOption">';
				output += '<text>'+data.item.text+'</text>';
				output += '</div>'
			var option = new Option(output, data.item.id, true, true)
			if (selector == 'addModal') select_service_add.append(option).trigger('change');
			if (selector == 'editModal') select_service_edit.append(option).trigger('change');
			
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
$('#addGroup').on('show.bs.modal', function(){
	preSelection_service(0, 'addModal');
})
////SELECTION OF SERVICE/////////END///
////////////////////////////////////