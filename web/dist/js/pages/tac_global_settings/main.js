checkConfiguration()
getUserInfo()
///////////////////////////////////////
/////CHECKBOX ENABLING///
var generalCheckboxParameters={
	checkboxClass: 'icheckbox_square-blue',
	radioClass: 'iradio_square-blue',
	increaseArea: '20%' // optional
}
$('.checkbox.icheck').iCheck(generalCheckboxParameters);
////////////////////////////////
/////////START STOP RELOAD STATUS DEAMON FUNCTION///////
function deamonConfig(action)
{
	$('input[name="deamon_status"]').val('Loading...');
	action = (action != undefined) ? action : '';
	var data = {
		"action": "POST",
		"action": action,
		"test" : "none"
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/config/deamon/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('input[name="deamon_status"]').val(data.tacacsStatusMessage);
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
deamonConfig();
/////////////////////////////////
/////GET GLOBAL VARIABLES////////
function getGlobalVariables()
{
	var data = {
		"action": "GET",
		"test" : "none"
	};
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/config/global/edit",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('lastupdate').text(data.global_variables.updated_at);
			$('input[name="port"]').val(data.global_variables.port);

			$('input[name="max_attempts"]').val(data.global_variables.max_attempts);
			$('input[name="backoff"]').val(data.global_variables.backoff);

			$('input[name="connection_timeout"]').val(data.global_variables.connection_timeout);
			$('input[name="context_timeout"]').val(data.global_variables.context_timeout);

			$('input[name="authentication"]').val(data.global_variables.authentication);
			$('input[name="authorization"]').val(data.global_variables.authorization);
			$('input[name="accounting"]').val(data.global_variables.accounting);

			if (data.global_variables.nxos_support == 1) $('input[name="nxos_support"]').iCheck('check');

			$('textarea[name="manual"]').val(data.global_variables.manual);
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
getGlobalVariables();
/////////////////////////////////
/////APPLY SETTINGS/////////////
$('button.applySettings').click(function(){
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();

	var port = $('input[name="port"]').val();
	var max_attempts = $('input[name="max_attempts"]').val();
	var backoff = $('input[name="backoff"]').val();
	var connection_timeout = $('input[name="connection_timeout"]').val();
	var context_timeout = $('input[name="context_timeout"]').val();
	var authentication = $('input[name="authentication"]').val();
	var authorization = $('input[name="authorization"]').val();
	var accounting = $('input[name="accounting"]').val();
	var nxos_support = ($('input[name="nxos_support"]').prop('checked')) ? 1 : 0;
	var manual = $('textarea[name="manual"]').val();

	var data = {
		"action": "POST",
		"port": port,
		"max_attempts": max_attempts,
		"backoff": backoff,
		"connection_timeout": connection_timeout,
		"context_timeout": context_timeout,
		"authentication": authentication,
		"authorization": authorization,
		"accounting": accounting,
		"nxos_support": nxos_support,
		"manual": manual,
		"test" : "none"
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/config/global/edit",
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
						$('div.'+v).addClass('has-error')
						$('div.form-group.'+v+' p.help-block').hide()
						var error_message='';
						for (num in data['error']['validation'][v]){
							error_message='<p class="text-red">'+data['error']['validation'][v][num]+'</p>';
						}
						$('div.form-group.'+v).append(error_message)
					}
				}
				toastr["warning"]("We found some errors in the form above")
				return;
			}
			if (data.tglobal_update) {
				toastr["success"]("Global settings was saved")
				changeApplyStatus(data.changeConfiguration)
				return;
			}
			toastr["error"]("Unknown error appeared")
			return;
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
})
////////////////////////////////
