
var tgui_service = {
  formSelector_add: 'form#addServiceForm',
  formSelector_edit: 'form#editServiceForm',
  init: function() {
    var self = this;

    this.csvParser = new tgui_csvParser(this.csv);
    /*cleare forms when modal is hided*/
    $('#addService').on('hidden.bs.modal', function(){
    	self.clearForm();
    })
    $('#editService').on('hidden.bs.modal', function(){
    	self.clearForm();
    })/*cleare forms*///end
  },
  add: function() {
    console.log('Adding new service');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
    var ajaxProps = {
      url: API_LINK+"tacacs/services/add/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Service "+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addService").modal("hide");
      tgui_status.changeStatus(resp.changeConfiguration)
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  getService: function(id, name) {
    var self = this;
    var ajaxProps = {
      url: API_LINK+"tacacs/services/edit/",
      type: "GET",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.service, self.formSelector_edit);

      $(self.formSelector_edit + ' input[name="priv-lvl-preview"]').val( ( parseInt(resp.service['priv-lvl']) > -1) ? resp.service['priv-lvl'] :  "Undefined");
      $('#editService').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  edit: function() {
    console.log('Editing service');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);

    var ajaxProps = {
      url: API_LINK+"tacacs/services/edit/",
      type: 'POST',
      data: formData
    };//ajaxProps END

    if ( Object.keys(ajaxProps.data).length <= 1) {
      if (Object.keys(ajaxProps.data)[0] == "id") {
        tgui_error.local.show({type:'warning', message: "Changes did not found"})
        return;
      }
    }
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Service "+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      $("#editService").modal("hide");
      tgui_status.changeStatus(resp.changeConfiguration)
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  delete: function(id, name, flag) {
    id = id || 0;
    flag = (flag !== undefined) ? false : true;
    name = name || 'undefined';
    if (flag && !confirm("Do you want delete '"+name+"'?")) return;
    var ajaxProps = {
      url: API_LINK+"tacacs/services/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if( parseInt(resp.result) != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "Service "+ name +" was deleted"})
      tgui_status.changeStatus(resp.changeConfiguration)
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  csvDownload: function(idList) {
    idList = idList || [];
  if (! idList.length ) $('div.csv-link').empty().append(tgui_supplier.loadElement());
  else { $('#exportLink').removeClass('m-progress').addClass('m-progress').attr('href', 'javascript: void(0)').show(); }
  var ajaxProps = {
    url: API_LINK+"tacacs/services/csv/",
    data: {idList: idList}
  };//ajaxProps END
  ajaxRequest.send(ajaxProps).then(function(resp) {
    if(!resp.filename) {
      tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
    }
    if (! idList.length ) { $('div.csv-link').empty().append('<a href="/api/download/csv/?file=' + resp.filename + '" target="_blank">Download</a><p><small class="text-muted">Link will be valid within 15 minutes</small></p>') }
    else {
      $('#exportLink').removeClass('m-progress').attr('href', '/api/download/csv/?file=' + resp.filename);
    }
  }).fail(function(err){
    tgui_error.getStatus(err, ajaxProps)
  })
  },
  csv: {
    columnsRequired: ['name'],
    fileInputId: '#csv-file',
    ajaxLink: 'tacacs/services/add/',
    outputId: '#csvParserOutput',
    ajaxHandler: function(resp,index){
      var item = 'service';
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
        this.csvParserOutput({tag: '<p class="text-success">Service <b>'+ resp[item].name + '</b> was added!</p>', response: index});
        tgui_status.changeStatus(resp.changeConfiguration)
      }
      this.csvParserOutput({tag: '<hr>'});
    },
    finalAnswer: function() {
      this.csvParserOutput({message: 'End of CSV file. Reload database.'})
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }
  },
  clearForm: function() {
    tgui_supplier.clearForm();
    /*---*/
    $('.nav.nav-tabs a[href="#general_info"]').tab('show');//select first tab
  	$('.nav.nav-tabs a[href="#general_info_edit"]').tab('show');//select first tab
  }
}
