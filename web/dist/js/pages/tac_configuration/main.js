checkConfiguration()
getUserInfo()
function testConfigStatusChange(status,text)
{
	var mainIcon = $('.testConfigurationItem i.testIcon')
	var successIcon = $('.testConfigurationItem i.testSuccess')
	var errorIcon = $('.testConfigurationItem i.testError')
	var messageBody = $('.testConfigurationItem div.testItemBody')
	
	mainIcon.removeClass('bg-green').removeClass('bg-red').addClass('bg-grey')
	successIcon.hide(); errorIcon.hide();
	messageBody.empty().append('Output of test will appear here...');
	
	if (status == 'hide') return true;
	
	if (status == 'success')
	{
		mainIcon.addClass('bg-green').removeClass('bg-red').removeClass('bg-grey')
		successIcon.show();
		messageBody.empty().append(text);
		return true;
	}
	if (status == 'error')
	{
		mainIcon.removeClass('bg-green').addClass('bg-red').removeClass('bg-grey')
		errorIcon.show();
		messageBody.empty().append('<pre>'+text+'</pre>');
		return false;
	}
	
	return false;
}

function applyConfigStatusChange(status,text)
{
	var mainIcon = $('.applyConfigurationItem i.applyIcon')
	var endofTimelineIcon = $('.endOfTimeine i')
	var successIcon = $('.applyConfigurationItem i.applySuccess')
	var errorIcon = $('.applyConfigurationItem i.applyError')
	var messageBody = $('.applyConfigurationItem div.applyItemBody')
	
	mainIcon.removeClass('bg-green').removeClass('bg-red').addClass('bg-grey')
	endofTimelineIcon.removeClass('bg-green fa-check').addClass('bg-grey fa-clock-o')
	successIcon.hide(); errorIcon.hide();
	messageBody.empty().append('Output of the save process will appear here...');
	
	if (status == 'hide') return true;
	
	if (status == 'success')
	{
		mainIcon.addClass('bg-green').removeClass('bg-red').removeClass('bg-grey')
		successIcon.show();
		messageBody.empty().append(text);
		endofTimelineIcon.removeClass('bg-grey fa-clock-o').addClass('bg-green fa-check')
		return true;
	}
	if (status == 'error')
	{
		mainIcon.removeClass('bg-green').addClass('bg-red').removeClass('bg-grey')
		errorIcon.show();
		messageBody.empty().append('<pre>'+text+'</pre>');
		return false;
	}
	
	return false;
}

$('.testConfigurationBtn').click(function (){
	$('errorMessage').remove()
	testConfigStatusChange('hide','false')
	applyConfigStatusChange('hide','false')
	var data = {
		"action": "get",
		"contentType": "json",
		"confTest": "on",
		};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/config/generate/file/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			if (!data['confTest']['error']) 
			{
				testConfigStatusChange('success',data['confTest']['message'])
	
				return;
			}
			var someErrorText = (data['confTest']['message']) ? data['confTest']['message'] : 'Unknown error :(';
			testConfigStatusChange('error',someErrorText)
			if (data['confTest']['errorLine'] != undefined) {
				$('line#line_num_'+data['confTest']['errorLine']).append('<errorMessage><i class="fa  fa-exclamation-triangle"></i> Error here!</errorMessage>')
				$('errorMessage').addClass('shakeIt');
			}
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	})
})

$('.applyConfigurationBtn').click(function (){
	$('errorMessage').remove()
	testConfigStatusChange('hide','false')
	applyConfigStatusChange('hide','false')
	var data = {
		"action": "get",
		"contentType": "json",
		"confSave": "yes",
		"doBackup": $('input.doBackup').prop('checked'),
		};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/config/generate/file/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			if (data['confTest']['error']) 
			{
				testConfigStatusChange('error',data['confTest']['message'])
				if (data['confTest']['errorLine'] != undefined) {
					$('line#line_num_'+data['confTest']['errorLine']).append('<errorMessage><i class="fa  fa-exclamation-triangle"></i> Error here!</errorMessage>')
					$('errorMessage').addClass('shakeIt');
				}
				return;
			}
			
			testConfigStatusChange('success',data['confTest']['message'])
			
			if (data['applyStatus']['error']) 
			{
				applyConfigStatusChange('error',data['applyStatus']['message'])
				return;
			}
			
			applyConfigStatusChange('success',data['applyStatus']['message'])
			changeApplyStatus(0)
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	})
})
var line_number_span="";
var line_number=0;
function line_number_html(){
	line_number_span+='<span></span>';
	line_number++
	return '<line class="text-red" id="line_num_'+line_number+'"></line>';
}
//////////CONFIGURATION BUILDER//////
function outputConfigurationParser(arrayPart)
{
	for (someArr = 0; someArr < arrayPart.length; someArr++)
	{
		var some = arrayPart[someArr];
		for (var someLine = 0; someLine < some.length; someLine++)
		{
			if (someLine == 0)
			{
				$('code.tacacs_config').append(line_number_html()).append(some[someLine]['name'])
					.append('\n');
				continue;
			}
			if (someLine == 1)
			{
				$('code.tacacs_config').append(line_number_html()).append('\t').append(some[someLine].replace(/\n/g,''))
					.append('\n')
				continue;
			} 
			if (some.length == someLine+1)	
			{
				$('code.tacacs_config').append(line_number_html()).append('\t').append(some[someLine].replace(/\n/g,''))
					.append('\n');
			} else
			{
				$('code.tacacs_config')
					.append(line_number_html())
					.append('\t')
					.append(some[someLine].replace(/\n/g,''))
					.append('\n');
			}
		}
	}
}
///////////////////////////////
/////////AUTH CHECK///START//
var data = {
		"action": "get",
		"html": true,
		"test" : "none"
		};	
$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/config/generate/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			//SPAWND //START//
			$('pre.configurationFile').empty()
			$('pre.configurationFile').append('<code class="tacacs_config language-none"></code>')
			$('code.tacacs_config').append(line_number_html()).append('id = spawnd {').append('\n');
			outputConfigurationParser(data['spawndConfig'])
			$('code.tacacs_config').append(line_number_html()).append('}').append('\n');
			//SPAWND //END//
			/////////////////////
			//TACACS GENERAL CONF //START//
			$('code.tacacs_config').append(line_number_html()).append('id = tac_plus {').append('\n');
			outputConfigurationParser(data['tacGeneralConfig'])
			//TACACS GENERAL CONF //END//
			/////////////////////
			//MAVIS GENERAL SETTINGS //START//
			outputConfigurationParser(data['mavisGeneralConfig'])
			//MAVIS GENERAL SETTINGS //END//
			/////////////////////
			//MAVIS OTP SETTINGS //START//
			outputConfigurationParser(data['mavisOTPConfig'])
			//MAVIS OTP SETTINGS //END//
			/////////////////////
			//MAVIS LDAP SETTINGS //START//
			outputConfigurationParser(data['mavisLdapConfig'])
			//MAVIS LDAP SETTINGS //END//
			/////////////////////
			//DEVICE GROUP LIST //START//
			outputConfigurationParser(data['deviceGroupsConfig'])
			//DEVICE GROUP LIST //END//
			/////////////////////
			//DEVICE LIST //START//
			outputConfigurationParser(data['devicesConfig'])
			//DEVICE LIST //END//
			/////////////////////
			//ACL LIST //START//
			outputConfigurationParser(data['tacACL'])
			//ACL LIST //END//
			/////////////////////
			//USER GROUP LIST //START//
			outputConfigurationParser(data['userGroupsConfig'])
			//USER GROUP LIST //END//
			/////////////////////
			/////////////////////
			//USER LIST //START//
			outputConfigurationParser(data['usersConfig'])
			//USER LIST //END//
			///////////////////
			$('code.tacacs_config').append(line_number_html()).append('}###END OF GLOBAL PARAMETERS').append('\n');
			////END OF GLOBAL PARAMETERS////
			$('code.tacacs_config').append('<span aria-hidden="true" class="line-numbers-rows"></span>')
			$('span.line-numbers-rows').append(line_number_span)
			
		},
		error: function(data) {
			//console.log(data);
			//errorHere(data);
		}
});
/////////AUTH CHECK///END////