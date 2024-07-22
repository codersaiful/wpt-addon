jQuery(function ($) {
    'use strict';
    $(document).ready(function () {
        
        $('.search_single.search_single_texonomy.search_single_product_cat').each(function(index, content){
            if(index == 0){
                $(this).find('.search_select')
                .addClass('wpt-addon-parent-category')
                .removeClass('search_select');
            }
        });


        var ajax_url = WPT_DATA.ajax_url;
        var site_url = WPT_DATA.site_url;
        
        $(document.body).on('change','.wpt-addon-parent-category',function(){
            $('select#wpt-addon-temp-select').remove();
            
            var thisSelect = $(this);

            var parent_cat_id = $(this).val();
            var html = '<select data-key="product_cat" name="product_cat" id="wpt-addon-temp-select" class="search_select query search_select_product_cat"><option value="' + parent_cat_id + '" selected="selected">Hello</option></select>';
            var data = {
                action: 'ccd_wpt_addon_subcategory',
                parent_cat_id: parent_cat_id,
            };
            $.ajax({
                type: 'POST',
                url: ajax_url,
                data: data,
                complete: function(){

                },
                success:function(result){
                    var subCateBox = $('.wpt-addon-extra-searchbox-wrapper.search_single_product_cat>select#product_cat_wpt-addon-extra');
                    console.log(result);
                    if(result == 'no_subcategory'){
                        thisSelect.after(html);
                        subCateBox.html('');
                        setTimeout(function(){
                            $('button.button.wpt-search-products').trigger('click');
                        }, 2000);
                        return;
                    }else{
                        subCateBox.html(result);
                    }
                    
                    
                },
                error: function() {
                    console.log("Error On Ajax Query Load. Please check console.");
                },
            });
        });

    });
});