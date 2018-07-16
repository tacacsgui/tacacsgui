var initialData =
{
	ajaxLink: "tacacs/device/datatables/",
	tableSelector: '#devicesDataTable',
	item: 'device',
	deleteItems: tgui_device.delete,
	exportCsv: tgui_device.csvDownload,
  columns:
	{
		id: {title: "ID", data : "id", orderable: true, visible: false,},
		name: {title: "Name", data : "name", visible: true, orderable: true},
		ipaddr: {title: "IP Address/Prefix", data : "ipaddr", visible: true, orderable: false},
		group: {title: "Group", data : "group", visible: true, orderable: false},
		vendor: {title: "Vendor", data : "vendor", visible: false, orderable: true},
		model: {title: "Model", data : "model", visible: false, orderable: true},
		type: {title: "Type", data : "type", visible: false, orderable: true},
		sn: {title: "Serial Number", data : "sn", visible: false, orderable: false},
		// banner_motd: {title: "Banner MOTD", data : "banner_motd", visible: true, orderable: false},
		// banner_failed: {title: "Banner Failed", data : "banner_failed", visible: true, orderable: false},
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
			targets: [ 3 ],
			createdCell: function (td, cellData, rowData, row, col) {
				if (rowData.key) $(td).append(' <small class="label bg-green" data-toggle="tooltip" data-placement="top" title="Key configured" style="margin:3px">k</small>')
				if (rowData.enable) $(td).append(' <small class="label bg-yellow" data-toggle="tooltip" data-placement="top" title="Enable password configured" style="margin:3px">e</small>')
			},
		},
		{
			targets: [ 5 ],
			createdCell: function (td, cellData, rowData, row, col) {
				if (rowData.groupKey) $(td).append(' <small class="label bg-green" data-toggle="tooltip" data-placement="top" title="Key configured" style="margin:3px">k</small>')
				if (rowData.groupEnable) $(td).append(' <small class="label bg-yellow" data-toggle="tooltip" data-placement="top" title="Enable password configured" style="margin:3px">e</small>')
			},
		}];
		console.log(this.settings);
		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
