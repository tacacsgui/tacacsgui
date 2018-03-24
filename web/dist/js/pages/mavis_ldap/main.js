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
////TOUGLE LDAP ENABLED////START///
$('div.enabled input').on('ifToggled', function(event){
	console.log(event);
  ($('div.enabled input').prop( "checked" )) ? $('div.ldap-enabled').hide() : $('div.ldap-enabled').show()
});
////TOUGLE LDAP ENABLED////END///
////////////////////////////////
////GET LDAP PARAMETERS////START//
function getLdapParams()
{
	var data = {
		"action": "GET",
		"test" : "none"
		};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"mavis/ldap/",
		cache: false,
		async: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('div.enabled input').iCheck( (data.LDAP_Params.enabled == 1) ? 'check' : 'uncheck');
			(data.LDAP_Params.enabled == 1) ? $('div.ldap-enabled').hide() : $('div.ldap-enabled').show()
			$('select.ldap_type').val(data.LDAP_Params.type);
			$('select.ldap_scope').val(data.LDAP_Params.scope);
			$('div.tls input').iCheck( (data.LDAP_Params.tls == 1) ? 'check' : 'uncheck');
			$('input.hosts').val(data.LDAP_Params.hosts);
			$('input.user').val(data.LDAP_Params.user);
			$('input.password').val(data.LDAP_Params.password);
			$('input.base').val(data.LDAP_Params.base);
			$('input.filter').val(data.LDAP_Params.filter);
			$('div.memberOf input').iCheck( (data.LDAP_Params.memberOf == 1) ? 'check' : 'uncheck');
			$('div.group_prefix_flag input').iCheck( (data.LDAP_Params.group_prefix_flag == 1) ? 'check' : 'uncheck');
			$('input.group_prefix').val(data.LDAP_Params.group_prefix);
			$('div.cache_conn input').iCheck( (data.LDAP_Params.cache_conn == 1) ? 'check' : 'uncheck');
			$('div.fallthrough input').iCheck( (data.LDAP_Params.fallthrough == 1) ? 'check' : 'uncheck');
			$('input.path').val(data.LDAP_Params.path);
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
getLdapParams()
////GET LDAP PARAMETERS////END//
/////////////////////
$('button.submit').click(function(){
	var data = {
		"action": "POST",
		"enabled" : ( ( $('div.enabled input').prop( "checked" ) ) ? 1 : 0 ) ,
		"ldap_type" : $('select.ldap_type').val(),
		"ldap_scope" : $('select.ldap_scope').val(),
		"tls" : ( ( $('div.tls input').prop( "checked" ) ) ? 1 : 0 ) ,
		"hosts" : $('input.hosts').val(),
		"user" : $('input.user').val(),
		"password" : $('input.password').val(),
		"base" : $('input.base').val(),
		"filter" : $('input.filter').val(),
		"memberOf" : ( ( $('div.memberOf input').prop( "checked" ) ) ? 1 : 0 ) ,
		"group_prefix_flag" : ( ( $('div.group_prefix_flag input').prop( "checked" ) ) ? 1 : 0 ) ,
		"group_prefix" : $('input.group_prefix').val(),
		"cache_conn" : ( ( $('div.cache_conn input').prop( "checked" ) ) ? 1 : 0 ) ,
		"fallthrough" : ( ( $('div.fallthrough input').prop( "checked" ) ) ? 1 : 0 ) ,
		"path" : $('input.path').val(),
		"test" : "none",
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"mavis/ldap/",
		cache: false,
		async: false,
		data: data,
		success: function(data) {
			console.log(data);
			if (data.mavis_ldap_update == 1) {
				toastr["success"]("LDAP settings was saved")
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

$('button.ldap-check').click(function(){
	$('pre.ldap-check-output').empty().append('Loading...'+"\n");
	$('div.ldap-check-alert').empty().hide();
	
	username = $('input.ldap-check-username').val()
	password = $('input.ldap-check-password').val()
	
	errormessage = '';
	
	if (username == ''){
		errormessage += '<p>Where is username?!</p>';
	}
	
	if (password == ''){
		errormessage += '<p>Where is password?!</p>';
	}
	
	if (errormessage !== ''){
		$('div.ldap-check-alert').append(errormessage).show();
		$('pre.ldap-check-output').empty().append(errormessage);
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
		url: API_LINK+"mavis/ldap/check/",
		cache: false,
		async: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('pre.ldap-check-output').empty();
			$('pre.ldap-check-output').append(data.ldap_check);
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});	
})