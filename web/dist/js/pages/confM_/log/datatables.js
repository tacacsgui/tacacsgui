var initialData =
{
	ajaxLink: "confmanager/log/datatables/",
	tableSelector: '#logDataTable',
	//item: 'confDevices',
	//deleteItems: tgui_userApi.delete,
	//exportCsv: tgui_userApi.csvDownload || function(){return false;},
  columns:
	{
		date: {title: "Date", data : "date", visible: true, orderable: true},
		device_name: {title: "Device Name", data : "device_name", visible: true, orderable: true},
		device_id: {title: "Device ID", data : "device_id", visible: false, orderable: true},
		ip: {title: "IP Address", data : "ip", visible: true, orderable: true},
		protocol: {title: "Protocol", data : "protocol", visible: false, orderable: true},
		port: {title: "Port", data : "port", visible: false, orderable: true},
		uname: {title: "Username", data : "uname", visible: true, orderable: true},
		uname_type: {title: "Username Type", data : "uname_type", visible: false, orderable: true},
		query_name: {title: "Query Name", data : "query_name", visible: true, orderable: true},
		query_id: {title: "Query ID", data : "query_id", visible: false, orderable: true},
		group: {title: "Group", data : "group", visible: false, orderable: true},
		status: {title: "Status", data : "status", visible: true, orderable: true},
		message: {title: "Message", data : "message", visible: false, orderable: true},
	},
  column:
	{
		select: false,
		preview: false
	},
  sort:
	{
		column: 0,
		order: 'desc'
	},
};

var dataTable = {
	init: function() {
		var self = this;
		this.settings.columnsFilter();
		//this.settings.preview();
		this.settings.columnDefs = [];
		this.settings.lengthMenu = [ 25, 50, 75, 100 ];
		//console.log(settings);

		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
