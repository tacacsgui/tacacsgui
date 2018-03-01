checkConfiguration()
getUserInfo()
var editForm='form#editUserGroupForm';
var addForm='form#addUserGroupForm';
///////////////////////////
/////CHECKBOX ENABLE ENCRYPT///
$('div.icheck input[type="checkbox"]').iCheck({
	checkboxClass: 'icheckbox_square-blue',
	radioClass: 'iradio_square-blue',
	increaseArea: '20%' // optional
});
///////////////////////////
/////MOVE THE RIGHTS///
////////FOR THE ADD FORM///
$(addForm + ' .moveOptionRight').click(function (){
	$(addForm+' select.availableOptions :selected').each(function(){
		this.selected = false;
		$(addForm+' select.selectedOptions').append(this);
	})
})

$(addForm + ' .moveOptionLeft').click(function (){
	$(addForm+' select.selectedOptions :selected').each(function(){
		this.selected = false;
		$(addForm+' select.availableOptions').append(this);
	})
})
////////FOR THE EDIT FORM///
$(editForm + ' .moveOptionRight').click(function (){
	$(editForm+' select.availableOptions :selected').each(function(){
		this.selected = false;
		$(editForm+' select.selectedOptions').append(this);
	})
})

$(editForm + ' .moveOptionLeft').click(function (){
	$(editForm+' select.selectedOptions :selected').each(function(){
		this.selected = false;
		$(editForm+' select.availableOptions').append(this);
	})
})
///////////////////////////
function getRightsList(array)
{
	var data = {
		"action": "POST",
		"test" : "none"
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"user/group/rights/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			if (array.formName == addForm)
			{
				for (i=0; i < data['rights'].length; i++)
				{
					option = new Option(data['rights'][i].name, data['rights'][i].value, false, false)
					$(array.formName+' select.availableOptions').append(option);
				}
				return;
			}
			if (array.formName == editForm)
			{
				for (i=0; i < data['rights'].length; i++)
				{
					option = new Option(data['rights'][i].name, data['rights'][i].value, false, false)
					
					if (array.selected.includes(parseInt(data['rights'][i].value)))
					{
						$(array.formName+' select.selectedOptions').append(option);
					}
					else
					{
						$(array.formName+' select.availableOptions').append(option);
					}
				}
				return;
			}
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
////FILL THE SELECT OF ADD FORM///
$('#addUserGroup').on('show.bs.modal', function(){
	getRightsList( {formName: addForm } );
})

////ADD USER GROUP FUNCTION///START//
function addUserGroup(){
	console.log('Adding new user');
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	var rights = [];
	$(addForm+' select.selectedOptions option').each(function(){
		rights.push($(this).val())
	})
	/////////ADD NEW USER GROUP///START//
	var data = {
		"action": "POST",
		"name": $(addForm+' input[name="name"]').val(),
		"default_flag": $(addForm+' input[name="default_flag"]').prop('checked'),
		"rights": rights,
		"test" : "none"
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"user/group/add/",
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
						$(addForm+' div.'+v).addClass('has-error')
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
			toastr["success"]("User Group "+ $(addForm+' input[name="name"]').val() +" was added")
			$("#addUserGroup").modal("hide");
			clearAddGroupModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
	
}
/////////ADD NEW USER GROUP///END////

function clearAddGroupModal()
{
	$(addForm+' select.selectedOptions').empty();
	$(addForm+' select.availableOptions').empty();
	$(addForm+' input[name="name"]').val('')
	$(addForm+' input[name="default_flag"]').iCheck('uncheck')
	
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
}
////////////////////////////////
///////////////////////////
////DELETE USER GROUP FUNCTION////START//
function deleteGroup(id,name){
	console.log('Deleting User GroupID:'+id+' with name '+name)
	if (confirm("Do you want delete '"+name+"'?")){
		/////////DELETE USER GROUP///START//
		var data = {
			"action": "POST",
			"name": name,
			"id": id,
			"test" : "none"
			};	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: API_LINK+"user/group/delete/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				if(data['deleteGroup']!=1){
					(data['error']['message']) ? toastr["error"](data['error']['message']) : toastr["error"]("Oops! Unknown error appeared :(");
					return;
				}
				toastr["success"]("Device group "+ name +" was deleted")	
				changeApplyStatus(data['changeConfiguration'])
				setTimeout( function () {dataTable.ajax.reload()}, 2000 );
			},
			error: function(data) {
				//console.log(data);
				errorHere(data);
			}
		});
		/////////DELETE USER GROUP///END////
	}
	return;
}
////DELETE USER GROUP FUNCTION////END//
/////////////////////////////
////EDIT USER GROUP GROUP FUNCTION///START//
function editGroup(id,groupName){ //GET INFO ABOUT GROUP//
	var data = {
		"action": "GET",
		"name": groupName,
		"id": id,
		"test" : "none"
	};
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"user/group/edit/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('groupName.text-green').text(data['group']['name'])
			$(editForm+' input[name="id"]').val(data['group']['id'])
			$(editForm+' input[name="name"]').val(data['group']['name'])
			$(editForm+' input[name="name_old"]').val(data['group']['name'])
			
			var default_flag = (data['group']['default_flag'] == 1) ? 'check' : 'uncheck';
			$(editForm+' input[name="default_flag"]').iCheck(default_flag)
			//if (default_flag === 'check') $(editForm+' input[name="default_flag"]').iCheck('disable')
				
			var selectedRights = data.group.rights.toString(2).split('').reverse()
			var selectedValue = [];
			
			for (var i=0; i < selectedRights.length; i++)
			{
				if (selectedRights[i] == 1) selectedValue.push(i);
			}
			
			getRightsList( {formName: editForm, selected: selectedValue} );
			
			$('#editUserGroup').modal('show')
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}//GET INFO ABOUT GROUP//END//
///////////////////////////////////////
function submitGroupChanges(){
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	
	var rights = [];
	$(editForm+' select.selectedOptions option').each(function(){
		rights.push($(this).val())
	})
	
		var data = {
		"action": "POST",
		"name": $(editForm+' input[name="name"]').val(),
		"name_old": $(editForm+' input[name="name_old"]').val(),
		"id": $(editForm+' input[name="id"]').val(),
		"default_flag": $(editForm+' input[name="default_flag"]').prop('checked'),
		"rights": rights,
		"test" : "none"
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"user/group/edit/",
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
						$(editForm+' div.'+v).addClass('has-error')
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
			toastr["success"]("User group "+ $(editForm+' input[name="name"]').val() +" was updated")
			$("#editUserGroup").modal("hide");
			clearEditGroupModal(); 
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
///////////////////////////
function clearEditGroupModal(){
	
	$(editForm+' select.selectedOptions').empty();
	$(editForm+' select.availableOptions').empty();
	$(editForm+' input[name="name"]').val('')
	$(editForm+' input[name="default_flag"]').iCheck('uncheck')
	
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
}
////EDIT USER GROUP FUNCTION///END//
////////////////////////////////
////CLEAR MODALS FUNCTIONS//////
$('#addUserGroup').on('hidden.bs.modal', function(){
	clearAddGroupModal()
})
$('#editUserGroup').on('hidden.bs.modal', function(){
	clearEditGroupModal()
})
////////////////////////////////