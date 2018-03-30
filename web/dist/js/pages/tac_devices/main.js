checkConfiguration()
getUserInfo()
/////DISABLED, ENABLED SWITCHER///START//
function disabledSwitcher(form,action)
{
	var button = $('form#'+form+'DeviceForm div.disabled button')
	var input = $('form#'+form+'DeviceForm input[name="disabled"]')
	
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
var select_group_addDev = $('#addDeviceForm .select_group')
var select_group_editDev = $('#editDeviceForm .select_group')
var generalSelect2Data = {
	ajax:{
		url: API_LINK+"tacacs/device/group/list/",
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
		url: API_LINK+"tacacs/device/group/list/",
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
			if (selector == 'addModal') select_group_addDev.append(option).trigger('change');
			if (selector == 'editModal') select_group_editDev.append(option).trigger('change');
			
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
$('#addDevice').on('show.bs.modal', function(){
	preSelection(0, 'addModal');
})
///////////////////////////
//////ACTIVATE SLIDERS/////
$('input[name="prefix"]').slider({
	tooltip: "always"
})
$('input[name="prefix"]').on('slide', function(slideEvt){
	$('span[name="prefix-value"]').text(slideEvt.value)
})
//////////////////////////
//////SELECT CHANGE////////
$('form#addDeviceForm select[name="enable_flag"]').change(function(){
	console.log($('form#addDeviceForm select[name="enable_flag"]').val())
	if ($('form#addDeviceForm select[name="enable_flag"]').val() == 1 || $('form#addDeviceForm select[name="enable_flag"]').val() == 2){
		$('form#addDeviceForm div.enable_encrypt_section').show()
	} else {
		$('form#addDeviceForm div.enable_encrypt_section').hide()
	}
})
$('form#editDeviceForm select[name="enable_flag"]').change(function(){
	console.log($('form#editDeviceForm select[name="enable_flag"]').val())
	if ($('form#editDeviceForm select[name="enable_flag"]').val() == 1 || $('form#editDeviceForm select[name="enable_flag"]').val() == 2){
		$('form#editDeviceForm div.enable_encrypt_section').show()
	} else {
		$('form#editDeviceForm div.enable_encrypt_section').hide()
	}
})
///////////////////////////
/////CHECKBOX ENABLE ENCRYPT///
$('div.icheck input[type="checkbox"]').iCheck({
	checkboxClass: 'icheckbox_square-blue',
	radioClass: 'iradio_square-blue',
	increaseArea: '20%' // optional
});
////////////////////////////////
////ADD DEVICE FUNCTION///START//
function addDevice(){
	console.log('Adding new device');
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	//console.log(select_group_addDev.select2('data'))
	//return;
	/////////ADD NEW DEVICE///START//
	var data = {
		"action": "POST",
		"name": $('form#addDeviceForm input[name="name"]').val(),
		"disabled": $('form#addDeviceForm input[name="disabled"]').val(),
		"group": select_group_addDev.select2('data')[0].id,
		"ipaddr": $('form#addDeviceForm input[name="ipaddr"]').val(),
		"prefix": $('form#addDeviceForm input[name="prefix"]').slider('getValue'),
		"key": $('form#addDeviceForm input[name="key"]').val(),
		"enable": $('form#addDeviceForm input[name="enable"]').val(),
		"enable_flag": $('form#addDeviceForm select[name="enable_flag"]').val(),
		"enable_encrypt": $('form#addDeviceForm input[name="enable_encrypt"]').prop('checked'),
		"banner_welcome": $('form#addDeviceForm textarea[name="banner_welcome"]').val(),
		"banner_motd": $('form#addDeviceForm textarea[name="banner_motd"]').val(),
		"banner_failed": $('form#addDeviceForm textarea[name="banner_failed"]').val(),
		"manual": $('form#addDeviceForm textarea[name="manual"]').val(),
		"test" : "none"
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/device/add/",
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
						$('form#addDeviceForm div.'+v).addClass('has-error')
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
			toastr["success"]("Device "+ $('form#addDeviceForm input[name="name"]').val() +" was added")
			$("#addDevice").modal("hide");
			changeApplyStatus(data['changeConfiguration'])
			clearAddDeviceModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
	
}
///////////////////////////
function clearAddDeviceModal(){
	$('form#addDeviceForm input[name="name"]').val('')
	$('form#addDeviceForm input[name="group"]').val('')
	$('form#addDeviceForm input[name="ipaddr"]').val('')
	$('input[name="prefix"]').slider('setValue', 32)
	
	disabledSwitcher('add','0')
	
	$('form#addDeviceForm input[name="enable"]').val('')
	$('form#addDeviceForm select[name="enable_flag"] option[value="1"]').prop('selected', true)
	$('form#addDeviceForm input[name="enable_encrypt"]').iCheck('check')
	
	$('form#addDeviceForm input[name="key"]').val('')
	
	$('form#addDeviceForm div.enable_encrypt_section').show()
	$('form#addDeviceForm textarea[name="banner_welcome"]').val('')
	$('form#addDeviceForm textarea[name="banner_motd"]').val('')
	$('form#addDeviceForm textarea[name="banner_failed"]').val('')
	$('form#addDeviceForm textarea[name="banner_message"]').val('')
	$('form#addDeviceForm textarea[name="manual"]').val('')
	$('form#addDeviceForm .form-group.ipaddr button').text('Ping').removeClass('btn-success btn-warning btn-danger').addClass('btn-gray');
	$('.nav.nav-tabs a[href="#tab_1"]').tab('show');
	
	$('a.manualConfTrigger').show()
	$('div.manualConfiguration').hide()
	
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
}
/////////ADD NEW DEVICE///END////
///////////////////////////
////DELETE DEVICE FUNCTION////START//
function deleteDevice(id,deviceName){
	console.log('Deleting DeviceID:'+id+' with name '+deviceName)
	if (confirm("Do you want delete '"+deviceName+"'?")){
		/////////DELETE DEVICE///START//
		var data = {
			"action": "POST",
			"name": deviceName,
			"id": id,
			"test" : "none"
			};	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: API_LINK+"tacacs/device/delete/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				if(data['deleteDevice']!=1){toastr["error"]("Oops! Unknown error appeared :(");return;}
				toastr["success"]("Device "+ deviceName +" was deleted")	
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
////EDIT DEVICE FUNCTION///START//
function editDevice(id,deviceName){ //GET INFO ABOUT DEVICE//
	var data = {
		"action": "GET",
		"name": deviceName,
		"id": id,
		"test" : "none"
	};
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/device/edit/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('deviceName.text-green').text(data['device']['name'])
			$('form#editDeviceForm input[name="id"]').val(data['device']['id'])
			$('form#editDeviceForm input[name="name"]').val(data['device']['name'])
			$('form#editDeviceForm input[name="name_old"]').val(data['device']['name'])
			
			disabledSwitcher('edit',data['device']['disabled'])
			
			preSelection(data['device']['group'], 'editModal');
			$('form#editDeviceForm input[name="ipaddr"]').val(data['device']['ipaddr'])
			$('form#editDeviceForm input[name="prefix"]').slider('setValue', data['device']['prefix'])
			////////ENABLE KEY FIELDS///////
			$('form#editDeviceForm input[name="enable"]').val(data['device']['enable'])
			$('form#editDeviceForm input[name="enable_old"]').val(data['device']['enable'])
			$('form#editDeviceForm select[name="enable_flag"] option[value="'+data['device']['enable_flag']+'"]').prop('selected', true)
			
			var enable_encryption = (data['device']['enable_flag'] == 1 || data['device']['enable_flag'] == 2) ? 'uncheck' : 'check';
			$('form#editDeviceForm input[name="enable_encrypt"]').iCheck(enable_encryption)
			if (enable_encryption == 'check') {$('form#editDeviceForm div.enable_encrypt_section').hide()}
			else ($('form#editDeviceForm div.enable_encrypt_section').show())
			/////////////////////////////////
			////////TACACS KEY FIELDS///////
			$('form#editDeviceForm input[name="key"]').val(data['device']['key'])
			$('form#editDeviceForm input[name="key_old"]').val(data['device']['key'])
			/////////////////////////////////
			$('form#editDeviceForm textarea[name="banner_welcome"]').val(data['device']['banner_welcome'])
			$('form#editDeviceForm textarea[name="banner_motd"]').val(data['device']['banner_motd'])
			$('form#editDeviceForm textarea[name="banner_failed"]').val(data['device']['banner_failed'])
			$('form#editDeviceForm textarea[name="manual"]').val(data['device']['manual'])
			
			$('text.created_at').text('Created at '+data['device']['created_at']);
			$('text.updated_at').text('Last update was at '+data['device']['updated_at']);
			$('#editDevice').modal('show')
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}//GET INFO ABOUT DEVICE//END//
///////////////////////////////////////
function submitDeviceChanges(){
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
		var data = {
		"action": "POST",
		"id": $('form#editDeviceForm input[name="id"]').val(),
		"name": $('form#editDeviceForm input[name="name"]').val(),
		"name_old": $('form#editDeviceForm input[name="name_old"]').val(),
		"disabled": $('form#editDeviceForm input[name="disabled"]').val(),
		"group": select_group_editDev.select2('data')[0].id,
		"ipaddr": $('form#editDeviceForm input[name="ipaddr"]').val(),
		"prefix": $('form#editDeviceForm input[name="prefix"]').slider('getValue'),
		"key": $('form#editDeviceForm input[name="key"]').val(),
		"enable": $('form#editDeviceForm input[name="enable"]').val(),
		"enable_flag": $('form#editDeviceForm select[name="enable_flag"]').val(),
		"enable_encrypt": $('form#editDeviceForm input[name="enable_encrypt"]').prop('checked'),
		"banner_welcome": $('form#editDeviceForm textarea[name="banner_welcome"]').val(),
		"banner_motd": $('form#editDeviceForm textarea[name="banner_motd"]').val(),
		"banner_failed": $('form#editDeviceForm textarea[name="banner_failed"]').val(),
		"manual": $('form#editDeviceForm textarea[name="manual"]').val(),
		"test" : "none"
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/device/edit/",
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
						$('form#editDeviceForm div.'+v).addClass('has-error')
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
			toastr["success"]("Device "+ $('form#editDeviceForm input[name="name"]').val() +" was updated")
			$("#editDevice").modal("hide");
			changeApplyStatus(data['changeConfiguration'])
			clearEditDeviceModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
///////////////////////////
function clearEditDeviceModal(){
	$('form#editDeviceForm input[name="name"]').val('')
	$('form#editDeviceForm input[name="group"]').val('')
	$('form#editDeviceForm input[name="ipaddr"]').val('')
	$('input[name="prefix"]').slider('setValue', 32)
	$('form#editDeviceForm input[name="enable"]').val('')
	$('form#editDeviceForm select[name="enable_flag"] option[value="1"]').prop('selected', true)
	$('form#editDeviceForm input[name="enable_encrypt"]').iCheck('check')
	$('form#editDeviceForm textarea[name="banner_welcome"]').val('')
	$('form#editDeviceForm textarea[name="banner_motd"]').val('')
	$('form#editDeviceForm textarea[name="banner_failed"]').val('')
	$('form#editDeviceForm textarea[name="manual"]').val('')
	$('.nav.nav-tabs a[href="#tab_1_edit"]').tab('show');
	$('.form-group.has-error').removeClass('has-error');
	$('form#editDeviceForm .form-group.ipaddr button').text('Ping').removeClass('btn-success btn-warning btn-danger').addClass('btn-gray');
	
	$('a.manualConfTrigger').show()
	$('div.manualConfiguration').hide()
	
	$('p.text-red').remove();
	$('p.help-block').show();
}
////EDIT DEVICE FUNCTION///END//
////////////////////////////////
////CLEAR MODALS FUNCTIONS//////
$('#addDevice').on('hidden.bs.modal', function(){
	clearAddDeviceModal()
})
$('#editDevice').on('hidden.bs.modal', function(){
	clearEditDeviceModal()
})
////////////////////////////////
////PING IP ADDRESS///START//
function pingBtnChange(form,status,result)
{
	var button = $('form#'+form+'DeviceForm .form-group.ipaddr button')
	if (status == 'hide') 
		button.text('Ping').removeClass('btn-success btn-danger').addClass('btn-gray').prop('disabled', false);
	if (status == 'success')
		button.text(result).removeClass('btn-gray btn-danger').addClass('btn-success').prop('disabled', false);
	if (status == 'fail')
		button.text(result).removeClass('btn-success btn-gray').addClass('btn-danger').prop('disabled', false);
	if (status == 'loading')
		button.text('Loading...').removeClass('btn-success btn-danger').addClass('btn-gray').prop('disabled', true);
}
function ping(form)
{
	$('.form-group.ipaddr.has-error').removeClass('has-error');
	$('.form-group.ipaddr p.text-red').remove();
	$('.form-group.ipaddr p.help-block').show();
	pingBtnChange(form,'loading',0)
	var data = {
		"action": "GET",
		"ipaddr": $('form#'+form+'DeviceForm input[name="ipaddr"]').val(),
		"test" : "none"
	};
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/device/ping/",
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
						$('form#'+form+'DeviceForm div.'+v).addClass('has-error')
						$('div.form-group.'+v+' p.help-block').hide()
						var error_message='';
						for (num in data['error']['validation'][v]){
							error_message='<p class="text-red">'+data['error']['validation'][v][num]+'</p>';
						}
						$('div.form-group.'+v).append(error_message)
					}
				}
				pingBtnChange(form,'hide',0)
				return;
			}
			var responses = data['pingResponses'];
			if(data['pingResponses'] > 1)
			{
				pingBtnChange(form,'success',data['pingResponses']+'/4')
			}
			else
			{
				pingBtnChange(form,'fail',data['pingResponses']+'/4')
			}
		
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	})
	console.log($('form#'+form+'DeviceForm input[name="ipaddr"]').val())
}
////PING IP ADDRESS///END//
////////////////////////////////
////MANUAL CONFIGURATION TRIGGER//START//
$('a.manualConfTrigger').click(function(){
	$('a.manualConfTrigger').hide()
	$('div.manualConfiguration').show()
})
////MANUAL CONFIGURATION TRIGGER//END//
////////////////////////////////////////