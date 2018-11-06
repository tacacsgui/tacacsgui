
var tgui_apiUserGrp = {
  formSelector_add: 'form#addUserGroupForm',
  formSelector_edit: 'form#editUserGroupForm',
  init: function() {
    var self = this;
    /*cleare forms when modal is hided*/
    $('#addUserGroup').on('hidden.bs.modal', function(){
      self.clearForm();
    })
    $('#editUserGroup').on('hidden.bs.modal', function(){
      self.clearForm();
    })/*cleare forms*///end

    $(self.formSelector_add + ' .moveOptionRight').click(function (){
    	$(self.formSelector_add+' select.availableOptions :selected').each(function(){
    		this.selected = false;
    		$(self.formSelector_add+' select.selectedOptions').append(this);
    	})
    })
    $(self.formSelector_add + ' .moveOptionLeft').click(function (){
    	$(self.formSelector_add+' select.selectedOptions :selected').each(function(){
    		this.selected = false;
    		$(self.formSelector_add+' select.availableOptions').append(this);
    	})
    })
    ////////FOR THE EDIT FORM///
    $(self.formSelector_edit + ' .moveOptionRight').click(function (){
    	$(self.formSelector_edit +' select.availableOptions :selected').each(function(){
    		this.selected = false;
    		$(self.formSelector_edit +' select.selectedOptions').append(this);
    	})
    })
    $(self.formSelector_edit  + ' .moveOptionLeft').click(function (){
    	$(self.formSelector_edit +' select.selectedOptions :selected').each(function(){
    		this.selected = false;
    		$(self.formSelector_edit +' select.availableOptions').append(this);
    	})
    })

    $('#addUserGroup').on('show.bs.modal', function(){
    	self.getRightsList();
    })
  },
  add: function() {
    console.log('Adding new API User Group');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_add);
        formData.rights = [];
  	$(self.formSelector_add +' select.selectedOptions option').each(function(){
  		formData.rights.push($(this).val())
  	})
    var ajaxProps = {
      url: API_LINK+"user/group/add/",
      data: formData
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_add)){
        return;
      }
      tgui_error.local.show({type:'success', message: "User Group"+ $(self.formSelector_add + ' input[name="name"]').val() +" was added"})
      $("#addUserGroup").modal("hide");
      self.clearForm();
      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  getInfo: function(id, name) {
    var self = this;
    var ajaxProps = {
      url: API_LINK+"user/group/edit/",
      type: "GET",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.group, self.formSelector_edit);

      var selectedRights = resp.group.rights.toString(2).split('').reverse()
			var selectedValue = [];
			for (var i=0; i < selectedRights.length; i++)
			{
				if (selectedRights[i] == 1) selectedValue.push(i);
			}
      self.getRightsList(self.formSelector_edit, selectedValue);

      $('#editUserGroup').modal('show')
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  edit: function() {
    console.log('Editing user group');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector_edit, true);
        formData.rights = [];
    $(self.formSelector_edit +' select.selectedOptions option').each(function(){
      formData.rights.push($(this).val())
    })

    var ajaxProps = {
      url: API_LINK+"user/group/edit/",
      data: formData
    };//ajaxProps END

    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) return false;
    
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector_edit)){
        return;
      }
      tgui_error.local.show({type:'success', message: "User Group"+ $(self.formSelector_edit + ' input[name="name"]').val() +" was edited"})
      $("#editUserGroup").modal("hide");

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
      url: API_LINK+"user/group/delete/",
      data: {
        "name": name,
        "id": id,
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if(resp.result != 1) {
        tgui_error.local.show( {type:'error', message: "Oops! Unknown error appeared :("} ); return;
      }
      tgui_error.local.show({type:'success', message: "User Group"+ name +" was deleted"})

      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  clearForm: function() {
    tgui_supplier.clearForm();
    /*---*/
    $('select.selectedOptions').empty();
    $('select.availableOptions').empty();
  },
  getRightsList: function(selector, selected) {
    selector = selector || this.formSelector_add;
    selected = selected || [];
    var self = this;

    var ajaxProps = {
      url: API_LINK+"user/group/rights/",
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      console.log(resp)
      if (selector == self.formSelector_add)
			{
				for (i=0; i < resp.rights.length; i++)
				{
					option = new Option(resp.rights[i].name, resp.rights[i].value, false, false)
					$(selector +' select.availableOptions').append(option);
				}
				return;
			}
      if (selector == self.formSelector_edit)
			{
        for (i=0; i < resp.rights.length; i++)
				{
					option = new Option(resp.rights[i].name, resp.rights[i].value, false, false)

					if (selected.includes(parseInt(resp.rights[i].value)))
					{
						$(selector +' select.selectedOptions').append(option);
					}
					else
					{
						$(selector +' select.availableOptions').append(option);
					}
				}
				return;
			}
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  }
}
