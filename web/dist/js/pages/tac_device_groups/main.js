checkConfiguration()
getUserInfo()
///////////////////////////
/////CHECKBOX ENABLE ENCRYPT///
$('div.icheck input[type="checkbox"]').iCheck({
	checkboxClass: 'icheckbox_square-blue',
	radioClass: 'iradio_square-blue',
	increaseArea: '20%' // optional
});
////////////////////////////////
////ADD DEVICE FUNCTION///START//
function addDeviceGroup(){
	console.log('Adding new device group');
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	/////////ADD NEW DEVICE///START//
	var data = {
		"action": "POST",
		"name": $('form#addDeviceGroupForm input[name="name"]').val(),
		"key": $('form#addDeviceGroupForm input[name="key"]').val(),
		"enable": $('form#addDeviceGroupForm input[name="enable"]').val(),
		"enable_flag": $('form#addDeviceGroupForm select[name="enable_flag"]').val(),
		"enable_encrypt": $('form#addDeviceGroupForm input[name="enable_encrypt"]').prop('checked'),
		"default_flag": $('form#addDeviceGroupForm input[name="default_flag"]').prop('checked'),
		"banner_welcome": $('form#addDeviceGroupForm textarea[name="banner_welcome"]').val(),
		"banner_motd": $('form#addDeviceGroupForm textarea[name="banner_motd"]').val(),
		"banner_failed": $('form#addDeviceGroupForm  textarea[name="banner_failed"]').val(),
		"manual": $('form#addDeviceGroupForm  textarea[name="manual"]').val(),
		"test" : "none"
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/device/group/add/",
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
						$('form#addDeviceGroupForm div.'+v).addClass('has-error')
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
			toastr["success"]("Device group "+ $('form#addDeviceGroupForm input[name="name"]').val() +" was added")
			$("#addDeviceGroup").modal("hide");
			changeApplyStatus(data['changeConfiguration'])
			clearAddDeviceGroupModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
	
}
///////////////////////////
function clearAddDeviceGroupModal(){
	$('form#addDeviceGroupForm input[name="name"]').val('')
	$('form#addDeviceGroupForm input[name="default_flag"]').iCheck('uncheck')

	$('form#addDeviceGroupForm input[name="enable"]').val('')
	$('form#addDeviceGroupForm select[name="enable_flag"] option[value="1"]').prop('selected', true)
	$('form#addDeviceGroupForm input[name="enable_encrypt"]').iCheck('check')

	$('form#addDeviceGroupForm input[name="key"]').val('')
	
	$('form#addDeviceGroupForm div.enable_encrypt_section').show()
	$('form#addDeviceGroupForm textarea[name="banner_welcome"]').val('')
	$('form#addDeviceGroupForm textarea[name="banner_motd"]').val('')
	$('form#addDeviceGroupForm textarea[name="banner_failed"]').val('')
	$('form#addDeviceGroupForm textarea[name="banner_message"]').val('')
	$('form#addDeviceGroupForm textarea[name="manual"]').val('')
	$('.nav.nav-tabs a[href="#tab_1"]').tab('show');
	$('.form-group.has-error').removeClass('has-error');
	
	$('a.manualConfTrigger').show()
	$('div.manualConfiguration').hide()	
	
	$('p.text-red').remove();
	$('p.help-block').show();
}
/////////ADD NEW DEVICE///END////
///////////////////////////
////DELETE DEVICE FUNCTION////START//
function deleteDeviceGroup(id,deviceGroup){
	console.log('Deleting DeviceGroupID:'+id+' with name '+deviceGroup)
	if (confirm("Do you want delete '"+deviceGroup+"'?")){
		/////////DELETE DEVICE///START//
		var data = {
			"action": "POST",
			"name": deviceGroup,
			"id": id,
			"test" : "none"
			};	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: API_LINK+"tacacs/device/group/delete/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				if(data['deleteGroup']!=1){
					(data['error']['message']) ? toastr["error"](data['error']['message']) : toastr["error"]("Oops! Unknown error appeared :(");
					return;
				}
				toastr["success"]("Device group "+ deviceGroup +" was deleted")	
				changeApplyStatus(data['changeConfiguration'])
				setTimeout( function () {dataTable.ajax.reload()}, 2000 );
			},
			error: function(data) {
				//console.log(data);
				errorHere(data);
			}
		});
		/////////DELETE DEVICE///END////
	}
	return;
}
////DELETE DEVICE FUNCTION////END//
/////////////////////////////
////EDIT DEVICE GROUP FUNCTION///START//
function editDeviceGroup(id,groupName){ //GET INFO ABOUT GROUP//
	var data = {
		"action": "GET",
		"name": groupName,
		"id": id,
		"test" : "none"
	};
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/device/group/edit/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('groupName.text-green').text(data['group']['name'])
			$('form#editDeviceGroupForm input[name="id"]').val(data['group']['id'])
			$('form#editDeviceGroupForm input[name="name"]').val(data['group']['name'])
			$('form#editDeviceGroupForm input[name="name_old"]').val(data['group']['name'])
			
			var default_flag = (data['group']['default_flag'] == 1) ? 'check' : 'uncheck';
			$('form#editDeviceGroupForm input[name="default_flag"]').iCheck(default_flag)
			if (default_flag === 'check') $('form#editDeviceGroupForm input[name="default_flag"]').iCheck('disable')
			////////ENABLE KEY FIELDS///////
			$('form#editDeviceGroupForm input[name="enable"]').val(data['group']['enable'])
			$('form#editDeviceGroupForm input[name="enable_old"]').val(data['group']['enable'])
			$('form#editDeviceGroupForm select[name="enable_flag"] option[value="'+data['group']['enable_flag']+'"]').prop('selected', true)
			
			var enable_encryption = (data['group']['enable_flag'] == 1 || data['group']['enable_flag'] == 2) ? 'uncheck' : 'check';
			$('form#editDeviceGroupForm input[name="enable_encrypt"]').iCheck(enable_encryption)
			if (enable_encryption == 'check') {$('form#editDeviceGroupForm div.enable_encrypt_section').hide()}
			else ($('form#editDeviceGroupForm div.enable_encrypt_section').show())
			/////////////////////////////////
			////////TACACS KEY FIELDS///////
			$('form#editDeviceGroupForm input[name="key"]').val(data['group']['key'])
			$('form#editDeviceGroupForm input[name="key_old"]').val(data['group']['key'])
			/////////////////////////////////
			$('form#editDeviceGroupForm textarea[name="banner_welcome"]').val(data['group']['banner_welcome'])
			$('form#editDeviceGroupForm textarea[name="banner_motd"]').val(data['group']['banner_motd'])
			$('form#editDeviceGroupForm textarea[name="banner_failed"]').val(data['group']['banner_failed'])
			$('form#editDeviceGroupForm textarea[name="manual"]').val(data['group']['manual'])
			$('text.created_at').text('Created at '+data['group']['created_at']);
			$('text.updated_at').text('Last update was at '+data['group']['updated_at']);
			$('#editDeviceGroup').modal('show')
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
		var data = {
		"action": "POST",
		"id": $('form#editDeviceGroupForm input[name="id"]').val(),
		"name": $('form#editDeviceGroupForm input[name="name"]').val(),
		"name_old": $('form#editDeviceGroupForm input[name="name_old"]').val(),
		"default_flag": $('form#editDeviceGroupForm input[name="default_flag"]').prop('checked'),
		"key": $('form#editDeviceGroupForm input[name="key"]').val(),
		"enable": $('form#editDeviceGroupForm input[name="enable"]').val(),
		"enable_flag": $('form#editDeviceGroupForm select[name="enable_flag"]').val(),
		"enable_encrypt": $('form#editDeviceGroupForm input[name="enable_encrypt"]').prop('checked'),
		"banner_welcome": $('form#editDeviceGroupForm textarea[name="banner_welcome"]').val(),
		"banner_motd": $('form#editDeviceGroupForm textarea[name="banner_motd"]').val(),
		"banner_failed": $('form#editDeviceGroupForm textarea[name="banner_failed"]').val(),
		"manual": $('form#editDeviceGroupForm textarea[name="manual"]').val(),
		"test" : "none"
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/device/group/edit/",
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
						$('form#editDeviceGroupForm div.'+v).addClass('has-error')
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
			toastr["success"]("Device group "+ $('form#editDeviceGroupForm input[name="name"]').val() +" was updated")
			$("#editDeviceGroup").modal("hide");
			changeApplyStatus(data['changeConfiguration'])
			clearEditDeviceGroupModal(); 
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
///////////////////////////
function clearEditDeviceGroupModal(){
	$('form#editDeviceGroupForm input[name="name"]').val('')
	$('form#editDeviceGroupForm input[name="default_flag"]').iCheck('uncheck')
	$('form#editDeviceGroupForm input[name="default_flag"]').iCheck('enable')

	$('form#editDeviceGroupForm input[name="enable"]').val('')
	$('form#editDeviceGroupForm select[name="enable_flag"] option[value="1"]').prop('selected', true)
	$('form#editDeviceGroupForm input[name="enable_encrypt"]').iCheck('check')

	$('form#editDeviceGroupForm input[name="key"]').val('')
	
	$('form#editDeviceGroupForm div.enable_encrypt_section').show()
	$('form#editDeviceGroupForm textarea[name="banner_welcome"]').val('')
	$('form#editDeviceGroupForm textarea[name="banner_motd"]').val('')
	$('form#editDeviceGroupForm textarea[name="banner_failed"]').val('')
	$('form#editDeviceGroupForm textarea[name="banner_message"]').val('')
	$('form#editDeviceGroupForm textarea[name="manual"]').val('')
	$('.nav.nav-tabs a[href="#tab_1"]').tab('show');
	
	$('a.manualConfTrigger').show()
	$('div.manualConfiguration').hide()	
	
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
}
////EDIT DEVICE FUNCTION///END//
////////////////////////////////
////CLEAR MODALS FUNCTIONS//////
$('#addDeviceGroup').on('hidden.bs.modal', function(){
	clearAddDeviceGroupModal()
})
$('#editDeviceGroup').on('hidden.bs.modal', function(){
	clearEditDeviceGroupModal()
})
////////////////////////////////
////////////////////////////////
////MANUAL CONFIGURATION TRIGGER//START//
$('a.manualConfTrigger').click(function(){
	$('a.manualConfTrigger').hide()
	$('div.manualConfiguration').show()
})
////MANUAL CONFIGURATION TRIGGER//END//
////////////////////////////////////////