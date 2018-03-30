$('document').ready(function(){
	checkDatabase().done(function(){
		checkConfiguration()
		getUserInfo()
		widgetsData()
	});
});
///////////////////////////////
/////////CHECK DATABASE///START//
function checkDatabase()
{
	var d = $.Deferred();
	var data = {
			"action": "get",
			"test" : "none"
			};	
	$.ajax({
			type: "GET",
			dataType: "json",
			url: API_LINK+"apicheck/database/",
			cache: false,
			data: data,
			async: false,
			success: function(data) {
				console.log(data);
				if (data.message != undefined) { 
					window.location.replace('/update.php');
					return d.reject();
				}
			},
			error: function(data) {
				console.log(data['responseJSON']);
				window.location.replace('/');
			}
	});
	return d.resolve();
}
/////////CHECK DATABESE///END////
///////////////////////////////////
/////////Widgets///////Start///
var topUsers
var topDevices = [];
function widgetsData()
{
	var data = {
			"action": "get",
			"test" : "none"
			};	
	$.ajax({
			type: "GET",
			dataType: "json",
			url: API_LINK+"tacacs/reports/general/",
			cache: false,
			data: data,
			//async: false,
			success: function(data) {
				console.log(data);
				if (data['tacacsStatus']==1){$('.tacacsStatus').text('Enabled')}
				else $('.tacacsStatus').text("Disabled");
				$('.numberOfDevices').text(data['numberOfDevices'])
				$('.numberOfUsers').text(data['numberOfUsers'])
				$('.numberOfAuthFails').text(data['numberOfAuthFails'])
				console.log(configForUsers.data)
				topUsers = data['topUsers']
				//topDevices[0] = data['topDevices']
				topDevices = data['topDevicesNamed']
				$('textarea.debug-output').val((print_r(data)));
				configForUsers.data.datasets[0].data=Object.values(topUsers);
				configForUsers.data.labels=Object.keys(topUsers)
				window.usersPie.update();
				configForDevices.data.datasets[0].data=Object.values(topDevices);
				configForDevices.data.labels=Object.keys(topDevices)
				window.devicesPie.update();
			},
			error: function(data) {
				console.log(data['responseJSON']);
				window.location.replace('/');
			}
	});
}
/////////Widgets///////END///
///////////////////////////////