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

            //Again set Choose Option as by default
            $(this).val('');
            //If myText null, then run following. otherwise, it will return null at upper block
            const popupWrapper = $('.wpt-custom-popup-area-wrapper');
            const popupContentArea = popupWrapper.find('.wpt-custom-popup-content-area');
            if(popupWrapper.length < 1){
                console.log('Popup not founded');
            }

            popupWrapper.fadeIn();

            const Row = $(this).closest('tr.wpt-row');
            let table_id = Row.data('temp_number');
            let product_id = Row.data('product_id');
            let product_title = Row.data('title');

            //Setup content All Here
            popupWrapper.find('.wpt-custom-popup-insider>h2').html(product_title);

            let contentHtml = "";
            contentHtml += "<div class='wpt-custom-popup-items'>"; //Main Area

            contentHtml += getEachPopupQtyItem();

            contentHtml += "<div>"; //.wpt-custom-popup-items

            popupContentArea.html(contentHtml);
            
        });

        $(document.body).on('click','p.wpt-stats-post-count',function(){
            // alert(33333);
        });




        $(document.body).on('click','.wpt-custom-at-close',function(){
            const mainWrapper = $(this).closest('.wpt-custom-popup-area-wrapper');
            mainWrapper.fadeOut();
            mainWrapper.find('.wpt-custom-popup-content-area').html("");
            mainWrapper.find('.wpt-custom-popup-insider>h2').html("");
        });

        function getEachPopupQtyItem(){
            var contentHtml = '';
            contentHtml += "<div class='wpt-custom-pop-item'>";

            contentHtml += "<div class='wpt-pop-qty'>";
            contentHtml += "<input type='number' stpe='any' placeholder='Qty'>";
            contentHtml += "PCS";
            contentHtml += "</div>";


            contentHtml += "<div class='wpt-pop-size-all'>";
            contentHtml += "<input type='number' stpe='any' placeholder='Feet' class='wpt-cus-pop-ft'>";
            contentHtml += " ft ";
            
            contentHtml += "<input type='number' stpe='any' placeholder='Inches'  class='wpt-cus-pop-inc'>";
            contentHtml += " and ";
            contentHtml += '<select class="wpt-cus-pop-inc-select" style="width: 55px;"> <option value="0">--</option> <option value="0.125">1/8</option> <option value="0.25">1/4</option> <option value="0.375">3/8</option> <option value="0.5">1/2</option> <option value="0.625">5/8</option> <option value="0.75">3/4</option> <option value="0.875">7/8</option> </select>';
            contentHtml += "in.";
            contentHtml += "</div>"; //.wpt-pop-size-all



            contentHtml += "</div>"; //.wpt-custom-pop-item

            return contentHtml;
        }
        function addingPopupWrapper(){
            const sizeColCount = $('select.wpt-extra-size-column').length;
            console.log(sizeColCount);
            if(sizeColCount > 0){
                $('body').append('<div class="wpt-custom-popup-area-wrapper"><div class="wpt-custom-popup-insider"><span class="wpt-custom-at-close">x</span><h2></h2><div class="wpt-custom-popup-content-area"></div></div></div>');
            }
        }
    });
});

/**
.wpt-custom-popup-area-wrapper{}
.wpt-custom-popup-insider{}
.wpt-custom-popup-content-area{}
 */