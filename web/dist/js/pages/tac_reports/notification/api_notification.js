var api_notification = {
  init: function() {
    this.settings.get();
    this.post_log.init();
    this.post_buffer.init();
    console.log(this);
  },
  settings: {
    formId: '#notification_settings',
    get: function() {
      var self = this;
      var ajaxProps = {
        url: API_LINK+"notification/settings/",
        type: "GET",
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        console.log(resp);
        tgui_supplier.fulfillForm(resp.settings, self.formId);
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })
    },
    save: function() {
      var self = this;

      var formData = tgui_supplier.getFormData(self.formId, true);

      var ajaxProps = {
        url: API_LINK+"notification/settings/",
        type: "POST",
        data: formData
      };//ajaxProps END

      if ( ! Object.keys(ajaxProps.data).length ) {
        tgui_error.local.show({type:'warning', message: "Changes did not found"})
        return;
      }
      if ( formData.bad_authentication_email_list ) formData.bad_authentication_email_list=formData.bad_authentication_email_list.split(";").map( s => s.trim() )
      if ( formData.bad_authorization_email_list ) formData.bad_authorization_email_list=formData.bad_authorization_email_list.split(";").map( s => s.trim() )
      if ( formData.bad_authentication_email_list != undefined && !formData.bad_authentication_email_list.length ) formData.bad_authentication_email_list = [null];
      if ( formData.bad_authorization_email_list != undefined && !formData.bad_authorization_email_list.length ) formData.bad_authorization_email_list = [null];


      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (tgui_supplier.checkResponse(resp.error, self.formId)){
          return;
        }

        self.get();
        tgui_error.local.show({type:'success', message: "Settings were saved"});
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })
    }
  },
  post_log:{
    init: function() {
      this.datatables = new tgui_datatables(this.initialData);
      this.datatables.table = {};
  		this.datatables.columnsFilter({initialData_f: this.initialData, dataTable_f: this.datatables});
  		//this.datatables.preview();
  		this.datatables.columnDefs = [];
  		this.datatables.table = $(this.initialData.tableSelector).DataTable(this.datatables);

  	},

    initialData: {
      ajaxLink: "notification/post/logging/",
      tableSelector: '#postLogDataTable',
      item: 'post_log',
      //exportCsv: tgui_authentication.csvDownload || function(){return false;},
      columns:
      {
        id: {title: "ID", data : "id", orderable: false, visible: false,},
        date: {title: "Date", data : "date", visible: true, orderable: true},
        server: {title: "Server", data : "server", visible: false, orderable: false},
        device_ipaddr: {title: "Device IP", data : "device_ipaddr", visible: true, orderable: false},
        username: {title: "Username", data : "username", visible: true, orderable: false},
        user_ipaddr: {title: "User IP", data : "user_ipaddr", visible: true, orderable: false},
        type: {title: "Type", data : "type", visible: true, orderable: false},
        receivers: {title: "Receivers", data : "receivers", visible: false, orderable: false},
        status: {title: "Status", data : "status", visible: true, orderable: false}
      },
      column:
      {
        select: true,
        preview: false
      },
      sort:
      {
        column: 1,
        order: 'desc'
      },
    },
    datatables:{}
  },
  post_buffer:{
    init: function() {
      console.log(this);
      this.datatables = new tgui_datatables(this.initialData);
      this.datatables.table = {};
  		this.datatables.columnsFilter({initialData_f: this.initialData, dataTable_f: this.datatables, colFilterBtnId: 'columnsFilter_buffer'});
  		//this.datatables.preview();
  		this.datatables.columnDefs = [];
  		this.datatables.table = $(this.initialData.tableSelector).DataTable(this.datatables);

  	},

    initialData: {
      ajaxLink: "notification/post/buffer/",
      tableSelector: '#postBufferDataTable',
      item: 'post_buffer',
      //exportCsv: tgui_authentication.csvDownload || function(){return false;},
      columns:
      {
        created_at: {title: "Created at", data : "created_at", orderable: false, visible: true,},
        date: {title: "Date", data : "date", visible: false, orderable: true},
        server: {title: "Server", data : "server", visible: false, orderable: false},
        device_ipaddr: {title: "Device IP", data : "device_ipaddr", visible: true, orderable: false},
        username: {title: "Username", data : "username", visible: true, orderable: false},
        user_ipaddr: {title: "User IP", data : "user_ipaddr", visible: true, orderable: false},
        type: {title: "Type", data : "type", visible: true, orderable: false}
      },
      column:
      {
        select: true,
        preview: false
      },
      sort:
      {
        column: 1,
        order: 'desc'
      },
    },
    datatables:{}
  }
}
