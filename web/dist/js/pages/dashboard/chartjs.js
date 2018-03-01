   var configForUsers = {
        type: 'pie',
        data: {
            datasets: [{
                data: [],
				
				pointStyle: 'rectRot',
                pointRadius: 5,
                pointBorderColor: 'rgb(0, 0, 0)',
				
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.orange,
                    window.chartColors.yellow,
                    window.chartColors.green,
                    window.chartColors.blue,
                ],
            }],
            labels: []
        },
        options: {
            responsive: true,
			legend: { position: 'bottom',},
        }
    };
	
	var configForDevices = {
        type: 'pie',
        data: {
            datasets: [{
                data: [],
				
				pointStyle: 'rectRot',
                pointRadius: 5,
                pointBorderColor: 'rgb(0, 0, 0)',
				
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.orange,
                    window.chartColors.yellow,
                    window.chartColors.green,
                    window.chartColors.blue,
                ],
            }],
            labels: []
        },
        options: {
            responsive: true,
			legend: { position: 'bottom',},
        }
    };
    window.onload = function() {
        var ctx1 = $(".chart-area1");
        var ctx2 = $(".chart-area2");
        window.usersPie = new Chart(ctx1, configForUsers);
        window.devicesPie = new Chart(ctx2, configForDevices);
    };

    var colorNames = Object.keys(window.chartColors);