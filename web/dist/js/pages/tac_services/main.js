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
///////////////////////////////////////
//////CHANGE PRIVILEGE LEVEL//////START///
function setPrivLvl(action){
	var privLvl = parseInt($('input[name="priv-lvl"]').val());
	switch(action) {
    case 'add':
        if (privLvl >= 15) return;
		$('input[name="priv-lvl"]').val(privLvl + 1 );
        break;
    case 'subtract':
        if (privLvl <= -1) return;
		$('input[name="priv-lvl"]').val(privLvl - 1);
        break;
	case 'unset':
        $('input[name="priv-lvl"]').val(-1);
        break;
	}
}
//////CHANGE PRIVILEGE LEVEL//////END///
///////////////////////////////////////
////ADD SERVICE FUNCTION///START//
function addService(){
	console.log('Adding new tacacs service');
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	/////////ADD NEW SERVICE///START//
	var data = {
		"action": "POST",
		"name": $(addForm + ' input[name="name"]').val(),
		"priv-lvl": $(addForm + ' input[name="priv-lvl"]').val(),
		"default_cmd": $(addForm + ' input[name="default_cmd"]').prop('checked'),
		"manual_conf_only": $(addForm + ' input[name="manual_conf_only"]').prop('checked'),
		"manual": $(addForm + ' textarea[name="manual"]').val(),
		"test" : "none"
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/services/add/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			if (data['error']['status']){
				//console.log(data['error']['validation'])
				for (v in data['error']['validation']){
					//console.log(v)
					if (!(data['error']['validation'][v] == null)){
						//console.log($(addForm + ' div.'+v))
						$(addForm + ' div.'+v).addClass('has-error')
						$('div.form-group.'+v+' p.help-block').hide()
						var error_message='';
						for (num in data['error']['validation'][v]){
							error_message='<p class="text-red">'+data['error']['validation'][v][num]+'</p>';
						}
						$('div.form-group.'+v).append(error_message)
					}
				}
				return;
			}
			toastr["success"]("Service "+ $(addForm + ' input[name="name"]').val() +" was added")
			$("#addService").modal("hide");
			changeApplyStatus(data['changeConfiguration'])
			clearAddServiceModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
	
}
///////////////////////////
function clearAddServiceModal(){
	$(addForm + ' input[name="name"]').val('')
	
	$(addForm + ' input[name="default_cmd"]').iCheck('check')
	$(addForm + ' input[name="manual_conf_only"]').iCheck('uncheck')
	$(addForm + ' textarea[name="manual"]').val('')
	$('.form-group.has-error').removeClass('has-error');
	
	// Select first tab
	$(addForm + ' .nav-tabs-custom a:first').tab('show') 
	
	$('p.text-red').remove();
	$('p.help-block').show();
	
	//Unset Priv-Lvl//
	$('input[name="priv-lvl"]').val(-1);
}
////ADD SERVICE FUNCTION///END//
/////////////////////////////////////////////
////DELETE SERVICE FUNCTION////START//
function deleteService(id,serviceName){
	console.log('Deleting ServiceID:'+id+' with name '+serviceName)
	if (confirm("Do you want delete '"+serviceName+"'?")){
		/////////DELETE SERVICE///START//
		var data = {
			"action": "POST",
			"name": serviceName,
			"id": id,
			"test" : "none"
			};	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: API_LINK+"tacacs/services/delete/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				if(data['deleteService']!=1){toastr["error"]("Oops! Unknown error appeared :(");return;}
				toastr["success"]("Service "+ serviceName +" was deleted")	
				changeApplyStatus(data['changeConfiguration'])
				setTimeout( function () {dataTable.ajax.reload()}, 2000 );
			},
			error: function(data) {
				//console.log(data);
				errorHere(data);
			}
		});
		/////////DELETE SERVICE///END////
	}
	return;
}
////DELETE SERVICE FUNCTION////END//
/////////////////////////////
////EDIT SERVICE FUNCTION///START//
function editService(id,serviceName){ //GET INFO ABOUT SERVICE//
	var data = {
		"action": "GET",
		"name": serviceName,
		"id": id,
		"test" : "none"
	};
	$.ajax({
		type: "GET",
		dataType: "json",
		url: API_LINK+"tacacs/services/edit/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			$('serviceName.text-green').text(data['service']['name'])
			$(editForm + ' input[name="id"]').val(data['service']['id'])
			$(editForm + ' input[name="name"]').val(data['service']['name'])
			$(editForm + ' input[name="name_old"]').val(data['service']['name'])
			
			$(editForm + ' input[name="priv-lvl"]').val(parseInt(data['service']['priv-lvl']))
			
			var default_cmd = (data['service']['default_cmd'] == 1) ? 'check' : 'uncheck';
			$(editForm + ' input[name="default_cmd"]').iCheck(default_cmd)
			var manual_conf_only = (data['service']['manual_conf_only'] == 1) ? 'check' : 'uncheck';
			$(editForm + ' input[name="manual_conf_only"]').iCheck(manual_conf_only)
			
			$(editForm + ' textarea[name="manual"]').val(data['service']['manual'])
			
			$('text.created_at').text('Created at '+data['service']['created_at']);
			$('text.updated_at').text('Last update was at '+data['service']['updated_at']);
			$('#editService').modal('show')
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}//GET INFO ABOUT DEVICE//END//
///////////////////////////////////////
function submitServiceChanges(){
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
		var data = {
		"action": "POST",
		"id": $(editForm + ' input[name="id"]').val(),
		"name": $(editForm + ' input[name="name"]').val(),
		"name_old": $(editForm + ' input[name="name_old"]').val(),
		"priv-lvl": $(editForm + ' input[name="priv-lvl"]').val(),
		"default_cmd": $(editForm + ' input[name="default_cmd"]').prop('checked'),
		"manual_conf_only": $(editForm + ' input[name="manual_conf_only"]').prop('checked'),
		"manual": $(editForm + ' textarea[name="manual"]').val(),
		"test" : "none"
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/services/edit/",
		cache: false,
		data: data,
		success: function(data) {
			console.log(data);
			if (data['error']['status']){
				//console.log(data['error']['validation'])
				for (v in data['error']['validation']){
					//console.log(v)
					if (!(data['error']['validation'][v] == null)){
						//console.log($('editForm + ' div.'+v))
						$(editForm + ' div.'+v).addClass('has-error')
						$('div.form-group.'+v+' p.help-block').hide()
						var error_message='';
						for (num in data['error']['validation'][v]){
							error_message='<p class="text-red">'+data['error']['validation'][v][num]+'</p>';
						}
						$('div.form-group.'+v).append(error_message)
					}
				}
				return;
			}
			toastr["success"]("Service "+ $(editForm + ' input[name="name"]').val() +" was updated")
			$("#editService").modal("hide");
			changeApplyStatus(data['changeConfiguration'])
			clearEditServiceModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
///////////////////////////
function clearEditServiceModal(){
	$(editForm + ' input[name="name"]').val('')
	
	$(editForm + ' input[name="default_cmd"]').iCheck('check')
	$(editForm + ' input[name="manual_conf_only"]').iCheck('uncheck')
	$(editForm + ' textarea[name="manual"]').val('')
	$('.form-group.has-error').removeClass('has-error');
	
	// Select first tab
	$(editForm + ' .nav-tabs-custom a:first').tab('show') 
	
	$('p.text-red').remove();
	$('p.help-block').show();
	
	//Unset Priv-Lvl//
	$('input[name="priv-lvl"]').val(-1);
}
////EDIT DEVICE FUNCTION///END//
////////////////////////////////
////CLEAR MODALS FUNCTIONS//////
$('#addService').on('hidden.bs.modal', function(){
	clearAddServiceModal()
})
$('#editService').on('hidden.bs.modal', function(){
	clearEditServiceModal()
})
////////////////////////////////