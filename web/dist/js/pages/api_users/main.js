checkConfiguration()
getUserInfo()
var addForm = 'form#addUserForm';
var editForm = 'form#editUserForm';
//////ACTIVATE SELECT2/////
//////TEMPLATE FUNCTIONS/////
function selectionTemplate(data){
	var default_flag_class = (data.default_flag) ? 'option_default_flag': ''
	var output='<div class="selectGroupOption '+ default_flag_class +'">';
		output += '<text>'+data.text+'</text>';
		output += '<specialFlags>';
		//output += (data.key) ? '<small class="label pull-right bg-green" style="margin:3px">k</small>' : '';
		//output += (data.enable) ? ' <small class="label pull-right bg-yellow" style="margin:3px">e</small>' : '';
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
var select_group_addDev = $(addForm+' .select_group')
var select_group_editDev = $(editForm+' .select_group')
var generalSelect2Data = {
	ajax:{
		url: API_LINK+"user/group/list/",
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
select_group_addDev.select2(generalSelect2Data)
select_group_editDev.select2(generalSelect2Data)
function preSelection(groupId, selector)
{
	var data = {
		"action": "GET",
		"groupId": groupId,
		"test" : "none"
		};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"user/group/list/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			var output='<div class="selectGroupOption">';
				output += '<text>'+data.item.text+'</text>';
				output += '<specialFlags>';
				//output += (data.item.key) ? '<small class="label pull-right bg-green" style="margin:3px">k</small>' : '';
				//output += (data.item.enable) ? ' <small class="label pull-right bg-yellow" style="margin:3px">e</small>' : '';
				output += '</specialFlags>'
				output += '</div>'
			var option = new Option(output, data.item.id, true, true)
			if (selector == 'addModal') select_group_addDev.append(option).trigger('change');
			if (selector == 'editModal') select_group_editDev.append(option).trigger('change');
			
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
///////////////////////////
////DELETE USER FUNCTION////START//
function deleteUser(id,username){
	console.log('Deleting UserID:'+id+' with username '+username)
	if (confirm("Do you want delete '"+username+"'?")){
		/////////DELETE USER///START//
		var data = {
			"action": "POST",
			"username": username,
			"id": id,
			"test" : "none"
			};	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: API_LINK+"user/delete/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				if(data['deleteUser']!=1){toastr["error"]("Oops! Unknown error appeared :(");return;}
				toastr["success"]("User "+ username +" was deleted")	
				setTimeout( function () {dataTable.ajax.reload()}, 2000 );
			},
			error: function(data) {
				//console.log(data);
				errorHere(data);
			}
		});
		/////////DELETE USER///END////
	}
	return;
}
////DELETE USER FUNCTION////END//
/////////////////////////////////
////ADD USER FUNCTION///START//
function addUser(){
	console.log('Adding new user');
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	/////////ADD NEW USER///START//
	var data = {
		"action": "POST",
		"username": $('form#addUserForm input[name="Username"]').val(),
		"password": $('form#addUserForm input[name="Password"]').val(),
		"repPassword": $('form#addUserForm input[name="RepPassword"]').val(),
		"email": $('form#addUserForm input[name="Email"]').val(),
		"firstname": $('form#addUserForm input[name="Firstname"]').val(),
		"surname": $('form#addUserForm input[name="Surname"]').val(),
		"position": $('form#addUserForm input[name="Position"]').val(),
		"group": select_group_addDev.select2('data')[0].id,
		"test" : "none"
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"user/add/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			if (data['error']['status']){
				//console.log(data['error']['validation'])
				for (v in data['error']['validation']){
					//console.log(v)
					if (!(data['error']['validation'][v] == null)){
						//console.log($('form#addUserForm div.'+v))
						$('form#addUserForm div.'+v).addClass('has-error')
						$('div.form-group.'+v+' p.help-block').hide()
						var error_message='';
						for (num in data['error']['validation'][v]){
							error_message='<p class="text-red">'+data['error']['validation'][v][num]+'</p>';
						}
						$('div.form-group.'+v).append(error_message)
					}
				}
				return;
			}
			toastr["success"]("User "+ $('form#addUserForm input[name="Username"]').val() +" was added")
			$("#addUser").modal("hide");
			clearAddUserModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
	/////////ADD NEW USER///END////
}
///////////////////////////
function clearAddUserModal(){
	$('form#addUserForm input[name="Username"]').val('')
	$('form#addUserForm input[name="Password"]').val('')
	$('form#addUserForm input[name="RepPassword"]').val('')
	$('form#addUserForm input[name="Email"]').val('')
	$('form#addUserForm input[name="Firstname"]').val('')
	$('form#addUserForm input[name="Surname"]').val('')
	$('form#addUserForm input[name="Position"]').val('')
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
}
////ADD USER FUNCTION///END//
////////////////////////////////
////EDIT USER FUNCTION///START//
function editUser(id,username){ //GET INFO ABOUT USER//
	var data = {
		"action": "GET",
		"username": username,
		"id": id,
		"test" : "none"
	};
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"user/edit/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('username.text-green').text(data['user']['username'])
			$('form#editUserForm input[name="Username"]').val(data['user']['username'])
			$('form#editUserForm input[name="Password"]').val('')
			$('form#editUserForm input[name="RepPassword"]').val('')
			$('form#editUserForm input[name="Email"]').val(data['user']['email'])
			$('form#editUserForm input[name="Firstname"]').val(data['user']['firstname'])
			$('form#editUserForm input[name="Surname"]').val(data['user']['surname'])
			$('form#editUserForm input[name="Position"]').val(data['user']['position'])
			$('form#editUserForm input[name="id"]').val(data['user']['id'])
			
			preSelection(data['user']['group'], 'editModal');
			
			$('text.created_at').text('Created at '+data['user']['created_at']);
			$('text.updated_at').text('Last update was at '+data['user']['updated_at']);
			$('#editUser').modal('show')
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
function submitUserChanges(){
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
		var data = {
		"action": "POST",
		"username": $('form#editUserForm input[name="Username"]').val(),
		"password": $('form#editUserForm input[name="Password"]').val(),
		"repPassword": $('form#editUserForm input[name="RepPassword"]').val(),
		"email": $('form#editUserForm input[name="Email"]').val(),
		"firstname": $('form#editUserForm input[name="Firstname"]').val(),
		"surname": $('form#editUserForm input[name="Surname"]').val(),
		"position": $('form#editUserForm input[name="Position"]').val(),
		"id": $('form#editUserForm input[name="id"]').val(),
		"group": select_group_editDev.select2('data')[0].id,
		"test" : "none"
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"user/edit/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			if (data['error']['status']){
				//console.log(data['error']['validation'])
				for (v in data['error']['validation']){
					//console.log(v)
					if (!(data['error']['validation'][v] == null)){
						//console.log($('form#editUserForm div.'+v))
						$('form#editUserForm div.'+v).addClass('has-error')
						$('div.form-group.'+v+' p.help-block').hide()
						var error_message='';
						for (num in data['error']['validation'][v]){
							error_message='<p class="text-red">'+data['error']['validation'][v][num]+'</p>';
						}
						$('div.form-group.'+v).append(error_message)
					}
				}
				return;
			}
			toastr["success"]("User "+ $('form#editUserForm input[name="Username"]').val() +" was updated")
			$("#editUser").modal("hide");
			clearEditUserModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
///////////////////////////
function clearEditUserModal(){
	$('form#editUserForm input[name="Username"]').val('')
	$('form#editUserForm input[name="Password"]').val('')
	$('form#editUserForm input[name="RepPassword"]').val('')
	$('form#editUserForm input[name="Email"]').val('')
	$('form#editUserForm input[name="Firstname"]').val('')
	$('form#editUserForm input[name="Surname"]').val('')
	$('form#editUserForm input[name="Position"]').val('')
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
}
////EDIT USER FUNCTION///END//
//////////////////////////////
////CLEAR MODALS FUNCTIONS//////
$('#addUser').on('hidden.bs.modal', function(){
	clearAddUserModal()
})
$('#editUser').on('hidden.bs.modal', function(){
	clearEditUserModal()
})
////////////////////////////////