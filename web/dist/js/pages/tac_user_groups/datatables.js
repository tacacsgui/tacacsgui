var initialData =
{
	ajaxLink: "tacacs/user/group/datatables/",
	tableSelector: '#userGroupsDataTable',
	item: 'userGrp',
	deleteItems: tgui_tacUserGrp.delete,
	exportCsv: tgui_tacUserGrp.csvDownload || function(){return false;},
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
			createdCell: function (td, cellData, rowData, row, col) {
				if (rowData.message) $(td).append(' <small class="label bg-gray" data-toggle="tooltip" data-placement="top" title="Message configured" style="margin:3px">m</small>')
				if (rowData.enable) $(td).append(' <small class="label bg-yellow" data-toggle="tooltip" data-placement="top" title="Enable password configured" style="margin:3px">e</small>')
			},
		}],
		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
