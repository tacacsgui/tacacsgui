$('document').ready(function(){
	// Promise.resolve(tgui_apiUser.getInfo()).then(function(resp) {
	//   tgui_apiUser.fulfill(resp);
    //Get System Info//
    // Promise.resolve( tgui_status.getStatus({url: API_LINK+"apicheck/status/"}, 'signin') ).then(function(resp) {
    //   tgui_status.fulfill(resp);
			//MAIN CODE//Start
			tguiInit.iCheck();
			tgui_signin.init();
			//MAIN CODE//END
      // $('div.loading').hide();
    // }).catch(function(err){
		// 	tgui_error.getStatus(err, tgui_status.ajaxProps, true)
    // })//Get System Info//end
	// }).catch(function(err){
	//   tgui_error.getStatus(err, tgui_apiUser.ajaxProps, true)
	// })
});
