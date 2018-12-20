var tgui_select2 = function(o)
{
  o = o || {};
  i = {
    ajaxUrl : o.ajaxUrl || API_LINK+"tacacs/device/group/list/",
    template: o.template || function(){return false;},
    add: o.add || '.select2',
    edit: o.edit || '.select2',
    divClass: o.divClass || 'unknown',
    mainName: o.mainName || 'select_something',
  }
  return {
    add: i.add,
    edit: i.edit,
    divClass: i.divClass,
    mainName: i.mainName,
    ajaxUrl: i.ajaxUrl,
    select2Data: function () {
      var self = this;
      return {
        containerCssClass : "error",
      	ajax:{
      		url: this.ajaxUrl,
          delay: 250,
      		dataType: 'json',
          data: function (params) {
            var query = {
              search: params.term,
              page: params.page || 1,
              multiple: o.multiple || 0,
              extra: o.extra || null,
              type: 'public'
            }
            // Query parameters will be ?search=[term]&type=public
            return query;
          },
      		// processResults: function (data) {
      		// 	// Tranforms the top-level key of the response object from 'items' to 'results'
      		// 	return {
      		// 		results: data.items
      		// 	};
      		// },
          transport: function (params, success, failure) {
            var $request = $.ajax(params);
            $request.then(success);
            $request.fail(failure);

            return $request;
          }
      	},
      	escapeMarkup: function(markup){ return markup;},
      	templateResult: self.selectionTemplate,
      	templateSelection: self.selectionTemplate,
      	//minimumResultsForSearch: Infinity
      };
    },

    selectionTemplate: i.template,

    preSelection: function(byId, selector, extra){
      extra = extra || {};
      //extra.noajax = extra.noajax;
      var self = this;
      byId = byId || 0;
      selector = selector || 'add';

      var ajaxProps = {
        url: this.ajaxUrl,
        type: "GET",
        data: { "byId": byId }
      };
      if (extra) ajaxProps.data.extra = extra;

      ajaxRequest.send(ajaxProps).then(function(resp) {
        resp.item = resp.item || []
        if( ! Array.isArray(resp.item) ) resp.item = [ resp.item ];
        for (var i = 0; i < resp.item.length; i++) {
          var id = resp.item[i].id || 0
          //console.log(id, resp.item[i]);
          //resp.item[i].id = 0;
          //var output = self.selectionTemplate(resp.item[i]);
          //var option = new Option(self.selectionTemplate(resp.item[i]), id, true, true);
          var option = new Option('', id, true, true);
          $(option).data( { data: resp.item[i] } );
          //console.log( $(option).data() );
    			if (selector == 'add') $(self.add).append(option).trigger('change');
    			if (selector == 'edit') $(self.edit).append(option).trigger('change');
        }

      }).fail(function(err){
        if (err.status != 403) tgui_error.getStatus(err, ajaxProps);
        $(self.edit).prop('disabled', true);
      })
    },
    init_sortable: function(divClass) {
      //console.log(this);
      $('.'+divClass + ' ul').sortable({containment: 'parent'});
      $('.'+divClass + ' ul').disableSelection();
    },
    diff: function(sel_select2, sel_native, notextarea)
    {

      //var selData = this.getData(sel_select2, {});
      return true;
      return ( selData != $(sel_native).val() )
    },
    getData: function( sel_select2, params ){
      params = params || {}
      params.formId = params.formId || ''
      var selData = '';
      //console.log(this);
      params.separator = params.separator || ';;';
      if (!params.notextarea){
        var data = { items: [], attr: {} }
        //console.log( $(params.formId + ' div.'+this.divClass+' ul li') );
        for (var i = 0; i < $(params.formId + ' div.'+this.divClass+' ul li').length; i++) {
          if ($($(params.formId + ' div.'+this.divClass+' ul li')[i]).find('.item-attr').length == 0) continue;
          index = data.items.length;
          data.items[index] = {};
          for (var j = 0; j < $($(params.formId + ' div.'+this.divClass+' ul li')[i]).find('.item-attr').length; j++) {
            attr_name = $($($(params.formId + ' div.'+this.divClass+' ul li')[i]).find('.item-attr')[j]).attr('name')
            attr_val = $($($(params.formId + ' div.'+this.divClass+' ul li')[i]).find('.item-attr')[j]).val()
            if (!data.attr.hasOwnProperty(attr_name) ){
              data.attr[attr_name] = []
            }
            data.attr[attr_name][data.attr[attr_name].length] = attr_val;

            data.items[index][attr_name] = attr_val;
          }
        }
        return data;
      }
      for (var i = 0; i < $(sel_select2).select2('data').length; i++) {
        if (i == 0) { selData += $(sel_select2).select2('data')[i].id; continue; }
        selData += ';;' + $(sel_select2).select2('data')[i].id;
      }
      return selData;
    }
  }
}
