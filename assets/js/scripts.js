jQuery(function ($) {
    'use strict';
    $(document).ready(function () {
        var checkout_text = "Checkout Now";
        var successfull_added_msg = "Successfully Added Items!";


        var plugin_url = WPT_DATA.plugin_url;
        var include_url = WPT_DATA.include_url;
        var content_url = WPT_DATA.content_url;
        
        var ajax_url = WPT_DATA.ajax_url;
        var site_url = WPT_DATA.site_url;
        var checkout_url = WPT_DATA.checkout_url;
        console.log(WPT_DATA);
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
            let product_description = Row.find('.product_description').text();

            popupContentArea.attr('table_id', table_id);
            popupContentArea.attr('product_id', product_id);
            popupContentArea.attr('product_title', product_title);

            //Setup content All Here
            popupWrapper.find('.wpt-custom-popup-insider>h2').html(product_title + '<span>' + product_description + '</span>');

            let contentHtml = "";
            contentHtml += getPopupQtyFirstLoadAllItem();
            contentHtml += '<div class="wpt-items-bottom"><span class="wpt-popup-add-line button">Add Line</span></div>';
            // contentHtml += '<div class="wpt-items-message"></div>';
            contentHtml += '<div class="wpt-popup-footer"><span class="wpt-popup-add-to-cart button">Add to Cart</span><span class="wpt-popup-close button">Close</span></div>';
            popupContentArea.html(contentHtml);
            
        });

        $(document.body).on('click','span.wpt-popup-add-line',function(){
            const contentWrapper = $(this).closest('.wpt-custom-popup-content-area');
            const itemsWrapper = contentWrapper.find('.wpt-custom-popup-items');
            let newItem = getEachPopupQtyItem();
            itemsWrapper.append(newItem);
        });



        $(document.body).on('click','.wpt-popup-add-to-cart',function(){
            
            const popupWrapper = $('.wpt-custom-popup-area-wrapper');
            const popupContentArea = popupWrapper.find('.wpt-custom-popup-content-area');
            const itemsAreaWrapper = popupContentArea.find('.wpt-custom-popup-items');

            let table_id = popupContentArea.attr('table_id');
            let product_id = popupContentArea.attr('product_id');
            let product_title = popupContentArea.attr('product_title');
            let error = 0;
            let products_data = new Array();
            itemsAreaWrapper.find('.wpt-custom-pop-item').each(function(index){
                var quantity = $(this).find('.wpt-pop-qty input').val();
                var feet = $(this).find('.wpt-pop-size-all .wpt-cus-pop-ft').val();
                var inches = $(this).find('.wpt-pop-size-all .wpt-cus-pop-inc').val();
                var inches_fact = $(this).find('.wpt-pop-size-all select').val();
                if(quantity == '' || feet == '' || inches == ''){
                    $(this).addClass('error-in-qty-line');
                    error++;
                    return true;
                }else{
                    $(this).removeClass('error-in-qty-line');
                }
                var additional_json = feet + " ft " + inches + " and " + inches_fact + "in.";
                index++;
                // console.log(index);
                products_data[index] = {
                    product_id: product_id,
                    quantity:   quantity,
                    additional_json: additional_json,
                };

                



            });

            if(error > 0){
                alert("Fixed row first");
                return;
            }else{
                var addToCartButton = $('span.wpt-popup-add-to-cart.button');
                addToCartButton.html("Adding...");
                $.ajax({
                    type: 'POST',
                    url: ajax_url,
                    data: {
                        action: 'wpt_ajax_mulitple_add_to_cart',
                        products: products_data,
                    },
                    complete: function(){
                        $( document ).trigger( 'wc_fragments_refreshed' );
    
                        //It's need to update checkout page Since 3.3.3.1
                        $( document.body ).trigger( 'update_checkout' );
                        addToCartButton.hide();
                        addToCartButton.after("<a href='" + checkout_url + "' class='button wpt-custom-popup-checkout-btn' target='_blank'>" + checkout_text + "</a>");
                        

                        addToCartButton.before('<div class="wpt-items-message">' + successfull_added_msg + '</div>');
                        addToCartButton.remove();
                    },
                    success: function( response ) {
                        console.log(response);
                        $( document.body ).trigger( 'updated_cart_totals' );
                        $( document.body ).trigger( 'wc_fragments_refreshed' );
                        $( document.body ).trigger( 'wc_fragments_refresh' );
                        $( document.body ).trigger( 'wc_fragment_refresh' );
                        
                    },
                    error: function() {
                        addToCartButton.html("Failed to add");
                    },
                });


            }
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
            contentHtml += "<input type='number' placeholder='Qty'>";
            contentHtml += "PCS";
            contentHtml += "</div>";


            contentHtml += "<div class='wpt-pop-size-all'>";
            contentHtml += "<input type='number' placeholder='Feet' class='wpt-cus-pop-ft'>";
            contentHtml += " ft ";
            
            contentHtml += "<input type='number' placeholder='Inches'  class='wpt-cus-pop-inc'>";
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