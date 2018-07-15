var tgui_select2 = function(o)
{
  o = o || {};
  i = {
    ajaxUrl : o.ajaxUrl || API_LINK+"tacacs/device/group/list/",
    template: o.template || function(){return false;},
    add: o.add || '.select2',
    edit: o.edit || '.select2',
  }
  return {
    add: i.add,
    edit: i.edit,
    ajaxUrl: i.ajaxUrl,
    select2Data: function () {
      var self = this;
      return {
      	ajax:{
      		url: this.ajaxUrl,
      		dataType: 'json',
      		processResults: function (data) {
      			// Tranforms the top-level key of the response object from 'items' to 'results'
      			return {
      				results: data.items
      			};
      		},
          transport: function (params, success, failure) {
            var $request = $.ajax(params);
            console.log(123);
            $request.then(success);
            $request.fail(failure);

            return $request;
          }
      	},
      	escapeMarkup: function(markup){ return markup;},
      	templateResult: self.selectionTemplate,
      	templateSelection: self.selectionTemplate,
      	minimumResultsForSearch: Infinity
      };
    },

    selectionTemplate: i.template,

    preSelection: function(byId, selector, extra){
      extra = extra || false;
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
        resp.item = resp.item || {}
        var id = resp.item.id || 0
        resp.item.id = 0;
        var output = self.selectionTemplate(resp.item);
        var option = new Option(self.selectionTemplate(resp.item), id, true, true);
  			if (selector == 'add') $(self.add).append(option).trigger('change');
  			if (selector == 'edit') $(self.edit).append(option).trigger('change');
      }).fail(function(err){
        if (err.status != 403) tgui_error.getStatus(err, ajaxProps);
        $(self.edit).prop('disabled', true);
      })
    },
  }
}
