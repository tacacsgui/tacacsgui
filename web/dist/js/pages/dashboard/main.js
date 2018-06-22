$('document').ready(function(){
	Promise.resolve(tgui_apiUser.getInfo()).then(function(resp) {
	  tgui_apiUser.fulfill(resp);
	  //Check Updates//
	  Promise.resolve(tgui_status.getStatus({url: API_LINK+"apicheck/database/"})).then(function(resp) {
			if (resp.messages.length) throw {update: true};
	    //Get System Info//
	    Promise.resolve(tgui_status.getStatus({url: API_LINK+"apicheck/status/"})).then(function(resp) {
	      tgui_status.fulfill(resp);

				tacacsWidgets.getGeneral().then(function(resp) {
					tacacsWidgets.dashboardStatus(resp).diagrams1(resp);

				}).fail(function(err) {
					tgui_error.getStatus(err, tacacsWidgets.ajaxProps)
				});//end widgets general

	      $('div.loading').hide();/*---*/
	    }).catch(function(err){
				tgui_error.getStatus(err, tgui_status.ajaxProps)
	    })//Get System Info//end
	  }).catch(function(err){
			console.log(err.update)
			if (err.update) window.location.replace('/update.php');
			else tgui_error.getStatus(err, tgui_status.ajaxProps)
	  })//Check Updates//end
	}).catch(function(err){
	  tgui_error.getStatus(err, tgui_apiUser.ajaxProps)
	})
});
///////////////////////////////////
/////////Widgets///////Start///
var tacacsWidgets = {
	topUsers:0,
	topDevices:0,
	ajaxProps:{
    url:API_LINK+"tacacs/reports/general/",
    type: "GET"
  },
  getGeneral: function(props) {
    props = props || {}
    for (var prop in props) {
      if (props.hasOwnProperty(prop)) {
        this.ajaxProps[prop] = props[prop];
      }
    }
    mainData = ajaxRequest.send(this.ajaxProps)
    return mainData
  },
	dashboardStatus: function(data){
		if (data.tacacsStatus == 1 ){$('.tacacsStatus').removeClass('lds-dual-ring').text('Enabled')}
		else $('.tacacsStatus').removeClass('lds-dual-ring').text("Disabled");
		$('.numberOfDevices').removeClass('lds-dual-ring').text(data.numberOfDevices)
		$('.numberOfUsers').removeClass('lds-dual-ring').text(data.numberOfUsers)
		$('.numberOfAuthFails').removeClass('lds-dual-ring').text(data.numberOfAuthFails)
		return this;
	},
	diagrams1:function(data){
		topUsers = data.topUsers
		$('.userPieLoading').removeClass('lds-dual-ring lds-black');
		$('.devicePieLoading').removeClass('lds-dual-ring lds-black');
		topDevices = data.topDevices
		var configForUsers = new pieSettings(topUsers);
		var configForDevices = new pieSettings(topDevices);
		if (configForUsers.data.labels.length) new Chart($(".chart-area1"), configForUsers);
		else $('.userPieLoading').append('No data');
		if (configForDevices.data.labels.length) new Chart($(".chart-area2"), configForDevices);
		else $('.devicePieLoading').append('No data');
	}
}
/////////Widgets///////END///
///////////////////////////////
