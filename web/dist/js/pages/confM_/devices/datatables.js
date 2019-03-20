var initialData =
{
	ajaxLink: "confmanager/devices/datatables/",
	tableSelector: '#devicesDataTable',
	item: 'device',
	deleteItems: cm_devices.del,
	//exportCsv: tgui_userApi.csvDownload || function(){return false;},
  columns:
	{
		id: {title: "ID", data : "id", orderable: true, visible: false,},
		name: {title: "Name", data : "name", visible: true, orderable: true},
		ip: {title: "IP Address", data : "ip", visible: true, orderable: true},
		tgui_device: {title: "Tgui Device", data : "tgui_device", visible: true, orderable: false},
		creden_name: {title: "Credential", data : "creden_name", visible: true, orderable: false},
		ref: {title: "Ref", data : "ref", visible: false, orderable: false},
		buttons: {title: "Action", data : "buttons", visible: true, orderable: false},
	},
  column:
	{
		select: true,
		preview: false
	},
  sort:
	{
		column: 2,
		order: 'asc'
	},
};

var dataTable = {
	init: function() {
		this.settings.columnsFilter();
		//this.settings.preview();
		this.settings.columnDefs = [],
		console.log(this.settings);
		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
