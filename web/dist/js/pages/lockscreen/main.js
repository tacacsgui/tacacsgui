function signout()
{
	var data = {
		"action": "get",
		"test" : "none"
	};	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"/auth/singout/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
		},
		error: function(data) {
			console.log(data['responseJSON']);
		}
	});
}

///////////////////////////////////
/////////GET USER INFO///START//
var data = {
		"action": "get",
		"test" : "none"
		};	
$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"/user/info/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('tacversion').text(data['info']['version']['TACVER']);
			$('apiversion').text(data['info']['version']['APIVER']);
			$('guiversion').text(GUIVER);
			$('#version_info').show();
			if (data.authorised){
				$('firstname_info').text(data['user']['firstname'] + ' ')
				$('surname_info').text(data['user']['surname'])
				$('position_info').text(data['user']['position'])
				$('#username').val(data.info.user.username)
				$('div.loading').hide();
			}
			
		},
		error: function(data) {
			//console.log(data['responseJSON']);
			window.location.replace('/')
		}
});
/////////GET USER INFO///END////
///////////////////////////////////

$('document').ready(function(){
	signout();
})

function blockForm(booleanVal)
{
	if (booleanVal) { $('div.form_block').show(); return;}
	$('div.form_block').hide();
}

var attempt=1;

$('#submit_btn').click(function (e){
	e.preventDefault();
	//INITIATION ///
	blockForm(true)
	$('div.alert.alert-danger').empty();
	$('div.alert.alert-danger').hide();
	$('#username').parent('div').removeClass('has-error');
	$('#password').parent('div').removeClass('has-error');
	var username = $('#username').val();
	var password = $('#password').val();
	var error_message='';
	var attemptMessage=" Attempt number " + attempt;
	/////////////////////////////////
	if (password == '') {
		$('#password').parent('div').addClass('has-error');
		error_message+="<p class='text-ceter'>The field password can't be empty."+attemptMessage+"</p>";
	}
	if (!(error_message==='')){
		$('div.alert.alert-danger').append(error_message);
		$('div.alert.alert-danger').show();
		attempt++
		if (attempt > 3) {window.location.replace('/'); return;}
		return;
	}
	var data = {
		"action": "get",
		"username": username,
		"password": password,
		"test" : "none"
		};	
	$.ajax({
			type: "POST",
			dataType: "json",
			url: API_LINK+"auth/singin/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				if (data['authorised']) {window.location.replace('/dashboard.php'); return;}
				blockForm(false)
			},
			error: function(data) {
				console.log(data['responseJSON']);
				$('div.alert.alert-danger').append(data['responseJSON']['error']['message']+attemptMessage);
				$('div.alert.alert-danger').show();
				attempt++
				if (attempt > 3) {window.location.replace('/'); return;}
				blockForm(false)
			}
	}); 
})