function tooltips() {
  $('[data-toggle="tooltip"]').tooltip()
}
tooltips()
///////TOASTR///GLOBAL OPTIONS///
toastr.options = {
	"positionClass": "toast-bottom-right",
}
///////////////////////////////
/////CHANGE APPLY STATUS IN THE HEADER///START//
function changeApplyStatus(status)
{
	if (status == 1) 
	{
		$('header li.applyBtn').show()
		$('ul.timeline li span.configurationStatus').empty().text('Configuration was changed, you can test and apply it').removeClass('bg-green').addClass('bg-yellow')
	}
	if (status == 0)
	{
		$('header li.applyBtn').hide()
		$('ul.timeline li span.configurationStatus').empty().text('No changes detected').removeClass('bg-yellow').addClass('bg-green')
	}
}
/////CHANGE APPLY STATUS IN THE HEADER///END//
//////////////////////////////////
////////ERROR FUNCTION////START///
function errorHere(answer)
{
	switch(answer.status)
	{
		case 500:
			toastr["error"]("Oops! Error on server, try to move to home page.");
			console.log(answer)
			window.location.replace('/')
			break;
		case 401:
			toastr["error"]("You are not authorised!");
			window.location.replace('/')
			break;
		case 403:
			toastr["warning"]("You do not have enough rights to do that!");
			break;
		default:
			toastr["error"]("Oops! Unknown error appeared, try to move to home page. :(");
			console.log(answer)
			//window.location.replace('/')
	}
	return;
} 
////////ERROR FUNCTION////END///
///////////////////////////////////
/////////MAIN CHECK CONFIGURATION///START//
function checkConfiguration()
{
	var data = {
			"action": "get",
			"test" : "none"
			};	
	$.ajax({
			type: "GET",
			dataType: "json",
			url: API_LINK+"apicheck/status/",
			cache: false,
			data: data,
			success: function(data) {
				console.log(data);
				$('tacversion').text(data['info']['version']['TACVER']);
				$('apiversion').text(data['info']['version']['APIVER']);
				$('guiversion').text(GUIVER);
				$('li.user span.username').text(data['info']['user']['username']);
				changeApplyStatus(data['configuration']['changeFlag'])
			},
			error: function(data) {
				console.log(data['responseJSON']);
				errorHere(data);
			}
	});
}
/////////MAIN CHECK CONFIGURATION///END////
///////////////////////////////////
/////////GET USER INFO///START//
function getUserInfo()
{
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
				$('firstname_info').text(data['user']['firstname'] + ' ')
				$('surname_info').text(data['user']['surname'])
				$('position_info').text(data['user']['position'])
				$('div.loading').hide();
			},
			error: function(data) {
				console.log(data['responseJSON']);
				errorHere(data);
			}
	});
}
/////////GET USER INFO///END////
///////////////////////////////////
/////////LOGOUT///SINGOUT///START//
function signout(){
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
			if (!data['authorised']) window.location.replace('/');
		},
		error: function(data) {
			console.log(data['responseJSON']);
			errorHere(data);
		}
	});
}
$('#singout').click(function(){
	signout()
})
/////////LOGOUT///SINGOUT///END////
///////////////////////////////////

var timeoutset=1500*60*5;
$.idleTimer(timeoutset);
$(document).bind("idle.idleTimer", function(){
	window.open( "./lockscreen.php","_self");
});

function print_r(arr, level) {
    var print_red_text = "";
    if(!level) level = 0;
    var level_padding = "";
    for(var j=0; j<level+1; j++) level_padding += "    ";
    if(typeof(arr) == 'object') {
        for(var item in arr) {
            var value = arr[item];
            if(typeof(value) == 'object') {
                print_red_text += level_padding + "'" + item + "' :\n";
                print_red_text += print_r(value,level+1);
		} 
            else 
                print_red_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
        }
    } 

    else  print_red_text = "===>"+arr+"<===("+typeof(arr)+")";
    return print_red_text;
}