var initialData =
{
	ajaxLink: "tacacs/device/group/datatables/",
	tableSelector: "#deviceGroupsDataTable",
	item: 'deviceGrp',
	deleteItems: tgui_devGrp.delete,
	exportCsv: function(idList){ tgui_devGrp.csvParser.csvDownload(idList); return true;},
  columns:
	{
		id: {title: "ID", data : "id", orderable: true, visible: false,},
		name: {title: "Name", data : "name", visible: true, orderable: true},
	 	created_at: {title: "Created at", data : "created_at", visible: false, orderable: true},
	 	updated_at: {title: "Updated at", data : "updated_at", visible: false, orderable: true},
		buttons: {title: "Action", data : "buttons", visible: true, orderable: false},
	},
  column:
	{
		select: true,
		preview: true
	},
  sort:
	{
		column: 3,
		order: 'asc'
	},
};

var dataTable = {
	init: function() {
		this.settings.columnsFilter();
		this.settings.preview();
		this.settings.columnDefs =
		[{
			"targets": [ 3 ],
			"createdCell": function (td, cellData, rowData, row, col) {
				if (rowData.key) $(td).append(' <small class="label bg-green" data-toggle="tooltip" data-placement="top" title="Key configured" style="margin:3px">k</small>')
				if (rowData.enable) $(td).append(' <small class="label bg-yellow" style="margin:3px" data-toggle="tooltip" data-placement="top" title="Enable password configured">e</small>')
			},
		}];
		console.log(this.settings);
		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
