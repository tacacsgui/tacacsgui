var tgui_signin = {
	signinForm: '#signinForm',
	chngPaswdForm: '#chngPaswdForm',
	init: function(){
		this.getInfo();
	},
	signin: function(){
		this.blockForm(true);
		this.errorBanner();
		var self = this;
    var formData = tgui_supplier.getFormData(self.signinForm);
    var ajaxProps = {
      url: API_LINK+"auth/singin/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
			var username = resp.info.user.username;
			if (resp.info && resp.info.user && resp.info.user.changePasswd == 1) {
				if (username) self.changePasswdForm(username)
				return;
			}
			if (resp.authorised) {window.location.replace('/dashboard.php'); return;}
			self.blockForm();
    }).fail(function(err){
			if (err.responseJSON.error.status && tgui_supplier.checkResponse(err.responseJSON.error, self.signinForm)){
				self.blockForm();
				if (err.responseJSON.error.message) self.errorBanner(err.responseJSON.error.message);
			  return;
			}
			self.blockForm();
    })
    return false;
	},
	getInfo: function(){
		var self = this;
		var ajaxProps = {
      url: API_LINK+"auth/singin/",
      type: "GET"
    };//ajaxProps END
		ajaxRequest.send(ajaxProps).then(function(resp) {
			$('tacversion').text(resp.info.version.TACVER);
			$('apiversion').text(resp.info.version.APIVER);
			$('guiversion').text(GUIVER);
			$('div#version_info').removeClass('hidden');
			if (resp.info.user.changePasswd == 1) {
				self.changePasswdForm(resp.info.user.username)
				return;
			}
			if (resp.authorised) window.location.replace('/dashboard.php');
    }).fail(function(err){
			$('tacversion').text(err.responseJSON.info.version.TACVER);
			$('apiversion').text(err.responseJSON.info.version.APIVER);
			$('guiversion').text(GUIVER);
			$('div#version_info').removeClass('hidden');
			$('div.loading').hide();
			self.blockForm();
    })
	},
	chngPasswd: function(){
		var self = this;
		self.blockForm(true);
		var formData = tgui_supplier.getFormData(self.chngPaswdForm);
		console.log(formData);
		var ajaxProps = {
			url: API_LINK+"auth/singin/changePassword/",
			data: formData
		};//ajaxProps END
		ajaxRequest.send(ajaxProps).then(function(resp) {
			if (resp.error.status && tgui_supplier.checkResponse(resp.error, self.signinForm)){
				self.blockForm();
			  return;
			}
			if (resp.status == 1) {window.location.replace('/dashboard.php'); return;}
			self.blockForm();
    }).fail(function(err){
			tgui_error.getStatus(err, ajaxProps)
    })
		return false;
	},
	blockForm: function(action){
		action = action || false;
		if (action) $('div.form_block').show();
		else $('div.form_block').hide();
		return true;
	},
	errorBanner: function(message){
		message = message || false
		if (!message) { $('div.alert.alert-danger').hide(); return; }
		$('div.alert.alert-danger').empty().append('<p>'+message+'</p>').show();
	},
	changePasswdForm: function(username) {
		$('username i').text(username)
		$('div.alert.alert-warning.changePasswd').show()
		$('form'+this.signinForm).hide()
		$('form'+this.chngPaswdForm).show()
		$('div.loading').hide();
		this.blockForm()
	}
}


// function changePasswdForm(username)
// {
// 	$('form.signin').hide()
// 	$('form.changePasswd').show()
// 	$('username i').text(username)
// 	$('div.alert.alert-warning.changePasswd').show()
// 	$('div.loading').hide();
// 	blockForm(false)
// }

// var data = {
// 		"action": "get",
// 		"test" : "none"
// 		};
// $.ajax({
// 		type: "GET",
// 		dataType: "json",
// 		url: API_LINK+"auth/singin/",
// 		cache: false,
// 		data: data,
// 		success: function(data) {
// 			console.log(data);
// 			$('tacversion').text(data['info']['version']['TACVER']);
// 			$('apiversion').text(data['info']['version']['APIVER']);
// 			$('guiversion').text(GUIVER);
// 			$('div#version_info').removeClass('hidden');
// 			if (data.info.user.changePasswd == 1) {
// 				changePasswdForm(data.info.user.username)
// 				return;
// 			}
// 			if (data['authorised']) window.location.replace('/dashboard.php');
// 		},
// 		error: function(data) {
// 			console.log(data);
// 			$('tacversion').text(data['responseJSON']['info']['version']['TACVER']);
// 			$('apiversion').text(data['responseJSON']['info']['version']['APIVER']);
// 			$('guiversion').text(GUIVER);
// 			$('div#version_info').removeClass('hidden');
// 			$('div.loading').hide();
// 		}
// });

// function blockForm(booleanVal)
// {
// 	if (booleanVal) { $('div.form_block').show(); return;}
// 	$('div.form_block').hide();
// }

// $('#submit_btn').click(function (e){
// 	e.preventDefault();
// 	blockForm(true)
// 	//INITIATION ///
// 	$('div.alert.alert-danger').empty();
// 	$('div.alert.alert-danger').addClass('hidden');
// 	$('#username').parent('div').removeClass('has-error');
// 	$('#password').parent('div').removeClass('has-error');
// 	var username = $('#username').val();
// 	var password = $('#password').val();
// 	var error_message='';
// 	/////////////////////////////////
// 	/////////////////////////////////
// 	if (username == '') {
// 		$('#username').parent('div').addClass('has-error');
// 		error_message+="<p class='text-ceter'>The field username can't be empty</p>";
// 	}
// 	if (password == '') {
// 		$('#password').parent('div').addClass('has-error');
// 		error_message+="<p class='text-ceter'>The field password can't be empty</p>";
// 	}
// 	if (!(error_message==='')){
// 		$('div.alert.alert-danger').append(error_message);
// 		$('div.alert.alert-danger').removeClass('hidden');
// 		blockForm(false)
// 		return;
// 	}
// 	var data = {
// 		"action": "get",
// 		"username": username,
// 		"password": password,
// 		"test" : "none"
// 		};
// 	$.ajax({
// 			type: "POST",
// 			dataType: "json",
// 			url: API_LINK+"auth/singin/",
// 			cache: false,
// 			data: data,
// 			success: function(data) {
// 				console.log(data);
// 				if (data.info.user.changePasswd == 1) {
// 					changePasswdForm(data.info.user.username)
// 					return;
// 				}
// 				if (data['authorised']) {window.location.replace('/dashboard.php'); return;}
// 				blockForm(false)
// 			},
// 			error: function(data) {
// 				console.log(data['responseJSON']);
// 				$('div.alert.alert-danger').append(data['responseJSON']['error']['message']);
// 				$('div.alert.alert-danger').removeClass('hidden');
// 				blockForm(false)
// 			}
// 	});
// })


$('#change_submit_btn').click(function (e){
	e.preventDefault();
	blockForm(true)
	//INITIATION ///
	$('div.alert.alert-danger').empty();
	$('div.alert.alert-danger').addClass('hidden');
	$('#change_password').parent('div').removeClass('has-error');
	$('#change_reppassword').parent('div').removeClass('has-error');
	var reppassword = $('#change_reppassword').val();
	var password = $('#change_password').val();
	var error_message='';
	/////////////////////////////////
	/////////////////////////////////
	if (password == '') {
		$('#change_password').parent('div').addClass('has-error');
		error_message+="<p class='text-ceter'>The field password can't be empty</p>";
	}
	if (!(error_message==='')){
		$('div.alert.alert-danger').append(error_message);
		$('div.alert.alert-danger').removeClass('hidden');
		blockForm(false)
		return;
	}
	var data = {
		"action": "get",
		"reppassword": reppassword,
		"password": password,
		"test" : "none"
		};
	$.ajax({
			type: "POST",
			dataType: "json",
			url: API_LINK+"auth/singin/changePassword/",
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
							//$(addForm + ' div.'+v).addClass('has-error')
							//$('div.form-group.'+v+' p.help-block').hide()
							var error_message='';
							for (num in data['error']['validation'][v]){
								error_message='<p>'+data['error']['validation'][v][num]+'</p>';
							}
							$('div.alert.alert-danger').append(error_message)
							$('div.alert.alert-danger').removeClass('hidden');
							//toastr["error"](data['error']['validation'][v][num])
						}
					}
					blockForm(false)
					return;
				}
				if (data.status == 1) {window.location.replace('/dashboard.php'); return;}
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
