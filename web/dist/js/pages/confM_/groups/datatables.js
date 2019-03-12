var initialData =
{
	ajaxLink: "confmanager/groups/datatables/",
	tableSelector: '#groupsDataTable',
	item: 'confM_groups',
	//deleteItems: tgui_userApi.delete,
	//exportCsv: tgui_userApi.csvDownload || function(){return false;},
  columns:
	{
		name: {title: "Name", data : "name", visible: true, orderable: true},
		members: {title: "Members", data : "members", visible: true, orderable: true},
		date: {title: "Date", data : "date", visible: true, orderable: true},
		buttons: {title: "Action", data : "buttons", visible: true, orderable: false},
	},
  column:
	{
		select: false,
		preview: false
	},
  sort:
	{
		column: 0,
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
