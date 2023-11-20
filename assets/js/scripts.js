jQuery(function ($) {
    'use strict';
    $(document).ready(function () {

        //Adding popup area
        addingPopupWrapper();

        $(document.body).on('change','.wpt-extra-size-column',function(){
            var myText = $(this).val();
            if(myText == '0'){
                myText = '';
            }
            if(myText !== ''){
                $(this).closest('tr').attr('additional_json', myText);
                return;
            }

            //If myText null, then run following. otherwise, it will return null at upper block

            
        });

        $(document.body).on('click','p.wpt-stats-post-count',function(){
            // alert(33333);
        });



        function addingPopupWrapper(){
            const sizeColCount = $('select.wpt-extra-size-column').length;
            console.log(sizeColCount);
            if(sizeColCount > 0){
                $('body').append('<div class="wpt-custom-popup-area-wrapper"><div class="wpt-custom-popup-insider"><div class="wpt-custom-popup-content-area">HHHHHHHHHHH</div></div></div>');
            }
        }
    });
});

/**
.wpt-custom-popup-area-wrapper{}
.wpt-custom-popup-insider{}
.wpt-custom-popup-content-area{}
 */