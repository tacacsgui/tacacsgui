///////////////////////////////////////
//////ACTIVATE SELECT2/////
//////TEMPLATE FUNCTIONS/////
function selectionTemplate(data){
	var default_flag_class = (data.default_flag) ? 'option_default_flag': ''
	var output='<div class="selectGroupOption '+ default_flag_class +'">';
		output += '<text>'+data.text+'</text>';
		output += '<specialFlags>';
		output += (data.key) ? '<small class="label pull-right bg-green" style="margin:3px">k</small>' : '';
		output += (data.enable) ? ' <small class="label pull-right bg-yellow" style="margin:3px">e</small>' : '';
		output += (data.default_flag) ? ' <small class="label pull-right bg-gray" style="margin:3px">d</small>' : '';
		output += '</specialFlags>'
	output += '</div>'
	return output;
}
function resultTemplate(data){
	console.log(data)
	return 222;
}
////////////////////////////
var select_group_add = $('#addUserForm .select_group')
var select_group_edit = $('#editUserForm .select_group')
var generalSelect2Data = {
	ajax:{
		url: API_LINK+"tacacs/user/group/list/",
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
	templateResult: selectionTemplate,
	templateSelection: selectionTemplate,
	minimumResultsForSearch: Infinity,
}
select_group_add.select2(generalSelect2Data)
select_group_edit.select2(generalSelect2Data)
function preSelection(groupId, selector)
{
	if (groupId == 0)
	{
		var output='<div class="selectGroupOption">';
				output += '<text>None</text>';
				output += '</div>'
			var option = new Option(output, 0, true, true)
			if (selector == 'addModal') select_group_add.append(option).trigger('change');
			if (selector == 'editModal') select_group_edit.append(option).trigger('change');
		return;
	}
	var data = {
		"action": "GET",
		"groupId": groupId,
		"test" : "none"
		};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/user/group/list/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			var output='<div class="selectGroupOption">';
				output += '<text>'+data.item.text+'</text>';
				output += '<specialFlags>';
				output += (data.item.key) ? '<small class="label pull-right bg-green" style="margin:3px">k</small>' : '';
				output += (data.item.enable) ? ' <small class="label pull-right bg-yellow" style="margin:3px">e</small>' : '';
				output += '</specialFlags>'
				output += '</div>'
			var option = new Option(output, data.item.id, true, true)
			if (selector == 'addModal') select_group_add.append(option).trigger('change');
			if (selector == 'editModal') select_group_edit.append(option).trigger('change');
			
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
$('#addUser').on('show.bs.modal', function(){
	preSelection(0, 'addModal');
})
///////////////////////////////////////
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
var select_acl_add = $('#addUserForm .select_acl')
var select_acl_edit = $('#editUserForm .select_acl')
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
$('#addUser').on('show.bs.modal', function(){
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
var select_service_add = $('#addUserForm .select_service')
var select_service_edit = $('#editUserForm .select_service')
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
$('#addUser').on('show.bs.modal', function(){
	preSelection_service(0, 'addModal');
})
////SELECTION OF SERVICE/////////END///
////////////////////////////////////