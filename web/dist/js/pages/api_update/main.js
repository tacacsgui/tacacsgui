checkConfiguration()
getUserInfo()

var checkUpdate = $('div.icheck input.update_signin')

	checkUpdate.iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

function localInfo() {
	
	var data = {
		"action": "GET",
		"test" : "none"
	};	
	
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"update/info/",
		data: data,
		success: function(data) {
			console.log(data);
			$('input.update_url').val(data.info.update_url);
			$('input.update_key').val(data.info.update_key);
			$('span.activated').text( (data.info.update_activated == 1) ? 'Activated' : 'Not Activated' );
			if (data.info.update_signin == 1) { checkUpdate.iCheck('check') }
			else { checkUpdate.iCheck('uncheck') }
			checkUpdate.iCheck('enable')
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}

localInfo();

function chnageUpdateSettings(settings){
	if (settings == undefined) return;
	
	var data = {
		"action": "POST",
		"settings": settings,
		"update_signin": (checkUpdate.prop('checked')) ? 1 : 0 ,
		"test" : "none"
	};	
	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"update/change/",
		data: data,
		success: function(data) {
			console.log(data);
			localInfo();
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	})
}

$('button.generate').click(function(){
	if (!confirm('Are you sure? You will lost the previous key.')) return;
	chnageUpdateSettings(2)
})

checkUpdate.on('ifToggled', function(){
	chnageUpdateSettings(1)
})

$('button.check_update').click(function(){
	$('div.update_output').show();
	var data = {
		"action": "POST",
		"test" : "none"
	};	
	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"update/",
		data: data,
		success: function(data) {
			console.log(data);
			$('pre.update_log').empty();
			if (data.output == null || data.output == undefined){
				$('pre.update_log').append('<p>Error appeared</p>')
					.append('<p>Reason: Didn\'t get response form server</p>');
				$('div.update_output').hide();
				return;
			}
			if (data.output.error.message !== undefined){
				$('pre.update_log').append('<p>Error appeared</p>')
					.append('<p>Reason: '+data.output.error.message+'</p>');
				$('div.update_output').hide();
				return;
			}
			$('pre.update_log').append('<p>Hello '+data.output.user.username+'</p>')
				.append('<p>Your api version: '+data.info.version.APIVER+'</p>')
				.append('<p>Last availabel version: '+data.output.last_version.version+'</p>')
				.append('<p>Brief description: '+data.output.last_version.description_brief+'</p>')
				.append('<p>More description: '+data.output.last_version.description_more+'</p>')
			if (data.info.version.APIVER !== data.output.last_version.version){
				$('pre.update_log').append('<p class="text-center"><b>Push button below to update</b></p>')
				$('div.upgrade').show();
			} else {
				$('pre.update_log').append('<p class="text-center"><b>Your have newest version</b></p>')
			}
			localInfo();
			$('div.update_output').hide();
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	})
})

function upgrade(){
	var data = {
		"action": "POST",
		"test" : "none"
	};	
	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"update/upgrade/",
		data: data,
		success: function(data) {
			console.log(data);
			$('div.update_output').hide();
			if (data.upgrade == null){
				toastr["error"]("Something goes wrong :(");
				return;
			}
			signout();
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	})
}