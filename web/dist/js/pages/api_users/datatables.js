var initialData =
{
	ajaxLink: "user/datatables/",
	tableSelector: '#usersDataTable',
	item: 'user',
	deleteItems: tgui_userApi.delete,
	exportCsv: tgui_userApi.csvDownload || function(){return false;},
  columns:
	{
		id: {title: "ID", data : "id", orderable: true, visible: false,},
		username: {title: "Username", data : "username", visible: true, orderable: true},
		group: {title: "Group", data : "group", visible: true, orderable: false},
		email: {title: "Email", data : "email", visible: false, orderable: false},
		firstname: {title: "Firstname", data : "firstname", visible: false, orderable: false},
		surname: {title: "Surname", data : "surname", visible: false, orderable: false},
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
		this.settings.columnDefs = [],
		console.log(this.settings);
		this.table = $(initialData.tableSelector).DataTable(this.settings);
	},
	table: {},
	settings: new tgui_datatables(initialData),
};

//$.fn.dataTable.ext.errMode = 'throw';
