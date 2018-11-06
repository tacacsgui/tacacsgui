
var tgui_userApi = {
  formSelector_add: 'form#addUserForm',
  formSelector_edit: 'form#editUserForm',
  select_group_add: '#addUserForm div.group .select_group.select2',
  select_group_edit: '#editUserForm div.group .select_group.select2',
  init: function() {
    var self = this;
    /*cleare forms when modal is hided*/
    $('#addUser').on('hidden.bs.modal', function(){
      self.clearForm();
    })
    $('#editUser').on('hidden.bs.modal', function(){
      self.clearForm();
    })/*cleare forms*///end

    $(self.formSelector_add + ' select[name="enable_flag"]').change(function(){
    	var en_encr = self.formSelector_add + ' div.enable_encrypt_section';
    	if ($(this).val() == 1 || $(this).val() == 2){
    		$(en_encr).show()
    	} else {
    		$(en_encr).hide()
    	}
    })
    $(self.formSelector_edit + ' select[name="enable_flag"]').change(function(){
      var en_encr = self.formSelector_edit + ' div.enable_encrypt_section';
      if ($(this).val() == 1 || $(this).val() == 2){
    		$(en_encr).show()
    	} else {
    		$(en_encr).hide()
    	}
    })

    /*Select2 Group*/
    this.userGrpSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"user/group/list/",
      template: this.selectionTemplate,
      add: this.select_group_add,
      edit: this.select_group_edit,
    });
    $(this.select_group_add).select2(this.userGrpSelect2.select2Data());
    $(this.select_group_edit).select2(this.userGrpSelect2.select2Data());
    /*Select2 Group*///END
    $('#addUser').on('show.bs.modal', function(){
    	self.userGrpSelect2.preSelection(0, 'add');
    })

  },
  add: function() {
    console.log('Adding new API User');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
        formData.group = ($(this.select_group_add).select2('data').length) ? $(this.select_group_add).select2('data')[0].id : 0;
    var ajaxProps = {
      url: API_LINK+"user/add/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "User "+ $(self.formSelector_add + ' input[name="username"]').val() +" was added"})
      $("#addUser").modal("hide");

      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  getInfo: function(id, username) {
    var self = this;
    var ajaxProps = {
      url: API_LINK+"user/edit/",
      type: "GET",
      data: {
        "username": username,
        "id": id,
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.user, self.formSelector_edit);

      self.userGrpSelect2.preSelection(resp.user.group, 'edit', 1);

      $(self.formSelector_edit + ' input[name="group_native"]').val(resp.user.group);
      $(self.formSelector_edit + ' input[name="username"]').prop('disabled', true);
      $('#editUser').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  edit: function() {
    console.log('Editing user');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);

    if ($(this.select_group_edit).select2('data').length && $(this.select_group_edit).select2('data')[0].id != $(self.formSelector_edit + ' [name="group_native"]').val()) {formData.group = $(this.select_group_edit).select2('data')[0].id;}

    var ajaxProps = {
      url: API_LINK+"user/edit/",
      type: 'POST',
      data: formData
    };//ajaxProps END

    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) return false;
    
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "User "+ $(self.formSelector_edit + ' input[name="username"]').val() +" was edited"})
      $("#editUser").modal("hide");

      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  delete: function(id, username, flag) {
    id = id || 0;
    flag = (flag !== undefined) ? false : true;
    username = username || 'undefined';
    if (flag && !confirm("Do you want delete '"+username+"'?")) return;
    var ajaxProps = {
      url: API_LINK+"user/delete/",
      data: {
        "username": username,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(resp.result != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "User "+ username +" was deleted"})

      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  clearForm: function() {
    tgui_supplier.clearForm();
    /*---*/
  },
  selectionTemplate: function(data){
    console.log(data);
    data.default_flag = (data.id != 0) ? data.default_flag : false;
    var default_flag_class = (data.default_flag) ? 'option_default_flag': ''
  	var output='<div class="selectGroupOption '+ default_flag_class +'">';
  		output += '<text>'+data.text+'</text>';
  		output += '<specialFlags>';
  		output += (data.default_flag) ? ' <small class="label pull-right bg-gray" style="margin:3px">d</small>' : '';
  		output += '</specialFlags>'
  	output += '</div>'
  	return output;
  	return output;
  },
  showPasswd: function(button, action) {
    action = action || 'hide';
    var parentDiv = $($(button).parent('div')).parent('div');
    (action == 'show') ? $( $(parentDiv).children('input')[0] ).attr('type','text') : $($(parentDiv).children('input')[0] ).attr('type','password');
  }
}
