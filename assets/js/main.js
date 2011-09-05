jQuery(function($){ 
  //Este es un link en los mensajes pequeños del sistema, simplemente los oculta.
  $('.close').live('click',function(e){
    e.preventDefault();
    $(this).closest('#messages-layer').fadeOut(500);  
  });    

  //Date Picker Generico, usable en cualquier elemento.
  $(".input-date-picker").datepicker({ 
    dateFormat: 'yy-mm-dd',
    showAnim: 'fadeIn', 
    prevText: '<b><</b>',
    nextText: '<b>></b>'    
  });
  
  //Otro datepicker generico pero permite cambiar meses y años.
  $(".date-picker").datepicker({ 
    dateFormat: 'yy-mm-dd',
    showAnim: 'fadeIn', 
    prevText: '<b><</b>',
    nextText: '<b>></b>',
    yearRange: 'c:c+10',
    changeMonth: true,
    changeYear: true
  });
  
  
  $('#ui-datepicker-div').removeClass('ui-helper-hidden-accessible');
  $('.button').button();
    
  var message = $('.message');
  if(message.length){
    if(!message.hasClass('sticky')){
        $('.message').delay('5000').fadeOut('500');  
    }
  }
 

});//end of jquery dom ready function

/* InicializaciÃ³n en espaÃ±ol para la extensiÃ³n 'UI date picker' para jQuery. */
/* Traducido por Vester (xvester@gmail.com). */
jQuery(function($){
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '&#x3c;Ant',
        nextText: 'Sig&#x3e;',
        currentText: 'Hoy',
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
        'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
        'Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['es']);
});

window.log = function(){
    log.history = log.history || [];   // store logs to an array for reference
    log.history.push(arguments);
    if(this.console){
      console.log( Array.prototype.slice.call(arguments) );
    }
  };
  
// Crear Mensajes

var message = function($){
  
  return {
    
    show : function(type, text) {  
      var message = "<div class='message " + type + "'>";
      message += "<p>" + text + "</p>";
      message += "<span class='close' id='hide' title='Cerrar'><span class='ui-icon ui-icon-close'></span></span>";
      message += "</div>";
      $('#messages-layer').prepend(message);   
      $('.message').delay('5000').fadeOut('500', function(){
        $(this).remove();
      });  
    }
  };
  
}(jQuery);

//Lenguaje

var lang = function($){
  
  var _lang_default_error = 'Error',
      _lang_lines  = [],
      _message = '';
  
  return {
    
    set : function(items) {
      
      if (typeof items != 'object') {
        return false;
      }
      _lang_lines = $.extend({}, _lang_lines, items); 
    },
    
    line : function(item) {  
      
      if (_lang_lines[item] === undefined )
      {
        return _lang_default_error;
      }
        
      return _lang_lines[item];
    }
  };
  
}(jQuery);



var ajax = ( function( $ ) {
    return (
      function( params ) {
        var settings = $.extend({
          url: '/',
          spinner:  ".loading", 
          dataType: "json",
          type:     "post",
          cache:    false,
          success:  function(){},
          errorMsg: 'Ha ocurrido un error',
          async:    true
        }, params),
          retries = 0;
       function ajaxRequest ( ) {
   
          $.ajax({
            async: settings.async,
            beforeSend: function() { 
              $( settings.spinner ).show();
            },
            url: '/pmt/pmt.phtml/' + settings.url,
            type: settings.type,
            data: settings.data,
            dataType: settings.dataType,
            success: settings.success,                 
            complete: function() {
              $( settings.spinner ).hide();
            },
            error: function( xhr, tStatus, err ) {
                $( settings.spinner ).hide();
              if( xhr.status === 401 || xhr.status === 403 ) {
                //redirect action here
              } else if ( xhr.status === 504 && !retries++ ) {
                //make our recursive request
                ajaxRequest();
              } else {
                message.show('error', 'Error de ajax: ' + err);
              }
            } // end error handler
          }); // end $.ajax()
        }; // end ajaxRequest() 
        
        ajaxRequest();
          
      } // end getViaAjax()
    ); // end return statement
  })(jQuery);

