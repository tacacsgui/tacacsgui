var initialData =
{
	ajaxLink: "tacacs/user/datatables/",
	tableSelector: '#usersDataTable',
	item: 'user',
	deleteItems: tgui_tacUser.delete,
	exportCsv: function(idList){ tgui_tacUser.csvParser.csvDownload(idList); return true;},
  columns:
	{
		id: {title: "ID", data : "id", orderable: true, visible: false,},
		username: {title: "Username", data : "username", visible: true, orderable: true},
		group: {title: "Group", data : "group", visible: true, orderable: false},
		//'priv-lvl': {title: "Privilege Lvl", data : "priv-lvl", visible: false, orderable: false},
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
		console.log(initialData);
		this.settings.preview();
		this.settings.columnDefs =
		[{
			targets: [ 3 ],
			createdCell: function (td, cellData, rowData, row, col) {
				//console.log(rowData.enable)
				if (rowData.message) $(td).append(' <small class="label bg-gray" data-toggle="tooltip" data-placement="top" title="Message configured" style="margin:3px">m</small>')
				if (rowData.enable) $(td).append(' <small class="label bg-yellow" data-toggle="tooltip" data-placement="top" title="Enable password configured" style="margin:3px">e</small>')
				if (rowData.disabled) $(row).addClass('text-muted')
			},
		},
		{
			targets: [ 4 ],
			createdCell: function (td, cellData, rowData, row, col) {
				//console.log(rowData.group)
				if (rowData.group == null) {$(td).append("-Not set-"); return;}
				if (rowData.groupMessage) $(td).append(' <small class="label bg-gray" data-toggle="tooltip" data-placement="top" title="Message configured" style="margin:3px">m</small>')
				if (rowData.groupEnable) $(td).append(' <small class="label bg-yellow" data-toggle="tooltip" data-placement="top" title="Enable password configured" style="margin:3px">e</small>')
			},
		}],
		console.log(this.settings);
		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
