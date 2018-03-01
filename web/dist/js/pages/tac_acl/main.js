checkConfiguration()
getUserInfo()
///////////////////////////
function clearAddACLModal(){
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	$(addForm+' input[name="name"]').val('')
	dataTable_add_acl.clear().draw();
}
function clearEditACLModal(){
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	$(editForm+' input[name="name"]').val('')
	dataTable_edit_acl.clear().draw();
	deletedRow=[];
}
///////////////////////////
////////////////////////////////
////CLEAR MODALS FUNCTIONS//////
$('#addACL').on('hidden.bs.modal', function(){
	clearAddACLModal()
})
$('#editACL').on('hidden.bs.modal', function(){
	clearEditACLModal()
})
////////////////////////////////
////ADD ACL//////////START///
function addACL()
{
	if (checkACEEditor()) {return;}
	console.log('Adding new ACL');
	var rowsData = dataTable_add_acl.rows().data();
	var name = $(addForm+' input[name="name"]').val()
	var	ACEs = [] ;
		ACEs[0] = {'name': name, 'line_number': 0, 'nac':'', 'nas':'', 'timerange':''} ;
	var aceIndex=1;
		rowsData.map(function(val, index){ 
			ACEs[aceIndex] = {
				//'name': val.name, 
				'line_number': val.line_number, 
				'action':val.action, 
				'nac':val.nac, 
				'nas':val.nas, 
				'timerange':val.timerange
			}
			if (val.id != undefined) ACEs[aceIndex].id = val.id
			
			aceIndex++
		})
		console.log(ACEs);
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	var data = {
		"action": "POST",
		"name": name,
		"ACEs": ACEs,
		"test" : "none"
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/acl/add/",
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
						$(addForm+' div.'+v).addClass('has-error')
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
			toastr["success"]("ACL "+ $(addForm+' input[name="name"]').val() +" was added")
			$("#addACL").modal("hide");
			changeApplyStatus(data['changeConfiguration'])
			clearAddACLModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
////ADD ACL//////////END///
///////////////////////////
////DELETE ACL//////////START///
function deleteACL(id,name)
{
	console.log('Deleting ACLid:'+id+' with name '+name)
	if (confirm("Do you want delete '"+name+"'?")){
		/////////DELETE DEVICE///START//
		var data = {
			"action": "POST",
			"name": name,
			"id": id,
			"test" : "none"
			};	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: API_LINK+"tacacs/acl/delete/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				if(data['deleteACL'] < 1){toastr["error"]("Oops! Unknown error appeared :(");return;}
				toastr["success"]("ACL "+ name +" was deleted")	
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
////DELETE ACL//////////END///
//////////////////////////////
////EDIT ACL//////////START///
function editACL(id,name)
{
	ajaxData['name'] = name
	ajaxData['id'] = id
	
	dataTable_edit_acl.ajax.reload()
	
	$(editForm+' input[name="name"]').val(name)
	$(editForm+' input[name="name_old"]').val(name)
	$(editForm+' input[name="id"]').val(id)
	$('accesslist').text(name)
	$("#editACL").modal("show");
}
function submitACLChanges()
{
	if (checkACEEditor()) {return;}
	console.log('Submit changes ACL');
	var rowsData = dataTable_edit_acl.rows().data();
	var name = $(editForm+' input[name="name"]').val()
	var name_old = $(editForm+' input[name="name_old"]').val()
	var id = $(editForm+' input[name="id"]').val()
	var	ACEs = [] ;
		ACEs[0] = {'name': name, 'line_number': 0, 'nac':'', 'nas':'', 'timerange':''} ;
	var aceIndex=1;
		rowsData.map(function(val, index){ 
			console.log(val);
			ACEs[aceIndex] = {
				//'name': val.name, 
				'line_number': val.line_number, 
				'action':val.action, 
				'nac':val.nac, 
				'nas':val.nas, 
				'timerange':val.timerange
			}
			if (val.id != undefined) ACEs[aceIndex].id = val.id
			
			aceIndex++
		})
		console.log(ACEs);
	$('.form-group.has-error').removeClass('has-error');
	$('p.text-red').remove();
	$('p.help-block').show();
	var data = {
		"action": "POST",
		"name": name,
		"name_old": name_old,
		"id": id,
		"ACEs": ACEs,
		"deleted_aces": deletedRow,
		"test" : "none"
		};	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: API_LINK+"tacacs/acl/edit/",
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
						$(editForm+' div.'+v).addClass('has-error')
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
			toastr["success"]("ACL "+ $(editForm+' input[name="name"]').val() +" was changed")
			$("#editACL").modal("hide");
			changeApplyStatus(data['changeConfiguration'])
			clearEditACLModal();
			setTimeout( function () {dataTable.ajax.reload()}, 2000 );
		},
		error: function(data) {
			//console.log(data);
			errorHere(data);
		}
	});
}
////EDIT ACL//////////END///