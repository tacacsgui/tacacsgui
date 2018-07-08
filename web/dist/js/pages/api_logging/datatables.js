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
	ajaxLink: "logging/datatables/",
	tableSelector: '#apiLoggingDataTable',
	item: 'device',
	//exportCsv: tgui_authentication.csvDownload || function(){return false;},
  columns:
	{
		id: {title: "ID", data : "id", orderable: true, visible: false,},
		created_at: {title: "Date", data : "created_at", visible: true, orderable: true},
		username: {title: "Username", data : "username", visible: true, orderable: true},
		uid: {title: "User ID", data : "uid", visible: false, orderable: true},
		user_ip: {title: "Remote IP", data : "user_ip", visible: true, orderable: true},
		section: {title: "Section", data : "section", visible: true, orderable: true},
		obj_name: {title: "Object Name (id)", data : "obj_name", visible: true, orderable: false},
		obj_id: {title: "Object ID", data : "obj_id", visible: false, orderable: false},
		action: {title: "Action", data : "action", visible: true, orderable: false},
		message: {title: "Message", data : "message", visible: true, orderable: false},
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
