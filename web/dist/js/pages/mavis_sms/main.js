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
////TOUGLE OTP ENABLED////START///
$('div.enabled input').on('ifToggled', function(event){
	console.log(event);
  ($('div.enabled input').prop( "checked" )) ? $('div.sms-enabled').hide() : $('div.sms-enabled').show()
});
////TOUGLE OTP ENABLED////END///
////////////////////////////////
////GET SMS PARAMETERS////START//
function getSMSParams()
{
	var data = {
		"action": "GET",
		"test" : "none"
		};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"mavis/sms/",
		cache: false,
		async: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('div.enabled input').iCheck( (data.SMS_Params.enabled == 1) ? 'check' : 'uncheck');
			(data.SMS_Params.enabled == 1) ? $('div.otp-enabled').hide() : $('div.otp-enabled').show()
			$('input.ipaddr').val(data.SMS_Params.ipaddr);
			$('input.port').val(data.SMS_Params.port);
			$('input.login').val(data.SMS_Params.login);
			$('input.pass').val(data.SMS_Params.pass);
			$('input.srcname').val(data.SMS_Params.srcname);
		},
		error: function(data) {
			//console.log(data);
			//errorHere(data);
		}
	});
}
getSMSParams()
////GET SMS PARAMETERS////END//
/////////////////////
/////////////////////
$('button.submit').click(function(){
	var data = {
		"action": "POST",
		"enabled" : ( ( $('div.enabled input').prop( "checked" ) ) ? 1 : 0 ) ,
		"ipaddr" : $('input.ipaddr').val() ,
		"port" : $('input.port').val() ,
		"login" : $('input.login').val() ,
		"pass" : $('input.pass').val() ,
		"srcname" : $('input.srcname').val() ,
		"test" : "none",
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"mavis/sms/",
		cache: false,
		async: false,
		data: data,
		success: function(data) {
			console.log(data);
			if (data.mavis_sms_update == 1) {
				toastr["success"]("SMS settings was saved")
				changeApplyStatus(data['changeConfiguration'])
				window.scrollTo(0, 0);
				return;
			}
			toastr["error"]("Something goes wrong :(")
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
})
/////////////////////
$('button.send_sms').click(function(){
	
	$('pre.sms-check-output').empty().append('Loading...'+"\n");
	$('div.sms-check-alert').empty().hide();
	
	username = $('input.sms-send-username').val()
	number = $('input.sms-send-number').val()
	
	errormessage = '';
	
	if (username == '' && number == ''){
		errormessage += '<p>Please insert usename or phone number</p>';
	}
	
	if (errormessage !== ''){
		$('div.sms-check-alert').append(errormessage).show();
		$('pre.sms-check-output').empty().append(errormessage);
		return;
	}
	
	var data = {
		"action": "POST",
		"ipaddr" : $('input.ipaddr').val() ,
		"port" : $('input.port').val() ,
		"login" : $('input.login').val() ,
		"pass" : $('input.pass').val() ,
		"srcname" : $('input.srcname').val() ,
		"username" : $('input.sms-send-username').val() ,
		"number" : $('input.sms-send-number').val() ,
		"test" : "none",
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"mavis/sms/send/",
		cache: false,
		async: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('pre.sms-check-output').empty();
			$('pre.sms-check-output').append(data.smpp_check);
		},
		error: function(data) {
			//console.log(data);
			//errorHere(data);
		}
	});
})