var initialData =
{
	ajaxLink: "confmanager/queries/datatables/",
	tableSelector: '#queriesDataTable',
	item: 'cm_queries',
	deleteItems: cm_queries.del,
	//exportCsv: tgui_userApi.csvDownload || function(){return false;},
  columns:
	{
		id: {title: "ID", data : "id", orderable: true, visible: false,},
		filename: {title: "Name", data : "name", visible: true, orderable: true},
		model: {title: "Model", data : "model", visible: true, orderable: false},
		creden_name: {title: "Credential", data : "creden_name", visible: true, orderable: false},
		devices: {title: "Device Count", data : "devices", visible: true, orderable: false},
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
		//console.log(this.settings);
		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
