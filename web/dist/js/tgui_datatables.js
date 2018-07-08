var tgui_datatables = function(data){
	data = data || {};
  data.ajaxLink = data.ajaxLink || '';
  data.item = data.item || 'device';
  data.deleteItems = data.deleteItems || function(){return false;};
  data.exportCsv = data.exportCsv || function(){return false;};
  data.tableSelector = data.tableSelector || 'null';
  data.columns = data.columns || [];
  data.column = data.column || {};
  data.column.select = data.column.select || false;
  data.column.preview = data.column.preview || false;
	data.sort = data.sort || {};
	data.sort.column = data.sort.column || 3;
	data.sort.order = data.sort.order || 'asc';

	var columns = [];
	if (data.column.select) columns[columns.length] =
	{
		title: '',
		orderable: false,
		className: 'select-checkbox',
		data:           null,
		defaultContent: '',
		targets:   0,
		searchable: false
	};
	if (data.column.preview) columns[columns.length] =
	{
		title: '',
		className:      'details-control',
		orderable:      false,
		data:           null,
		defaultContent: '',
		searchable: false
	};
	for (var name in data.columns) {
		if (data.columns.hasOwnProperty(name)) {
			columns[columns.length] = data.columns[name];
		}
	}

	return {
		//scrollX: true,
		"dom": 'lrtip',
		processing: true,
		serverSide: true,
		autoWidth: false,
		orderCellsTop: true,
		bProcessing: true,

		columns: columns,
		 /* Select params*/
		 select: (!data.column.select) ? false :
		 {
			 style:    'os',
			 selector: 'td:first-child',
			 className: 'selected row-selected'
		 },
		 /*Class for ordable column*/
		 orderClasses: false,
		 /* Order start with ID*/
		 order: [[data.sort.column, data.sort.order]],
		 /* Menu length*/
		 lengthMenu: [ 10, 25, 50, 75, 100 ],

		 createdRow: function( row, data, dataIndex){
		 	if( data['disabled'] == 1 ) $(row).addClass('disabledRow');
			},

		 drawCallback: function( settings ) {
		 	$('#filterRequest').removeClass('filter-input-success filter-input-error');
		 	$('.filterMessage').empty().hide();
		 	switch (true) {
		 		case (! $('#filterRequest').val()):
		 			//nothing
		 			break;
		 		case (settings.json.filter && settings.json.filter.error):
		 			$('#filterRequest').addClass('filter-input-error');
		 			if (settings.json.filter.message) $('.filterMessage').append('<p class="text-danger">'+settings.json.filter.message+'</p>').show();
		 			break;
		 		case (settings.json.filter && !settings.json.filter.error):
		 			$('#filterRequest').addClass('filter-input-success');
		 			break;
		 		default:
		 	}
		 	if ( ! $('#filterRequest').val() )
		 	tguiInit.tooltips();
		},

		 /* AJAX params*/
		 ajax: {
			 url: API_LINK + data.ajaxLink,
			 type: "POST",
			 data: {
				 //queries: dataTable.queries
			 }
		 }, // json datasource

		 columnsFilter: function() {
	 		initialData = initialData || {};
	 		var i = (data.column.select && data.column.preview) ? 2 : 1;

	 		for (var rowName in initialData.columns) {
	 			if (initialData.columns.hasOwnProperty(rowName)) {
	 				$('#columnsFilter').append('<li><a href="#" data-value="'+i+'"><i class="fa fa' + ( ( initialData.columns[rowName].visible ) ? '-check' : "" ) + '-square-o"></i>&nbsp;'+initialData.columns[rowName].title+'</a></li>');
	 				i++;
	 			}
	 		}
	 		var self = this;
	 		$( '#columnsFilter a' ).on( 'click', function( event ) {
	 			var $target = $( event.currentTarget ),
	 	        val = $target.attr( 'data-value' );
	 					var column = dataTable.table.column( val );
	 					var icon = $($target.children('i'));
	 					icon.removeClass('fa-check-square-o fa-square-o').addClass( ( column.visible() ) ? 'fa-square-o' : 'fa-check-square-o' );

	 					column.visible( ! column.visible() );
	 	    $( event.target ).blur();
	 	    return false;
	 		})
	 		$(document).on('keyup change', '#filterRequest', function(){
	 			var v =$(this).val();  // getting search input value
	 			if (!v) { $('#filterRequest').removeClass('filter-input-success filter-input-error'); return; }
	 			dataTable.table.search(v).draw();
	 		} );
	 	},
	 	filter: function() {
	 		if ($("div.datatable-filter").css('display') != 'none')	$("div.datatable-filter").hide("slow");
	 		else  $("div.datatable-filter").show("slow");
	 	},
		filterErase: function() {
			$('#filterRequest').val('').removeClass('filter-input-success filter-input-error'); $('.filterMessage').hide();
			dataTable.table.search('').draw();
		},
	 	deleteSelected: function() {
	 		var selectedCount = $(data.tableSelector + ' tr.selected').length;
	 		if ( ! selectedCount ) {
	 			tgui_error.local.show( {type:'warning', message: "Nothing selected"} ); return;
	 		}
	 		if (!confirm('Do you want to delete '+selectedCount+' row(s)?')) return;
	 		var rowData = {};
	 		for (var i = 0; i < selectedCount; i++) {
	 			rowData = dataTable.table.row( $(data.tableSelector + ' tr.selected')[i] ).data();
	 			data.deleteItems(rowData.id, rowData.name || rowData.username, false);
	 		}
	 	},
	 	exportCsv: function() {
	 		var selectedCount = $(data.tableSelector + ' tr.selected').length;
	 		if ( ! selectedCount ) {
	 			tgui_error.local.show( {type:'warning', message: "Nothing selected"} ); return;
	 		}
	 		var idList = [];
	 		for (var i = 0; i < selectedCount; i++) {
	 			idList[idList.length] = dataTable.table.row( $(data.tableSelector + ' tr.selected')[i] ).data().id;
	 		}
	 		data.exportCsv(idList);
	 	},
	 	preview: function() {
	 		/* Preview Function*/
	 		$(data.tableSelector + '').on('click', 'td.details-control', function () {
	 		    var tr = $(this).closest('tr');
	 		    var row = dataTable.table.row( tr );
	 		    if ( row.child.isShown() ) {
	 		        // This row is already open - close it
	 		        row.child.hide();
	 		        tr.removeClass('shown');
	 		    }
	 		    else {
	 		        // Open this row
	 		        row.child( '<pre class="partial_config partial_config_'+row.data().id+'">Loading...</pre>' ).show();
	 		        tr.addClass('shown');
	 						row.child( tgui_supplier.showConfiguration(row.data(), data.item) ).show();
	 		    }
	 		} );
	 	}
	}
}
