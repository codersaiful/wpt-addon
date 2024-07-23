jQuery(function ($) {
    'use strict';
    $(document).ready(function () {
        
        $('.search_single.search_single_texonomy.search_single_product_cat').each(function(index, content){
            if(index == 0){
                $('#product_cat_wpt-addon-extra').removeClass('search_select');
                $(this).find('.search_select')
                .addClass('wpt-addon-parent-category')
                .removeClass('search_select');
            }
        });


        /**
         * Customize part for customer
         * Developed by Saiful <codersaiful@gmail.com> | CEO and Founder of CodeAstrology
         * Whatsapp +8801724025412
         * 
         * Message:
         * If available multiple sub category of your selected Category,
         * then table will load based on selected category also sub category also load
         * When set value true for [table_load_when_sub] 
         * if set false for [table_load_when_sub] then table will load only last box
         * 
         */
        var table_load_when_sub = true;

        var ajax_url = WPT_DATA.ajax_url;
        var site_url = WPT_DATA.site_url;
        
        $(document.body).on('change','.wpt-addon-parent-category',function(){

            var allSubCateBoxWrapper = $('.wpt-addon-extra-searchbox-wrapper.search_single');
            var subCateBoxWrapper = $('.wpt-addon-extra-searchbox-wrapper.wpt-addon-first.search_single');
            subCateBoxWrapper.css({opacity:'0.3'});


            var parent_cat_id = $(this).val();
            var parent_cat_name = $(this).find('option[value="'+parent_cat_id+'"]').text();
            
            var html = '<option value="' + parent_cat_id + '" selected="selected"></option>';
            var data = {
                action: 'ccd_wpt_addon_subcategory',
                parent_cat_id: parent_cat_id,
                parent_cat_name: parent_cat_name
            };
            $.ajax({
                type: 'POST',
                url: ajax_url,
                data: data,
                complete: function(){

                },
                success:function(response){
                    var result = response.html;
                    var status = response.status;   
                    console.log(status);
                    console.log(result);              
                    var allSubCateBox = $('.wpt-addon-extra-searchbox-wrapper.search_single_product_cat>select#product_cat_wpt-addon-extra');
                    var subCateBox = $('.wpt-addon-extra-searchbox-wrapper.wpt-addon-first.search_single_product_cat>select#product_cat_wpt-addon-extra');
                    var lastCateBox = $('.wpt-addon-extra-searchbox-wrapper.wpt-addon-last.search_single_product_cat>select#product_cat_wpt-addon-extra-last');
                    if(status === 'success'){
                        if( table_load_when_sub ){
                            lastCateBox.html(html); //Sub availale and load selected cat
                            lastCateBox.trigger('change'); //Sub availale and load selected cat
                        }
                        
                        subCateBoxWrapper.css({opacity:'1.0'});
                        subCateBox.html(result);
                        return;
                    }else if(status === 'no_subcategory'){
                        subCateBox.html('');
                        lastCateBox.html(html);
                        lastCateBox.trigger('change');
                        allSubCateBoxWrapper.css({opacity:'0.3'});
                        return;
                    }else if(status === 'error_founded'){
                        allSubCateBoxWrapper.css({opacity:'0.3'});
                        subCateBox.html('');
                        lastCateBox.html('');
                        lastCateBox.trigger('change');
                        return;
                    }
                    
                    
                },
                error: function() {
                    subCateBoxWrapper.css({opacity:'0.3'});
                    console.log("Error from CCD WPT Addon - made by Saiful (CodeAstrology) - codersaiful@gmail.com");
                },
            });
        });

        $(document.body).on('change','#product_cat_wpt-addon-extra',function(){
            
            var main_parent_id = $('.wpt-addon-parent-category').val();

            var subCateBoxWrapper = $('.wpt-addon-extra-searchbox-wrapper.wpt-addon-last.search_single');
            subCateBoxWrapper.css({opacity:'0.3'});

            var allSubCateBox = $('.wpt-addon-extra-searchbox-wrapper.search_single_product_cat>select#product_cat_wpt-addon-extra');  
            var lastCateBox = $('.wpt-addon-extra-searchbox-wrapper.wpt-addon-last.search_single_product_cat>select#product_cat_wpt-addon-extra-last');
                    


            var parent_cat_id = $(this).val();
            var parent_cat_name = $(this).find('option[value="'+parent_cat_id+'"]').text();
            var html = '<option value="' + parent_cat_id + '" selected="selected"></option>';
            console.log(parent_cat_id,main_parent_id);
            if(parent_cat_id == main_parent_id){
                lastCateBox.html(html); //Sub availale and load selected cat
                    lastCateBox.trigger('change'); //Sub availale and load selected cat
                if(table_load_when_sub){
                    
                    subCateBoxWrapper.css({opacity:'0.3'}); //Sub availale and load selected cat
                }
                
                return;
            }

            var data = {
                action: 'ccd_wpt_addon_subcategory',
                parent_cat_id: parent_cat_id,
                parent_cat_name: parent_cat_name
            };
            $.ajax({
                type: 'POST',
                url: ajax_url,
                data: data,
                complete: function(){

                },
                success:function(response){
                    var result = response.html;
                    var status = response.status; 
                    if(status === 'success'){
                        subCateBoxWrapper.css({opacity:'1.0'});
                        lastCateBox.html(result);
                        if(table_load_when_sub){
                            lastCateBox.trigger('change'); //Sub Cate available and load main cat
                        }
                    }else if(status == 'no_subcategory'){
                        lastCateBox.html(html);
                        lastCateBox.trigger('change');
                        subCateBoxWrapper.css({opacity:'0.3'});
                        return;
                    }else if(status == 'error_founded'){
                        subCateBoxWrapper.css({opacity:'0.3'});
                        lastCateBox.html('');
                        lastCateBox.trigger('change');
                        
                    }
                    
                    
                },
                error: function() {
                    subCateBoxWrapper.css({opacity:'0.3'});
                    console.log("Error from CCD WPT Addon - made by Saiful (CodeAstrology) - codersaiful@gmail.com");
                },
            });
        });

    });
});