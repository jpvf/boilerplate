new function($){$.fn.placeholder=function(settings){settings=settings||{};var key=settings.dataKey||"placeholderValue";var attr=settings.attr||"placeholder";var className=settings.className||"placeholder";var values=settings.values||[];var block=settings.blockSubmit||false;var blank=settings.blankSubmit||false;var submit=settings.onSubmit||false;var value=settings.value||"";var position=settings.cursor_position||0;return this.filter(":input").each(function(index){$.data(this,key,values[index]||$(this).attr(attr));}).each(function(){if($.trim($(this).val())==="")
$(this).addClass(className).val($.data(this,key));}).focus(function(){if($.trim($(this).val())===$.data(this,key))
$(this).removeClass(className).val(value)
if($.fn.setCursorPosition){$(this).setCursorPosition(position);}}).blur(function(){if($.trim($(this).val())===value)
$(this).addClass(className).val($.data(this,key));}).each(function(index,elem){if(block)
new function(e){$(e.form).submit(function(){return $.trim($(e).val())!=$.data(e,key)});}(elem);else if(blank)
new function(e){$(e.form).submit(function(){if($.trim($(e).val())==$.data(e,key))
$(e).removeClass(className).val("");return true;});}(elem);else if(submit)
new function(e){$(e.form).submit(submit);}(elem);});};}(jQuery);