$('document').ready(function(){
	Promise.resolve(tacacsUser.getInfo()).then(function(resp) {
	  tacacsUser.fulfill(resp);
    //Get System Info//
    Promise.resolve(tacacsStatus.getStatus({url: API_LINK+"apicheck/status/"})).then(function(resp) {
      tacacsStatus.fulfill(resp);
			//MAIN CODE//Start
			
			//MAIN CODE//END
      $('div.loading').hide();/*---*/
    }).catch(function(err){
			tacguiError.getStatus(err, tacacsStatus.ajaxProps)
    })//Get System Info//end
	}).catch(function(err){
	  tacguiError.getStatus(err, tacacsUser.ajaxProps)
	})
});
