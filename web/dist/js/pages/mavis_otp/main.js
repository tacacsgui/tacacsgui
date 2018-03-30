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
  ($('div.enabled input').prop( "checked" )) ? $('div.otp-enabled').hide() : $('div.otp-enabled').show()
});
////TOUGLE OTP ENABLED////END///
////////////////////////////////
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
			$('time.current-time').text(data.time);
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
getCurrentTime()
////////CHECK SERVER TIME////END///
///////////////////////////////////////
////GET OTP PARAMETERS////START//
function getOTPParams()
{
	var data = {
		"action": "GET",
		"test" : "none"
		};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"mavis/otp/",
		cache: false,
		async: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('div.enabled input').iCheck( (data.OTP_Params.enabled == 1) ? 'check' : 'uncheck');
			(data.OTP_Params.enabled == 1) ? $('div.otp-enabled').hide() : $('div.otp-enabled').show()
			$('select.digest').val(data.OTP_Params.digest);
			$('input.period').val(data.OTP_Params.period);
			$('input.digits').val(data.OTP_Params.digits);
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
getOTPParams()
////GET LDAP PARAMETERS////END//
/////////////////////
/////////////////////
$('button.submit').click(function(){
	var data = {
		"action": "POST",
		"enabled" : ( ( $('div.enabled input').prop( "checked" ) ) ? 1 : 0 ) ,
		"period" : $('input.period').val() ,
		"digits" : $('input.digits').val() ,
		"digest" : $('select.digest').val() ,
		"test" : "none",
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"mavis/otp/",
		cache: false,
		async: false,
		data: data,
		success: function(data) {
			console.log(data);
			if (data.mavis_otp_update == 1) {
				toastr["success"]("OTP settings was saved")
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

$('button.otp-check').click(function(){
	$('pre.otp-check-output').empty().append('Loading...'+"\n");
	$('div.otp-check-alert').empty().hide();
	
	username = $('input.otp-check-username').val()
	password = $('input.otp-check-password').val()
	
	errormessage = '';
	
	if (username == ''){
		errormessage += '<p>Where is username?!</p>';
	}
	
	if (password == ''){
		errormessage += '<p>Where is password?!</p>';
	}
	
	if (errormessage !== ''){
		$('div.otp-check-alert').append(errormessage).show();
		$('pre.otp-check-output').empty().append(errormessage);
		return;
	}
	
	var data = {
		"action": "POST",
		"username" : username,
		"password" : password,
		"test" : "none",
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"mavis/otp/check/",
		cache: false,
		async: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('pre.otp-check-output').empty();
			$('pre.otp-check-output').append(data.ldap_check);
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});	
})