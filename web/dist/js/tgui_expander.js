var tgui_expander = {
  init: function() {
    var self = this;
    $('div.tgui_expander div.header').click(function(e){ self.mainEvent(e.target); })
  },
  mainEvent: function(target){
    var tgui_expander = $(target).closest( "div.tgui_expander" );
    var body = $(tgui_expander).find( "div.body" );
    var header = $(tgui_expander).find( "div.header" );
    var icon = $(header).find( "i.fa" );
    if ( $(tgui_expander).hasClass('open') ){
      $(tgui_expander).removeClass('open')
      $(icon).removeClass('fa-minus-square').addClass('fa-plus-square');
      $(body).hide();
    } else {
      $(tgui_expander).addClass('open')
      $(icon).removeClass('fa-plus-square').addClass('fa-minus-square');
      $(body).show();
    }
  }
}
