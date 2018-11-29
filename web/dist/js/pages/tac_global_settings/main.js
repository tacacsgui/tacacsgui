$('document').ready(function(){
	Promise.resolve(tgui_apiUser.getInfo()).then(function(resp) {
	  tgui_apiUser.fulfill(resp);
    //Get System Info//
    Promise.resolve(tgui_status.getStatus({url: API_LINK+"apicheck/status/"})).then(function(resp) {
      tgui_status.fulfill(resp);
			//MAIN CODE//Start
			//tguiInit.bootstrap_toggle();
			tgui_tacGlobal.init().then(function(resp){ $('div.loading').hide();/*---*/ });

			//MAIN CODE//END

    }).catch(function(err){
			tgui_error.getStatus(err, tgui_status.ajaxProps)
    })//Get System Info//end
	}).catch(function(err){
	  tgui_error.getStatus(err, tgui_apiUser.ajaxProps)
	})
});
