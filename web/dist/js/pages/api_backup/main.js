checkConfiguration()
getUserInfo()
////DELETE Backup FUNCTION////START//
function deleteBackup(name){
	console.log('Deleting backup with name '+name)
	if (confirm("Do you want delete '"+name+"'?")){
		/////////DELETE Backup///START//
		var data = {
			"action": "POST",
			"name": name,
			"test" : "none"
			};	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: API_LINK+"backup/delete/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				if(data['deleteBackup']!=1){toastr["error"]("Oops! Unknown error appeared :(");return;}
				toastr["success"]("Backup "+ name +" was deleted")	
				setTimeout( function () {dataTable.ajax.reload()}, 2000 );
			},
			error: function(data) {
				//console.log(data);
				errorHere(data);
			}
		});
		/////////DELETE Backup///END////
	}
	return;
}
////DELETE Backup FUNCTION////END//
/////////////////////////////
////RESTORE Backup FUNCTION////START//
function restoreBackup(name){
	console.log('Restoring backup with name '+name)
	if (confirm("Do you want restore '"+name+"'?")){
		/////////RESTORE Backup///START//
		var data = {
			"action": "POST",
			"name": name,
			"test" : "none"
			};	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: API_LINK+"backup/restore/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				if(data['restore']!=1){toastr["error"]("Oops! Unknown error appeared :(");return;}
				toastr["success"]("Backup "+ name +" was restored")	
				changeApplyStatus(1)
				setTimeout( function () {dataTable.ajax.reload()}, 2000 );
			},
			error: function(data) {
				//console.log(data);
				errorHere(data);
			}
		});
		/////////RESTORE Backup///END////
	}
	return;
}
////RESTORE Backup FUNCTION////END//
/////////////////////////////