var data = {
		"action": "get",
		"test" : "none"
		};	
$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"auth/singin/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('tacversion').text(data['info']['version']['TACVER']);
			$('apiversion').text(data['info']['version']['APIVER']);
			$('guiversion').text(GUIVER);
			$('div#version_info').removeClass('hidden');
			if (data['authorised']) window.location.replace('/dashboard.php');
		},
		error: function(data) {
			console.log(data);
			$('tacversion').text(data['responseJSON']['info']['version']['TACVER']);
			$('apiversion').text(data['responseJSON']['info']['version']['APIVER']);
			$('guiversion').text(GUIVER);
			$('div#version_info').removeClass('hidden');
			$('div.loading').hide();
		}
});

function blockForm(booleanVal)
{
	if (booleanVal) { $('div.form_block').show(); return;}
	$('div.form_block').hide();
}

$('#submit_btn').click(function (e){
	e.preventDefault();
	blockForm(true)
	//INITIATION ///
	$('div.alert.alert-danger').empty();
	$('div.alert.alert-danger').addClass('hidden');
	$('#username').parent('div').removeClass('has-error');
	$('#password').parent('div').removeClass('has-error');
	var username = $('#username').val();
	var password = $('#password').val();
	var error_message='';
	/////////////////////////////////
	/////////////////////////////////
	if (username == '') {
		$('#username').parent('div').addClass('has-error');
		error_message+="<p class='text-ceter'>The field username can't be empty</p>";
	}
	if (password == '') {
		$('#password').parent('div').addClass('has-error');
		error_message+="<p class='text-ceter'>The field password can't be empty</p>";
	}
	if (!(error_message==='')){
		$('div.alert.alert-danger').append(error_message);
		$('div.alert.alert-danger').removeClass('hidden');
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
				$('div.alert.alert-danger').append(data['responseJSON']['error']['message']);
				$('div.alert.alert-danger').removeClass('hidden');
				blockForm(false)
			}
	}); 
})