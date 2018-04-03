checkConfiguration()
getUserInfo()
/////GENERATE OTP PASSWORD///START///
function generateOTPSecret(secret){

		if (secret == '') secret = $('form#editUserForm input[name="otp_secret"]').val();
		
		var data = {
		"action": "POST",
		"id": $('form#editUserForm input[name="id"]').val(),
		"secret": secret,
		"digits": $('form#editUserForm input.digits').val(),
		"digest": $('form#editUserForm select.digest').val(),
		"period": $('form#editUserForm input.period').val(),
		"test" : "none"
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"mavis/otp/generate/secret/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('form#editUserForm #qrcode').empty();
			$('form#editUserForm input.otp_secret').val(data.secret);
			$('form#editUserForm #qrcode').qrcode(data.url);
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
/////GENERATE OTP PASSWORD///START///
////////////////////////////////////
$('input[name="otp_enabled"]').on('ifChecked', function(event){
	//if ($('input.otp_secret').val() == '') generateOTPSecret('');
})
////////////////////////////////////////
////////CHECK SERVER TIME////START///
function getCurrentTime(){
		var data = {
		"action": "GET",
		"test" : "none"
		};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"apicheck/time/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('form#editUserForm time.current-time').text(data.time);
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
////////CHECK SERVER TIME////END///
///////////////////////////////////////
/////DISABLED, ENABLED SWITCHER///START//
function disabledSwitcher(form,action)
{
	var button = $('form#'+form+'UserForm div.disabled button')
	var input = $('form#'+form+'UserForm input[name="disabled"]')
	
	if (action == undefined)
	{
		
		if (input.val() == '0'){
			button.removeClass('btn-success').addClass('btn-warning').text('Disabled');
			input.val('1')
		}
		else if (input.val() == '1'){
			button.removeClass('btn-warning').addClass('btn-success').text('Enabled');
			input.val('0')
		}
		return;
	}
	
	if (action == 1){button.removeClass('btn-success').addClass('btn-warning').text('Disabled')}
	if (action == 0){button.removeClass('btn-warning').addClass('btn-success').text('Enabled')}
	input.val(action)
	
}
/////DISABLED, ENABLED SWITCHER///END//
///////////////////////////////////////
//////CHANGE PRIVILEGE LEVEL//////START///
function setPrivLvl(action){
	var privLvl = parseInt($('input[name="priv-lvl"]').val());
	switch(action) {
    case 'add':
        if (privLvl >= 15) return;
		$('input[name="priv-lvl"]').val(privLvl + 1 );
        break;
    case 'subtract':
        if (privLvl <= -1) return;
		$('input[name="priv-lvl"]').val(privLvl - 1);
        break;
	case 'unset':
        $('input[name="priv-lvl"]').val(-1);
        break;
	}
}
//////CHANGE PRIVILEGE LEVEL//////END///
///////////////////////////////////////
/////CHECKBOX ENABLING///
var generalCheckboxParameters={
	checkboxClass: 'icheckbox_square-blue',
	radioClass: 'iradio_square-blue',
	increaseArea: '20%' // optional
}
$('.checkbox.icheck').iCheck(generalCheckboxParameters);
////////////////////////////////
//////SELECT CHANGE FOR LOGIN////////
$('form#addUserForm select[name="login_flag"]').change(function(){
	console.log($('form#addUserForm select[name="login_flag"]').val())
	if ($('form#addUserForm select[name="login_flag"]').val() == 1 || $('form#addUserForm select[name="login_flag"]').val() == 2){
		$('form#addUserForm div.login_encrypt_section').show()
	} else {
		$('form#addUserForm div.login_encrypt_section').hide()
	}
})
$('form#editUserForm select[name="login_flag"]').change(function(){
	console.log($('form#editUserForm select[name="login_flag"]').val())
	if ($('form#editUserForm select[name="login_flag"]').val() == 1 || $('form#editUserForm select[name="login_flag"]').val() == 2){
		$('form#editUserForm div.login_encrypt_section').show()
	} else {
		$('form#editUserForm div.login_encrypt_section').hide()
	}
})
///////////////////////////////////
//////SELECT CHANGE FOR ENABLE////////
$('form#addUserForm select[name="enable_flag"]').change(function(){
	console.log($('form#addUserForm select[name="enable_flag"]').val())
	if ($('form#addUserForm select[name="enable_flag"]').val() == 1 || $('form#addUserForm select[name="enable_flag"]').val() == 2){
		$('form#addUserForm div.enable_encrypt_section').show()
	} else {
		$('form#addUserForm div.enable_encrypt_section').hide()
	}
})
$('form#editUserForm select[name="enable_flag"]').change(function(){
	console.log($('form#editUserForm select[name="enable_flag"]').val())
	if ($('form#editUserForm select[name="enable_flag"]').val() == 1 || $('form#editUserForm select[name="enable_flag"]').val() == 2){
		$('form#editUserForm div.enable_encrypt_section').show()
	} else {
		$('form#editUserForm div.enable_encrypt_section').hide()
	}
})
///////////////////////////
////////////////////////////////
////ADD USER FUNCTION///START//
function addUser(){
	console.log('Adding new tacacs user');
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	/////////ADD NEW DEVICE///START//
	var data = {
		"action": "POST",
		"username": $('form#addUserForm input[name="username"]').val(),
		"login": $('form#addUserForm input[name="login"]').val(),
		"login_flag": $('form#addUserForm select[name="login_flag"]').val(),
		"login_encrypt": $('form#addUserForm input[name="login_encrypt"]').prop('checked'),
		"enable": $('form#addUserForm input[name="enable"]').val(),
		"enable_flag": $('form#addUserForm select[name="enable_flag"]').val(),
		"enable_encrypt": $('form#addUserForm input[name="enable_encrypt"]').prop('checked'),
		"group": select_group_add.select2('data')[0].id,
		"acl": select_acl_add.select2('data')[0].id,
		"priv-lvl": $('form#addUserForm input[name="priv-lvl"]').val(),
		"default_service": $('form#addUserForm input[name="default_service"]').prop('checked'),
		"message": $('form#addUserForm textarea[name="message"]').val(),
		"manual": $('form#addUserForm textarea[name="manual"]').val(),
		"test" : "none"
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/user/add/",
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
						toastr["error"](data['error']['validation'][v][num])
					}
				}
				return;
			}
			toastr["success"]("User "+ $('form#addUserForm input[name="username"]').val() +" was added")
			$("#addUser").modal("hide");
			changeApplyStatus(data['changeConfiguration'])
			clearAddUserModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
	
}
///////////////////////////
function clearAddUserModal(){
	$('form#addUserForm input[name="username"]').val('')
	$('form#addUserForm input[name="login"]').val('')
	$('form#addUserForm input[name="enable"]').val('')
	$('form#addUserForm input[name="group"]').val('')
	$('form#addUserForm div.enable_encrypt_section').show()
	$('form#addUserForm div.login_encrypt_section').show()
	$('form#addUserForm input[name="login_encrypt"]').iCheck('check')
	
	$('form#addUserForm select[name="login_flag"] option[value="1').prop('selected', true)
			
	$('form#addUserForm select[name="enable_flag"] option[value="1"]').prop('selected', true)
	
	$('form#addUserForm input[name="enable_encrypt"]').iCheck('check')
	$('form#addUserForm input[name="default_service"]').iCheck('check')
	$('form#addUserForm textarea[name="message"]').val('')
	$('form#addUserForm textarea[name="manual"]').val('')
	$('.form-group.has-error').removeClass('has-error');
	
	disabledSwitcher('add','0')
	
	// Select first tab
	$('form#addUserForm .nav-tabs-custom a:first').tab('show') 
	
	$('p.text-red').remove();
	$('p.help-block').show();
	
	//Unset Priv-Lvl//
	$('input[name="priv-lvl"]').val(-1);
}
////ADD USER FUNCTION///END//
/////////////////////////////////////////////
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
		url: API_LINK+"tacacs/user/edit/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('username.text-green').text(data['user']['username'])
			$('form#editUserForm input[name="username"]').val(data['user']['username'])
			$('form#editUserForm input[name="username_old"]').val(data['user']['username'])
			$('form#editUserForm input[name="login"]').val(data['user']['login'])
			$('form#editUserForm input[name="enable"]').val(data['user']['enable'])
			$('form#editUserForm input[name="id"]').val(data['user']['id'])
			//$('form#editUserForm input[name="group"]').val(data['user']['group'])
			
			$('form#editUserForm input[name="priv-lvl"]').val(data['user']['priv-lvl'])
			
			var enable_encryption = (data['user']['enable_flag'] == 1 || data['user']['enable_flag'] == 2) ? 'uncheck' : 'check';
			$('form#editUserForm input[name="enable_encrypt"]').iCheck(enable_encryption)
			if (enable_encryption == 'check') {$('form#editUserForm div.enable_encrypt_section').hide()}
			else ($('form#editUserForm div.enable_encrypt_section').show())
			
			var login_encryption = (data['user']['login_flag'] == 1 || data['user']['login_flag'] == 2) ? 'uncheck' : 'check';
			$('form#editUserForm input[name="login_encrypt"]').iCheck(login_encryption)
			if (login_encryption == 'check') {$('form#editUserForm div.login_encrypt_section').hide()}
			else ($('form#editUserForm div.login_encrypt_section').show())

			var otp_enabled = (data.user.mavis_otp_enabled == 0) ? 'uncheck' : 'check';
			$('input[name="otp_enabled"]').iCheck(otp_enabled)

			$('form#editUserForm input.period').val(data.user.mavis_otp_period)
			$('form#editUserForm input.digits').val(data.user.mavis_otp_digits)
			$('form#editUserForm select.digest').val(data.user.mavis_otp_digest)
			
			if (data.user.mavis_otp_secret==null || data.user.mavis_otp_secret == undefined || data.user.mavis_otp_secret == '') { generateOTPSecret(''); } 
			else{
				$('form#editUserForm input.otp_secret').val(data.user.mavis_otp_secret);
				generateOTPSecret(data.user.mavis_otp_secret);
			};
			
			$('form#editUserForm select[name="login_flag"] option[value="'+data['user']['login_flag']+'"]').prop('selected', true)
			
			$('form#editUserForm select[name="enable_flag"] option[value="'+data['user']['enable_flag']+'"]').prop('selected', true)
			
			disabledSwitcher('edit',data['user']['disabled'])
			
			preSelection(data['user']['group'], 'editModal');
			preSelection_acl(data['user']['acl'], 'editModal');
			
			var default_service = (data['user']['default_service'] == 1) ? 'check' : 'uncheck';
			$('form#editUserForm input[name="default_service"]').iCheck(default_service)
			
			$('form#editUserForm textarea[name="message"]').val(data['user']['message'])
			$('form#editUserForm textarea[name="manual"]').val(data['user']['manual'])
			
			$('text.created_at').text('Created at '+data['user']['created_at']);
			$('text.updated_at').text('Last update was at '+data['user']['updated_at']);
			
			$('div.global_status p b').text( (data.otp_status == 1)? 'Enabled' : 'Disabled' )
			
			getCurrentTime();
			
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
		"username": $('form#editUserForm input[name="username"]').val(),
		"username_old": $('form#editUserForm input[name="username_old"]').val(),
		"login": $('form#editUserForm input[name="login"]').val(),
		"login_flag": $('form#editUserForm select[name="login_flag"]').val(),
		"login_encrypt": $('form#editUserForm input[name="login_encrypt"]').prop('checked'),
		"enable": $('form#editUserForm input[name="enable"]').val(),
		"enable_flag": $('form#editUserForm select[name="enable_flag"]').val(),
		"enable_encrypt": $('form#editUserForm input[name="enable_encrypt"]').prop('checked'),
		"group": select_group_edit.select2('data')[0].id,
		"acl": select_acl_edit.select2('data')[0].id,
		"mavis_otp_enabled": $('form#editUserForm input[name="otp_enabled"]').prop('checked'),
		"mavis_otp_secret": $('form#editUserForm input[name="otp_secret"]').val(),
		"mavis_otp_period": $('form#editUserForm input.period').val(),
		"mavis_otp_digits": $('form#editUserForm input.digits').val(),
		"mavis_otp_digest": $('form#editUserForm select.digest').val(),
		"priv-lvl": $('form#editUserForm input[name="priv-lvl"]').val(),
		"id": $('form#editUserForm input[name="id"]').val(),
		"default_service": $('form#editUserForm input[name="default_service"]').prop('checked'),
		"message": $('form#editUserForm textarea[name="message"]').val(),
		"manual": $('form#editUserForm textarea[name="manual"]').val(),
		"test" : "none"
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/user/edit/",
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
						toastr["error"](data['error']['validation'][v][num])
					}
				}
				return;
			}
			toastr["success"]("User "+ $('form#editUserForm input[name="Username"]').val() +" was updated")
			$("#editUser").modal("hide");
			changeApplyStatus(data['changeConfiguration'])
			clearEditUserModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			//errorHere(data);
		}
	});
}
///////////////////////////
function clearEditUserModal(){
	$('form#editUserForm input[name="username"]').val('')
	$('form#editUserForm input[name="login"]').val('')
	$('form#editUserForm input[name="enable"]').val('')
	$('form#editUserForm input[name="group"]').val('')
	$('form#editUserForm div.enable_encrypt_section').show()
	$('form#editUserForm div.login_encrypt_section').show()
	$('form#editUserForm input[name="login_encrypt"]').iCheck('check')
	$('form#editUserForm input[name="enable_encrypt"]').iCheck('check')
	$('form#editUserForm input[name="default_service"]').iCheck('check')
	$('form#editUserForm textarea[name="message"]').val('')
	$('form#editUserForm input[name="Surname"]').val('')
	$('form#editUserForm textarea[name="manual"]').val('')
	$('.form-group.has-error').removeClass('has-error');
	
	// Select first tab
	$('form#editUserForm .nav-tabs-custom a:first').tab('show') 	
	
	$('p.text-red').remove();
	$('p.help-block').show();
	
	//Unset Priv-Lvl//
	$('input[name="priv-lvl"]').val(-1);

	$('#qrcode').empty();
}
////EDIT USER FUNCTION///END//
//////////////////////////////
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
			url: API_LINK+"tacacs/user/delete/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				if(data['deleteUser']!=1){toastr["error"]("Oops! Unknown error appeared :(");return;}
				toastr["success"]("User "+ username +" was deleted")
				changeApplyStatus(data['changeConfiguration'])				
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

////CLEAR MODALS FUNCTIONS//////
$('#addUser').on('hidden.bs.modal', function(){
	clearAddUserModal()
})
$('#editUser').on('hidden.bs.modal', function(){
	clearEditUserModal()
})
////////////////////////////////

////////////////////////////////////////