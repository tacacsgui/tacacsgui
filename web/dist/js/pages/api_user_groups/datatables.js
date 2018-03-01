$("#filterButton").click(function() { 
			
	if ($("#filterFields").css('display') != 'none') {
		$("#filterFields").hide("slow"); 
		return;
	};
	if ($("#filterFields").css('display') == 'none') {$("#filterFields").show("slow"); return;};
			
});
			
var dataTable =  $('#userGroupsDataTable').DataTable( {
				
	//scrollX: true,	
	processing: true,
	serverSide: true,
	autoWidth: false,	
		
	"createdRow": function( row, data, dataIndex){
		if(data['default_flag']) $(row).addClass('greenRow');
	},
	"columns": [ 
	{"title": "ID", "data" : "id"},
	{"title": "Name", "data" : "name"},
	{"title": "Rights", "data" : "rights"},
	{"title": "Action", "data" : "buttons", "searchable": false},
	 ],
	"columnDefs": [ 
	{
		"targets": [ 2 ],
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
	}, 
	{
		"targets": [2,3],
		"orderable": false
	} ],
	"lengthMenu": [ 10, 25, 50, 75, 100 ],
							
	ajax: {"url": API_LINK+"user/group/datatables/",
		"type": "POST",
		"data": {
			"temp": "acc"
		}
	}, // json datasource
	
	"drawCallback": function( settings ) {
		var filterRow='';
		var filterRowElement=$('<tr role="row" id="filterFields" style="display: none;"></tr>')
		for (i = 0; i < settings.aoColumns.length; i++) { 
			filter='<td></td>';
			if (settings.aoColumns[i].bSearchable) 
			{
				var filter = $("<td></td>");
				var inputElement=$('<input searchCol_id="'+i+'" class="search-input form-control">')
				filterRowElement.append(filter.append(inputElement))
			}
			filterRow+=filter;
		}
        $('#userGroupsDataTable thead').append(filterRowElement);
		tooltips();
    }

});

$.fn.dataTable.ext.errMode = 'throw';
				
$("#userGroupsDataTable_filter").css("display","none");  // hiding global search box

$(document).on('keyup click change', '.search-input', function(){     
	var i =$(this).attr('searchCol_id');  // getting column index
	var v =$(this).val();  // getting search input value
	dataTable.columns(i).search(v).draw();
} );