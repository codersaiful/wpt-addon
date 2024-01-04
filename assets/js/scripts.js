jQuery(function ($) {
    'use strict';
    $(document).ready(function () {
		
		
		/****************************************** Write a Slash at end this line If you change Table Location of Variable Product *****************






        // He design variation product page with a page builder and selector is different
        // So we need to Load mini-filter for variation product with correct selector

        var miniFilterSelector = '.product-type-variable .wpt-mini-filter select';

        $(document.body).on('change',miniFilterSelector,function(){
            var key = $(this).data('key');
            loadVariableMiniFilter(key);
        });

        $(document.body).on('click','span.sku_wrapper',function(){
            const currentURL = window.location.href;
            window.history.pushState(currentURL, "Title", currentURL + "/new-url");
        });

        $(document.body).on('click','#wpt-variable-page-submit-button',function(){
            var TableTagWrap = $('.normal_table_wrapper');
            TableTagWrap.addClass('wpt-ajax-loading');
            TableTagWrap.addClass('wpt-variation-table-loader');
            const currentURL = window.location.href;
            window.location.href = currentURL;
        });


        loadVariableMiniFilter(false);
        //******************************************/
        function loadVariableMiniFilter(clicked_on_fiter){
            
            const currentURL = window.location.href;
            var variable_table_pagi = $('div.normal_table_wrapper').hasClass('wpt-variatin-table-all-variation');
            
            var paginatedMiniFilter = $('.wpt-variable-product-options').length;
            


            //When Available Pagination and GET on Variation table.
            if( variable_table_pagi ){
                $('body').addClass('wpt-variable-page-body');
                if(clicked_on_fiter){
                    var curentFilHref = '';
                    $(miniFilterSelector).each(function(){
                        var thisSelect = $(this);
                        var eachVal = thisSelect.val();
                        var key = $(this).data('key');
                        if(eachVal !== '' ){
                            curentFilHref += key + "=" + eachVal + "&";
                        }

                        
                    });
                    
                    var finalUrl = getMainUrl(currentURL) + "?" + curentFilHref;
                    window.history.pushState(currentURL, "Reloading...", finalUrl);
                    $('#wpt-variable-page-submit-button').remove();
                    $('.wpt-mini-filter').append('<button class="button wpt-variable-page-submit-button" id="wpt-variable-page-submit-button"><span>Submit</span></button>');

                    return;    
                }
                $(miniFilterSelector).each(function(){

                    var selected = '';
                    var thisSelect = $(this);
                    var currentValue = thisSelect.val();
                    if(currentValue !== '' && $(this).hasClass('filter_select_' + clicked_on_fiter)){
                        return;
                    }
                    var key = $(this).data('key');
                    var customizedKey = key.replace(/[^A-Z0-9]+/ig, "_");
                    var label = $(this).data('label');
                    var Arr = {};
                    var targetRowClass = 'tr.wpt-row.visible_row';
                    if(clicked_on_fiter){
                        targetRowClass = 'tr.wpt-row.visible_row';
                        // if(clicked_on_fiter == key) return;
                        thisSelect = $(this).html('<option value="">' + label + '</option>');
                    }
    
                    //New data come here
                    var variable_options = $('.wpt-variable-product-options').data('variable_options');
                    Arr = variable_options[key];
                    console.log(Arr);
                    Object.keys(Arr).forEach(function(item) {
                        
                        var realKey = item.replace(/[^A-Z0-9]+/ig, "_");
                        
                        realKey = customizedKey + '_' + realKey;
                        if(currentValue == realKey){
                            selected = 'selected';
                        }
                        
                        thisSelect.append('<option value="' + item + '" ' + selected + '>' + item + '</option>');
                    });
                    
                });

                
                var urlParams = getUrlParams(currentURL);
                Object.keys(urlParams).forEach(function(itemKey) {
                    $(miniFilterSelector+"[data-key='" + itemKey + "']").val(urlParams[itemKey]);
                });

            }else{
                $(miniFilterSelector).each(function(){
                    var selected = '';
                    var thisSelect = $(this);
                    var currentValue = thisSelect.val();
                    if(currentValue !== '' && $(this).hasClass('filter_select_' + clicked_on_fiter)){
                        return;
                    }
                    var key = $(this).data('key');
                    var customizedKey = key.replace(/[^A-Z0-9]+/ig, "_");
                    var label = $(this).data('label');
                    var Arr = {};
                    var targetRowClass = 'tr.wpt-row.visible_row';
                    if(clicked_on_fiter){
                        targetRowClass = 'tr.wpt-row.visible_row';
                        // if(clicked_on_fiter == key) return;
                        thisSelect = $(this).html('<option value="">' + label + '</option>');
                    }
                    var selectorKey = key.replace(' ', ".");
                    var elSelector = targetRowClass + ' .wpt_' + selectorKey + '>div';
                    $(elSelector).each(function(){
                        var valkey = $(this).text();
                        valkey = $.trim(valkey);
                        var newvalkey = valkey.replace(/[^A-Z0-9]+/ig, "_");
                        newvalkey = customizedKey + '_' + newvalkey;
                        if(valkey == '' || valkey == ' ') return;
                        Arr[valkey]=valkey;
                        $(this).closest('tr.wpt-row').addClass(newvalkey).addClass('filter_row');
                    });
                    Object.keys(Arr).forEach(function(item) {
                        var realKey = item.replace(/[^A-Z0-9]+/ig, "_");
                        realKey = customizedKey + '_' + realKey;
                        if(currentValue == realKey){
                            selected = 'selected';
                        }
                        
                        thisSelect.append('<option value="' + realKey + '" ' + selected + '>' + item + '</option>');
                    });
                    
                });
            }
            


            /**
             * This is for 'Advance Cascade Filter' 
             * If cascade filter is on then all data is load which is not the perpose of mini filter
             * this fumction will load only visible product data
             */
            setTimeout(function(){
                if(typeof $('select.filter_select.filter').select2 !== 'function') return;

                //REset button Hide for paginated mini filter
                if( paginatedMiniFilter > 0 ){
                    $('a.wpt_filter_reset').remove();
                }

                // Turn of this for now. We have to fix it 
                // $('select.filter_select.filter').select2();
            },500); 
        }
        
        function getMainUrl(url){
            const mainUrl = url.split('?')[0];
            
            return mainUrl;
        }

        function getUrlParams(url) {
            // Get the query string part of the URL
            const queryString = url.split('?')[1];
            
            if (!queryString) {
                // Return an empty object if there are no query parameters
                return {};
            }
        
            // Split the query string into an array of key-value pairs
            const paramsArray = queryString.split('&');
        
            // Initialize an empty object to store the parameters
            const paramsObject = {};
        
            // Loop through the array and populate the object
            paramsArray.forEach(param => {
                const [key, value] = param.split('=');
                // DecodeURIComponent to handle special characters in values
                paramsObject[key] = decodeURIComponent(value);
            });
        
            return paramsObject;
        }

        // for message box
        $(document.body).on('keyup','input.specify_size',function(){
            var text = $(this).val();
            var myjson = {
                specifySize: text,
                option: ""
            };

            var curJsonString = $(this).closest('tr').attr('additional_json');
            if(curJsonString == ''){
                $(this).closest('tr').attr('additional_json', JSON.stringify(myjson));
                return;
            }else{
                myjson = JSON.parse(curJsonString);
                myjson.specifySize = text;
            }
            
            $(this).closest('tr').attr('additional_json', JSON.stringify(myjson));
        });

        $(document.body).on('keyup','input.option',function(){
            var text = $(this).val();
            var myjson = {
                specifySize: '',
                option: text
            };

            var curJsonString = $(this).closest('tr').attr('additional_json');
            if(curJsonString == ''){
                $(this).closest('tr').attr('additional_json', JSON.stringify(myjson));
                return;
            }else{
                myjson = JSON.parse(curJsonString);
                myjson.option = text;
            }
            
            $(this).closest('tr').attr('additional_json', JSON.stringify(myjson));
        });

    });
});