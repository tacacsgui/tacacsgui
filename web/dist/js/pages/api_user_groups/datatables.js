var initialData =
{
	ajaxLink: "user/group/datatables/",
	tableSelector: '#userGroupsDataTable',
	item: 'user',
	deleteItems: tgui_apiUserGrp.delete,
	exportCsv: tgui_apiUserGrp.csvDownload || function(){return false;},
  columns:
	{
		id: {title: "ID", data : "id", orderable: true, visible: false,},
		name: {title: "Name", data : "name", visible: true, orderable: true},
		rights: {title: "Rights", data : null, visible: true, orderable: false},
	 	created_at: {title: "Created at", data : "created_at", visible: false, orderable: true},
	 	updated_at: {title: "Updated at", data : "updated_at", visible: false, orderable: true},
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
		this.settings.preview();
		this.settings.columnDefs =
		[{
			"targets": [ 3 ],
			"createdCell": function (td, cellData, rowData, row, col) {
				$(td).empty()
				if (rowData.rightsBinaryArray[1]==1)
				{
					$(td).append(' <small class="label bg-red" data-toggle="tooltip" data-placement="top" title="Administrator" style="margin:3px">A</small>')
					return
				}
				if (rowData.rightsBinaryArray[0]==1 && rowData.rightsBinaryArray.length == 1)
				{
					$(td).append(' <small class="label bg-aqua" data-toggle="tooltip" data-placement="top" title="DEMO" style="margin:3px">D</small>')
					return
				}
				if (rowData.rightsBinaryArray[2]==1)
				{
					$(td).append(' <small class="label bg-blue" style="margin:3px" data-toggle="tooltip" data-placement="top" title="Add/Edit/Delete Tac Devices">td</small>')
				}
				if (rowData.rightsBinaryArray[3]==1)
				{
					$(td).append(' <small class="label bg-blue" style="margin:3px" data-toggle="tooltip" data-placement="top" title="Add/Edit/Delete Tac Device Groups">tdg</small>')
				}
				if (rowData.rightsBinaryArray[4]==1)
				{
					$(td).append(' <small class="label bg-yellow" style="margin:3px" data-toggle="tooltip" data-placement="top" title="Add/Edit/Delete Tac Users">tu</small>')
				}
				if (rowData.rightsBinaryArray[5]==1)
				{
					$(td).append(' <small class="label bg-yellow" style="margin:3px" data-toggle="tooltip" data-placement="top" title="Add/Edit/Delete Tac Users Groups">tug</small>')
				}
				if (rowData.rightsBinaryArray[6]==1)
				{
					$(td).append(' <small class="label bg-green" style="margin:3px" data-toggle="tooltip" data-placement="top" title="Apply/Test Tac Configuration">tcfg</small>')
				}
				if (rowData.rightsBinaryArray[7]==1)
				{
					$(td).append(' <small class="label bg-yellow" style="margin:3px" data-toggle="tooltip" data-placement="top" title="Add/Edit/Delete API Users">au</small>')
				}
				if (rowData.rightsBinaryArray[8]==1)
				{
					$(td).append(' <small class="label bg-yellow" style="margin:3px" data-toggle="tooltip" data-placement="top" title="Add/Edit/Delete API Users Groups">aug</small>')
				}
				if (rowData.rightsBinaryArray[9]==1)
				{
					$(td).append(' <small class="label bg-gray" style="margin:3px" data-toggle="tooltip" data-placement="top" title="Delete/Restore Backups">b</small>')
				}
			},
		}],
		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
