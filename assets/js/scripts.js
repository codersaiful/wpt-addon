jQuery(function ($) {
    'use strict';
    $(document).ready(function () {
        $(document.body).on('change','.wpt-extra-size-column',function(){
            var myText = $(this).val();
            if(myText == '0'){
                myText = '';
            }
            $(this).closest('tr').attr('additional_json', myText);
        });

        $(document.body).on('click','p.wpt-stats-post-count',function(){
            // alert(33333);
        });
    });
});