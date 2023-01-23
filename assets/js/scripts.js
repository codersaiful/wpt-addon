jQuery(function ($) {
    'use strict';
    $(document).ready(function () {

        function updateCheckboxOnQtyUpdate(){
            var boxValue = $(this).val();
            boxValue = parseInt(boxValue);
            var checboxObj = $(this).closest('tr.wpt_row').find("input.wpt_tabel_checkbox.wpt_td_checkbox");
            if( boxValue > 0 ){
                checboxObj.prop( "checked", true );
            }else{
                checboxObj.prop( "checked", false );
            }
        }
        $(document.body).on('change','input.input-text.qty',updateCheckboxOnQtyUpdate);
        $(document.body).on('keyup','input.input-text.qty',updateCheckboxOnQtyUpdate); 
        
    });
});