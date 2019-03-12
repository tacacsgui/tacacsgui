var initialData =
{
	ajaxLink: "confmanager/datatables/",
	tableSelector: '#mainDataTable',
	//item: 'confDevices',
	//deleteItems: tgui_userApi.delete,
	//exportCsv: tgui_userApi.csvDownload || function(){return false;},
  columns:
	{
		device_name: {title: "Device", data : "device_name", visible: true, orderable: true},
		device_id: {title: "Device ID", data : "device_id", visible: false, orderable: true},
		query_name: {title: "Query", data : "query_name", visible: true, orderable: true},
		query_id: {title: "Query ID", data : "query_id", visible: false, orderable: true},
		date_change: {title: "Last Change Date ", data : "date_change", visible: true, orderable: true},
		date_commit: {title: "Last Commit Date", data : "date_commit", visible: true, orderable: false},
		group: {title: "Group", data : "group", visible: true, orderable: false},
		commits: {title: "Revisions", data : "commits", visible: true, orderable: false},
		status: {title: "Last Status", data : "status", visible: true, orderable: false},
		size: {title: "Size", data : "size", visible: true, orderable: true},
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
		var self = this;
		this.settings.columnsFilter();
		//this.settings.preview();
		this.settings.columnDefs = [];
		//console.log(settings);
		this.settings.fnDrawCallback = function( oSettings ) {
			self.settings.drawCallback(oSettings)
      cm_list.getMore()
    };
		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
