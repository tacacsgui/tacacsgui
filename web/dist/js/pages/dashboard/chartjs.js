var pieSettings = function(object){
  object = object || {};
  var data = [];
  var labels = [];
  for (var item in object) {
    if (object.hasOwnProperty(item)) {
      data[data.length] = object[item];
      labels[labels.length] = item;
    }
  }
  return {
    type: 'pie',
    data: {
      datasets: [{
        data: data,

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
      labels: labels
    },
    options: {
      responsive: true,
      legend: { position: 'bottom'}
    }
  }//end return constructor of pieSettings
}
    window.onload = function() {
        var ctx1 = $(".chart-area1");
        var ctx2 = $(".chart-area2");
        //window.usersPie = new Chart(ctx1, configForUsers);
        //window.devicesPie = new Chart(ctx2, configForDevices);
    };

    //var colorNames = Object.keys(window.chartColors);
