
var tgui_acl = {
  formSelector_add: 'form#addACLForm',
  formSelector_edit: 'form#editACLForm',
  init: function() {
    var self = this;

    this.csvParser = new tgui_csvParser(this.csv);
    /*cleare forms when modal is hided*/
    $('#addACL').on('hidden.bs.modal', function(){
    	self.clearForm();
    })
    $('#editACL').on('hidden.bs.modal', function(){
    	self.clearForm();
    })/*cleare forms*///end
  },
  tableToObject: function(t,n){
    var a = [{'name': n, 'line_number': 0, 'nac':'', 'nas':'', 'timerange':''}]
    for (var i = 0, len = t.length; i < len; i++) {
      a[a.length] = {
				'line_number': t[i].line_number || a.length,
				'action':t[i].action || 'deny',
				'nac':t[i].nac || '0.0.0.0/32',
				'nas':t[i].nas || '0.0.0.0/32',
				'timerange':t[i].timerange || ''
			}
      if (t[i].id) a[a.length-1].id = t[i].id
    }
    return a;
  },
  add: function(o) {
    if ( this.ace.editor() ) { return; }
    console.log('Adding new ACL');
    var self = this;
    var l = Ladda.create(o)
    l.start(); //button loading start
    var formData = tgui_supplier.getFormData(self.formSelector_add);
    	  formData.ACEs = this.tableToObject(dataTable_add_acl.rows().data(), formData.name);
    var ajaxProps = {
      url: API_LINK+"tacacs/acl/add/",
      data: formData
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      l.stop(); //button loading start
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "ACL "+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addACL").modal("hide");
			tgui_status.changeStatus(resp.changeConfiguration)
			self.clearForm();
			setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  getAcl: function(id, name) {
    var self = this;
    ajaxData['name'] = name
  	ajaxData['id'] = id

    dataTable_edit_acl.ajax.reload(function(resp){
      if (!dataTable_edit_acl.rows().data().length) return;

      $(self.formSelector_edit +' input[name="name"]').val(name)
      $(self.formSelector_edit +' input[name="name_native"]').val(name)
      $(self.formSelector_edit +' input[name="id"]').val(id)
      $('accesslist').text(name)
      $("#editACL").modal("show");
    });
  },
  edit: function() {
    if ( this.ace.editor() ) { return; }
    console.log('Edit ACL');
    var self = this;
    var l = Ladda.create(o)
    l.start(); //button loading start
    var formData = tgui_supplier.getFormData(self.formSelector_edit);
        formData.ACEs = this.tableToObject(dataTable_edit_acl.rows().data(), formData.name);
        if (this.ace.deleted_aces) formData.deleted_aces = this.ace.deleted_aces;
        if(formData.name) formData.name_native = $(self.formSelector_edit + ' [name="name_native"]').val();
    var ajaxProps = {
      url: API_LINK+"tacacs/acl/edit/",
      data: formData
    };//ajaxProps END

    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) {
      l.stop()
      return false;
    }

    ajaxRequest.send(ajaxProps).then(function(resp) {
      l.stop()
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "ACL "+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      $("#editACL").modal("hide");
			tgui_status.changeStatus(resp.changeConfiguration)
			self.clearForm();
			setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  delete: function(id, name, flag){
    console.log('Deleting ACLid:'+id+' with name '+name)
    flag = (flag !== undefined) ? false : true;
    if (flag && !confirm("Do you want delete '"+name+"'?")) return;
    var self = this;

    var ajaxProps = {
      url: API_LINK+"tacacs/acl/delete/",
      data: {name: name, id: id}
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if( resp.result < 1 ) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "ACL "+ name +" was deleted"})
			tgui_status.changeStatus(resp.changeConfiguration)
			setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  csv: {
    columnsRequired: ['name'],
    fileInputId: '#csv-file',
    ajaxLink: 'tacacs/acl/add/',
    ajaxItem: 'acl',
    outputId: '#csvParserOutput',
    ajaxHandler: function(resp,index){
      var item = 'acl';
      if (resp.error && resp.error.status){
        var error_message = '';
        for (v in resp.error.validation){
          if (!(resp.error.validation[v] == null)){
            for (num in resp.error.validation[v]){
              error_message+='<p class="text-danger">'+resp.error.validation[v][num]+'</p>';
            }
            this.csvParserOutput({tag: error_message, response: index});
          }
        }
      }
      if (resp[item] && resp[item].name) {
        this.csvParserOutput({tag: '<p class="text-success">ACL <b>'+ resp[item].name + '</b> was added!</p>', response: index});
        tgui_status.changeStatus(resp.changeConfiguration)
      }
      this.csvParserOutput({tag: '<hr>'});
    },
    finalAnswer: function() {
      this.csvParserOutput({message: 'End of CSV file. Reload database.'})
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }
  },
  clearForm: function(){
    tgui_supplier.clearForm();
    /*---*/
    dataTable_add_acl.clear().draw();
    dataTable_edit_acl.clear().draw();
    this.ace.deleted_aces = [];
    $('.form-group.has-error').removeClass('has-error');
  	$('p.text-red').remove();
  	$('p.help-block').show();
  },
  ace: {
    tableId: 'aclDT',
    aclDT_add: dataTable_add_acl,
    aclDT_edit: dataTable_edit_acl,
    errorBlockedTimeout: {},
    editor: function(){
      clearTimeout(this.errorBlockedTimeout);
      $('.blockAnimation').removeClass('blockAnimation')
      $('.form-group.has-error').removeClass('has-error');
      $('p.text-red').remove();
      $('p.help-block').show();
      if ($('.btn-createACE').length) {
        $('.btn-createACE').closest('tr[role="row"]').addClass('blockAnimation');
        this.errorBlockedTimeout = setTimeout(function(){$('.blockAnimation').removeClass('blockAnimation')},3000)
        return true;
      }
      return false;
    },
    add: function(button, position){
      if ( this.editor() ) { return; }

      var form = $(button).parents('form')[0]

      dt = this['aclDT_'+$(form).attr('data-extra')];

      var inputElement = document.createElement('input')
      var line_number = 1
      if (position == 'down') line_number = ( dt.row(':last').data() ) ? parseInt(dt.row(':last').data().line_number) + 1 : 1;
      if (position == 'top'){
        rowsData = [];
        for (var i = 0, len = dt.rows().data().length; i < len; i++) {
          dt.rows().data()[i].line_number++;
          rowsData[i]=dt.rows().data()[i];
        }
        dt.clear();
        dt.rows.add(rowsData).draw();
      }
      dt.row.add({
        "line_number" : line_number,
        "action" : '<div class="form-group"><select class="form-control action"><option value="permit" selected>permit</option><option value="deny">deny</option></select></div>',
        "nac" : '<div class="form-group"><input class="form-control nac" placeholder="0.0.0.0/0"></div>',
        "nas" : '<div class="form-group"><input class="form-control nas" placeholder="0.0.0.0/0"></div>',
        "timerange" : '<input class="form-control timerange" placeholder="timeRange" disabled>',
        "buttons" : '<button class="btn btn-success btn-createACE" onclick="tgui_acl.ace.save(this, '+line_number+')">Create</button>',
      }).draw(); //create row and set index to rowIndex variable
    },
    save: function(button, ln) {
      $('.form-group.has-error').removeClass('has-error');
      $('p.text-red').remove();
      $('p.help-block').show();

      var form = $(button).parents('form')[0]
      dt = this['aclDT_'+$(form).attr('data-extra')];
      form = '#'+$(form).attr('id');

      var row = $(button).parents('tr');
      var action = $(form+' select.action').val();
      var nac = ($(form+' input.nac').val() == '') ? '0.0.0.0/0' : $(form+' input.nac').val();
      var nas = ($(form+' input.nas').val() == '') ? '0.0.0.0/0' : $(form+' input.nas').val();
      var timerange = $(form+' input.timerange').val()
      console.log(nac+' '+nas+' '+timerange)
      var errorMessage='Incorrect ip addr or prefix';
      var errorFlag=false;
      if (!tgui_supplier.validateIp(nac)) {
        $('input.nac').parent().addClass('has-error').append('<p class="text-red">'+errorMessage+'</p>');
        errorFlag=true;
      }
      if (!tgui_supplier.validateIp(nas)) {
        $('input.nas').parent().addClass('has-error').append('<p class="text-red">'+errorMessage+'</p>');
        errorFlag=true;
      }
      if (errorFlag) return;

      var rowDataOld = dt.row(row).data()

      var rowData = {
        "line_number" : ln,
        "action" : action,
        "nac" : nac,
        "nas" : nas,
        "timerange" : timerange,
        "buttons" : '<div class="btn-group text-center">'+
        '<button type="button" class="btn btn-default" onclick="tgui_acl.ace.move(this, \'down\')"><i class="fa fa-caret-down"></i></button>'+
        '<button type="button" class="btn btn-default" onclick="tgui_acl.ace.move(this, \'up\')"><i class="fa fa-caret-up"></i></button>'+
        '<button type="button" class="btn btn-warning" onclick="tgui_acl.ace.edit(this)"><i class="fa fa-edit"></i></button>'+
        '<button type="button" class="btn btn-danger" onclick="tgui_acl.ace.delete(this)"><i class="fa fa-trash"></i></button>'+
        '</div>',
      }

      if (rowDataOld.id != undefined) rowData.id = rowDataOld.id;

      dt.row(row).data(rowData)
      console.log(dt.row(row).data())
      $('.blockAnimation').removeClass('blockAnimation')
    },
    edit: function(button) {
      if ( this.editor() ) { return; }

      var form = $(button).parents('form')[0]
      dt = this['aclDT_'+$(form).attr('data-extra')];
      var row = $(button).parents('tr');
      var rowData = dt.row(row).data()
      newRowData = {
        "line_number" : rowData.line_number,
        "action" : '<div class="form-group"><select class="form-control action"><option value="permit" '+ ((rowData.action == 'permit') ? 'selected' : '') +'>permit</option><option value="deny" '+ ((rowData.action == 'deny') ? 'selected' : '') +'>deny</option></select></div>',
        "nac" : '<input class="form-control nac" placeholder="0.0.0.0/0" value="'+rowData.nac+'">',
        "nas" : '<input class="form-control nas" placeholder="0.0.0.0/0" value="'+rowData.nas+'">',
        "timerange" : '<input class="form-control timerange" placeholder="timeRange" disabled>',
        "buttons" : '<button class="btn btn-warning btn-createACE" onclick="tgui_acl.ace.save(this, '+rowData.line_number+')">Edit</button>',
      }
      if (rowData.id != undefined) newRowData.id = rowData.id;
      dt.row(row).data(newRowData)
    },
    deleted_aces: [],
    delete: function(button){
      if ( this.editor() ) { return false; }
      var form = $(button).parents('form')[0]
      dt = this['aclDT_'+$(form).attr('data-extra')];
      var row = $(button).parents('tr');

      if (dt.row(row).data().id != undefined) this.deleted_aces[this.deleted_aces.length] = dt.row(row).data().id;
      dt.row(row).remove().draw();
      rowsData = [];
      for (var i = 0, len = dt.rows().data().length; i < len; i++) {
        dt.rows().data()[i].line_number = i+1;
        rowsData[i]=dt.rows().data()[i];
      }
      dt.clear();
      dt.rows.add(rowsData).draw();
    },
    move: function(button, direction){
      if ( this.editor() ) { return false; }

      var form = $(button).parents('form')[0]
      dt = this['aclDT_'+$(form).attr('data-extra')];
      var row = $(button).parents('tr');
      dt.row(row).data().line_number = direction;
      rowsData = dt.rows().data()
      var prevElement = -1;
      rowsData = rowsData.map(function(val,index){
        //console.log(val);console.log(index);
        if (val.line_number == 'up') {
          if (prevElement == -1) {val.line_number = 1; return val;}
          val.line_number = rowsData[prevElement].line_number;
          rowsData[prevElement].line_number++
          return val;
        }
        if (val.line_number == 'down') {
          if (rowsData[index+1] == undefined) {
            if (prevElement == -1) {val.line_number = 1; return val;}
            val.line_number = rowsData[prevElement].line_number + 1;
            return val;
          }
          val.line_number = rowsData[index+1].line_number;
          rowsData[index+1].line_number--
          return val;
        }
        prevElement=index;
        return val;
      })
      dt.clear();
      dt.rows.add(rowsData).draw();
    }
  }
}
