jQuery(function(){
    var grid = {
            
        mOver : function(){
            $(this).addClass('grid-row-hover');
        },
        
        mOut : function(){
            $(this).removeClass('grid-row-hover');
        },
        
        mDown : function(){
            $(this).addClass('ui-state-active');
        },
        
        mUp : function(){
            $(this).removeClass('ui-state-active');
        },
        
        checkAll : function(){
            if ( $(this).is(':checked') ){
                $('.grid').find('input[type=checkbox]').attr('checked', 'checked');
            } else {
                $('.grid').find('input[type=checkbox]').removeAttr('checked');
            }
        },
        
        selectRow : function(){
            if ( ! $(this).find('input[type=checkbox]:first').is(':checked') ){
                $(this).find('input[type=checkbox]:first').attr('checked', 'checked');
                $(this).addClass('grid-row-selected');
            } else {
                $(this).find('input[type=checkbox]:first').removeAttr('checked');
                $(this).removeClass('grid-row-selected');
            }
        }
            
    };
   
    
    $('.grid').find('thead td').not('.grid-check').hover(grid.mOver, grid.mOut).mousedown(grid.mDown).mouseup(grid.mUp);
    $('.grid').find('tbody tr').hover(grid.mOver, grid.mOut)
    $('.grid').find('.check-all').change(grid.checkAll);
   // $('.grid').find('tbody').delegate('tr', 'click', grid.selectRow);
    //$('.grid').fixedTable();
});