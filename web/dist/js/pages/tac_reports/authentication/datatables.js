$('document').ready(function(){
	Promise.resolve(tgui_apiUser.getInfo()).then(function(resp) {
	  tgui_apiUser.fulfill(resp);
    //Get System Info//
    Promise.resolve(tgui_status.getStatus({url: API_LINK+"apicheck/status/"})).then(function(resp) {
      tgui_status.fulfill(resp);
			//MAIN CODE//Start
			dataTable.init();

			$('#filterInfo').popover({
				html: true,
				container: 'body',
				content: $('.filter-info-content').html()
			});
			//MAIN CODE//END
      $('div.loading').hide();/*---*/
    }).catch(function(err){
			tgui_error.getStatus(err, tgui_status.ajaxProps)
    })//Get System Info//end
	}).catch(function(err){
	  tgui_error.getStatus(err, tgui_apiUser.ajaxProps)
	})
});

var initialData =
{
	ajaxLink: "tacacs/reports/authentication/datatables/",
	tableSelector: '#authenticationDataTable',
	item: 'device',
	//exportCsv: tgui_authentication.csvDownload || function(){return false;},
  columns:
	{
		id: {title: "ID", data : "id", orderable: true, visible: false,},
		date: {title: "Date", data : "date", visible: true, orderable: true},
		NAS: {title: "NAS IP", data : "NAS", visible: true, orderable: true},
		username: {title: "Username", data : "username", visible: true, orderable: true},
		NAC: {title: "NAC IP", data : "NAC", visible: true, orderable: true},
		line: {title: "Line", data : "line", visible: false, orderable: false},
		action: {title: "Action", data : "action", visible: true, orderable: false},
		unknown: {title: "Unknown", data : "unknown", visible: false, orderable: true},
	},
  column:
	{
		select: true,
		preview: false
	},
  sort:
	{
		column: 2,
		order: 'desc'
	},
};

var dataTable = {
	init: function() {
		this.settings.columnsFilter();
		this.settings.preview();
		this.settings.columnDefs = [];
		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
