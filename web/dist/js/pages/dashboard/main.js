$('document').ready(function(){
	Promise.resolve(tgui_apiUser.getInfo()).then(function(resp) {
	  tgui_apiUser.fulfill(resp);
	  //Check Updates//
	  Promise.resolve(tgui_status.getStatus({url: API_LINK+"apicheck/database/"})).then(function(resp) {
			if (resp.messages.length) throw {update: true};
	    //Get System Info//
	    Promise.resolve(tgui_status.getStatus({url: API_LINK+"apicheck/status/"})).then(function(resp) {
	      tgui_status.fulfill(resp);
				tacacsWidgets.daemonStatus().getGeneral().topAccess().authChart();
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
		var self = this;
		var ajaxProps = {
        url: API_LINK+"tacacs/reports/general/",
      	type: 'get',
      };//ajaxProps END

		ajaxRequest.send(ajaxProps).then(function(resp) {
			$('.numberOfDevices').removeClass('lds-dual-ring').text(resp.numberOfDevices)
			$('.numberOfUsers').removeClass('lds-dual-ring').text(resp.numberOfUsers)
			$('.numberOfAuthFails').removeClass('lds-dual-ring').text(resp.numberOfAuthFails)
			if (resp.update_check) self.updates();
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
	daemonStatus: function() {
		var ajaxProps = {
      url: API_LINK + "tacacs/reports/daemon/status/",
      		type: 'get',
      };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
			if (resp.tacacsStatus == 1 ){$('.tacacsStatus').removeClass('lds-dual-ring').text('Enabled')}
			else $('.tacacsStatus').removeClass('lds-dual-ring').text("Disabled");
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
	},
	userChart: { destroy: function() {return false;} },
	deviceChart: { destroy: function() {return false;} },
	topAccess: function(o) {
		var self = this;
		o = o || {}
		o = {
			usersReload: (o.users) ? 1 : 0,
			devicesReload: (o.devices) ? 1 : 0,
			users: o.users || 5,
			devices: o.devices || 5
		}
		if ( !o.usersReload && !o.devicesReload ) o.usersReload = o.devicesReload = 1;
		if ( o.usersReload ) $('.userPieLoading').empty().removeClass('lds-dual-ring lds-black').addClass('lds-dual-ring lds-black');
		if ( o.devicesReload ) $('.devicePieLoading').empty().removeClass('lds-dual-ring lds-black').addClass('lds-dual-ring lds-black');

		$('.num_users').removeClass('active');
		$('.num_devices').removeClass('active');
		$('.num_users_' + o.users).addClass('active')
		$('.num_devices_' + o.devices).addClass('active')

		var ajaxProps = {
      url: API_LINK + "tacacs/reports/top/access/",
      		type: 'get',
					data: {
						users: o.users,
						devices: o.devices,
						usersReload: o.usersReload,
						devicesReload: o.devicesReload,
					}
      };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
			if (resp.topUsers){
				$('.userPieLoading').removeClass('lds-dual-ring lds-black');
				var configForUsers = new pieSettings(resp.topUsers);
				if (configForUsers.data.labels.length) {
					self.userChart.destroy()
					self.userChart = new Chart($(".chart-area1"), configForUsers);
					self.userChart.update()
				}
				else $('.userPieLoading').append('No data');
			}
			if (resp.topDevices){
				$('.devicePieLoading').removeClass('lds-dual-ring lds-black');
				var configForDevices = new pieSettings(resp.topDevices);
				if (configForDevices.data.labels.length) {
					self.deviceChart.destroy();
					self.deviceChart = new Chart($(".chart-area2"), configForDevices);
					self.deviceChart.update()
				}
				else $('.devicePieLoading').append('No data');
			}
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
	},
	authChart: function() {
		var self = this;
		var ajaxProps = {
      url: API_LINK + "tacacs/widget/chart/auth/",
      		type: 'GET',
      };//ajaxProps END
			ajaxRequest.send(ajaxProps).then(function(resp) {
				console.log(resp);
				var configAutheChart = new authChartSettings({
					labels: resp.time_range,
					datasets: {
						faildata: resp.charts.authentication.data.fail,
						successdata: resp.charts.authentication.data.success,
					}
				});
				var configAuthoChart = new authChartSettings({
					labels: resp.time_range,
					datasets: {
						failLabel: 'Fail Authorization',
						faildata: resp.charts.authorization.data.fail,
						successLabel: 'Success Authorization',
						successdata: resp.charts.authorization.data.success,
					},
					options: {
						title: 'Authorization'
					}
				});
				// config.data.labels = resp.time_range;
				// config.data.datasets[0].data = resp.charts.authentication.data.fail;
				// config.data.datasets[1].data = resp.charts.authentication.data.success;
				var autheLineChart = $("#authentication");
				var authoLineChart = $("#authorization");
				var autheChart = new Chart(autheLineChart, configAutheChart);
				// config.data.datasets[0].data = resp.charts.authorization.data.fail;
				// config.data.datasets[0].label = "Fail Authorization";
				// config.data.datasets[1].label = "Success Authorization";
				// config.options.title.text = "Authorization";
				// config.options.scales.yAxes[0].scaleLabel.labelString = "Authorization";
				// config.data.datasets[1].data = resp.charts.authorization.data.success;
				var authoChart = new Chart(authoLineChart, configAuthoChart);
	    }).fail(function(err){
	      tgui_error.getStatus(err, ajaxProps)
	    })
	},
	updates: function(){
		$('.updatesBtn').show();
		var self = this;
		var ajaxProps = {
      url: API_LINK + "update/",
      		type: 'POST',
      };//ajaxProps END
			ajaxRequest.send(ajaxProps).then(function(resp) {
				console.log(resp);
				$('.updatesBtn .fa-spinner').hide();

				if ( resp.output && resp.output.error && resp.output.error.message) {
					console.log(resp.output.error.message);
					if (resp.output.error.type == 'not match') $('.updatesBtn text').text('Unregistered copy');
					else $('.updatesBtn text').text('Updates error');
					$('.updatesBtn .fa-meh-o').show();
					return
				}

				if ( resp.output && resp.output.last_version) {
					if (resp.output.last_version.version == resp.info.version.APIVER) $('.updatesBtn').hide();
					else {
						$('.updatesBtn text').text('Updates');
						$('.updatesBtn .fa-line-chart').show();
					}
					return;
				}

				$('.updatesBtn text').text('Updates error');
				$('.updatesBtn .fa-meh-o').show();
	    }).fail(function(err){
	      tgui_error.getStatus(err, ajaxProps)
	    })
	    return this;
	}
}
/////////Widgets///////END///
///////////////////////////////
