var fastImport = {
  formId: ' form#fastImportForm ',
  select_creden: ' form#fastImportForm ' + ' .select_creden.select2 ',
  select_tac_dev: ' form#fastImportForm ' + ' .select_tac_dev.select2 ',
  init: function() {
    /*Select2 TAC Devices*/
    this.tacDevSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"tacacs/device/list/",
      template: this.selectionTemplate,
      placeholder: "Select TacGUI Device",
      allowClear: true,
      add: this.select_tac_dev,
    });
    $(this.select_tac_dev).select2(this.tacDevSelect2.select2Data());

    /*Select2 Credential*/
    this.credenSelect2 = new tgui_select2({
      ajaxUrl : API_LINK+"confmanager/credentials/list/",
      template: this.selectionTemplate,
      placeholder: "Select Credential",
      allowClear: true,
      add: this.select_creden,
    });
    $(this.select_creden).select2(this.credenSelect2.select2Data());
  },

  start: function() {
    var self = this;
    var formData = tgui_supplier.getFormData(self.formId);

    if (!formData.tac_device) {
      tgui_error.local.show({type:'error', message: "Please, select tacacs device!"});
      return;
    }
    if ( $(this.select_tac_dev).select2('data')[0].prefix != 32 ) {
      tgui_error.local.show({type:'error', message: "Tac Device configured with network address (prefix error)!"});
      return;
    }
    formData.name = $(this.select_tac_dev).select2('data')[0].text;
    formData.ip = $(this.select_tac_dev).select2('data')[0].ipaddr;

    var ajaxProps = {
      url: API_LINK+"confmanager/devices/add/",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formId)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Device "+ formData.name +" was added"})

      setTimeout( function () {dataTable.table.ajax.reload()}, 2000 );
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })

    return
  },

  selectionTemplate: function(data){
    //console.log(data);
    var output='<div class="selectServiceOption">';
      output += '<text>'+data.text+'</text>';
      output += '<input class="item-attr" type="hidden" name="id" value="'+data.id+'">';
      output += '</div>'
    return output;
  },
}
