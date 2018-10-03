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

var authChartSettings = function( o ){
  o = o || {};
  o.labels = o.labels || [];
  o.datasets = o.datasets || {};
  o.datasets.failLabel = o.datasets.failLabel || 'Fail Authentication';
  o.datasets.faildata = o.datasets.faildata || [];
  o.datasets.successLabel = o.datasets.successLabel || 'Success Authentication';
  o.datasets.successdata = o.datasets.successdata || [];
  o.options = o.options || {};
  o.options.title = o.options.title || 'Authentication';
  //o.options.scales.yAxes.name = o.options.scales.yAxes.name || 'Authentication';
  return {
    type: 'line',
    data: {
      labels: o.labels,
      datasets: [{
        label: o.datasets.failLabel,
        backgroundColor: window.chartColors.red,
        borderColor: window.chartColors.red,
        data: o.datasets.faildata,
        fill: false,
      }, {
        label: o.datasets.successLabel,
        fill: false,
        backgroundColor: window.chartColors.green,
        borderColor: window.chartColors.green,
        data: o.datasets.successdata,
      }]
    },
    options: {
      responsive: true,
      title: {
        display: true,
        text: o.options.title = o.options.title
      },
      tooltips: {
        mode: 'index',
        intersect: false,
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Day'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: o.options.title = o.options.title
          },
          ticks: {
            beginAtZero: true,
            stepSize: 10,
          }
        }]
      }
    }
  };
}
