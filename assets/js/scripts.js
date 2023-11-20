jQuery(function ($) {
    'use strict';
    $(document).ready(function () {

        //Adding popup area
        addingPopupWrapper();

        $(document.body).on('change','.wpt-extra-size-column',function(){
            var myText = $(this).val();
            console.log(myText,typeof myText);
            if(myText == '0'){
                // myText = '';
            }
            if(myText !== '' && myText !== '0'){
                $(this).closest('tr').attr('additional_json', myText);
                return;
            }

            if(myText !== '0'){
                return;
            }

            //Again set Choose Option as by default
            
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

            popupContentArea.attr('table_id', table_id);
            popupContentArea.attr('product_id', product_id);
            popupContentArea.attr('product_title', product_title);

            //Setup content All Here
            popupWrapper.find('.wpt-custom-popup-insider>h2').html(product_title);

            let contentHtml = "";
            contentHtml += getPopupQtyFirstLoadAllItem();
            contentHtml += '<div class="wpt-items-bottom"><span class="wpt-popup-add-line button">Add Line</span></div>';
            contentHtml += '<div class="wpt-popup-footer"><span class="wpt-popup-add-to-cart button">Add to Cart</span><span class="wpt-popup-close button">Close</span></div>';
            popupContentArea.html(contentHtml);
            
        });

        $(document.body).on('click','span.wpt-popup-add-line',function(){
            const contentWrapper = $(this).closest('.wpt-custom-popup-content-area');
            const itemsWrapper = contentWrapper.find('.wpt-custom-popup-items');
            let newItem = getEachPopupQtyItem();
            itemsWrapper.append(newItem);
        });




        $(document.body).on('click','.wpt-pop-each-item-close',function(){
            // $(this).closest('.wpt-custom-pop-item').fadeOut();
            $(this).closest('.wpt-custom-pop-item').remove();
        });
        $(document.body).on('click','.wpt-custom-at-close,.wpt-popup-close',function(){
            const mainWrapper = $(this).closest('.wpt-custom-popup-area-wrapper');
            mainWrapper.fadeOut();
            mainWrapper.find('.wpt-custom-popup-content-area').html("");
            mainWrapper.find('.wpt-custom-popup-insider>h2').html("");


            $('.wpt-extra-size-column').val('');
        });

        function getPopupQtyFirstLoadAllItem(){
            var contentHtml = '';
            contentHtml += "<div class='wpt-custom-popup-items'>"; //Main Area

            contentHtml += getEachPopupQtyItem();
            contentHtml += getEachPopupQtyItem();

            contentHtml += "</div>"; //.wpt-custom-popup-items
            return contentHtml;
        }
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

            contentHtml += "<span class='wpt-pop-each-item-close'>x</span>";

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