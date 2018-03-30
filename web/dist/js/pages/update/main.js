var timer_seconds = 5;

function couter(timer)
{
	console.log(timer_seconds)
	$('timer').text(timer);
	if (timer == 0) {
		addMessage("Returning...");
		window.location.replace('/');
		return;
	}
	timer_seconds = timer_seconds - 1;
	window.setTimeout(function() { couter(timer_seconds) }, 1000);
}

function addMessage(message)
{
	$('div.message-container').append('<p>'+message+'</p>');
	return;
}

function checkDatabase()
{
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
			//async: false,
			success: function(data) {
				console.log(data);
				if (data.message != undefined) { 
					if ( $('div.message-container').is(':empty') ) {
						addMessage("Let's begin!");
					}
					addMessage(data.message);
					checkDatabase(); return; 
				} 
				else
				{
					if ( $('div.message-container').is(':empty') ) {
						addMessage("Update doesn't found. You will return to main page in <timer></timer> seconds.");
					}
					else
					{
						addMessage("Update complete. You will return to main page in <timer></timer> seconds.");
					}
					couter(timer_seconds)
				}
				return;
			},
			error: function(data) {
				console.log(data['responseJSON']);
				window.location.replace('/');
			}
	});
	return;
}

$('document').ready(function(){
checkDatabase()
})