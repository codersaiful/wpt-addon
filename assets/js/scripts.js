jQuery(function ($) {
    'use strict';
    $(document).ready(function () {

        $(document.body).on('change','input.message_2',function(){
            var text = $(this).val();
            $(this).closest('tr').attr('additional_json', text);
        });
        
    });
});