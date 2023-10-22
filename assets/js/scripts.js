jQuery(function ($) {
    'use strict';
    $(document).ready(function () {
		
        // He design variation product page with a page builder and selector is different
        // So we need to Load mini-filter for variation product with correct selector

        $(document.body).on('change','.wpt-mini-filter select',function(){
            var key = $(this).data('key');
            loadVariableMiniFilter(key);
        });

        loadVariableMiniFilter(false);
        function loadVariableMiniFilter(clicked_on_fiter){
            $('.wpt-mini-filter select').each(function(){
                var selected = '';
                var thisSelect = $(this);
                var currentValue = thisSelect.val();
                var key = $(this).data('key');
				var customizedKey = key.replace(/[^A-Z0-9]+/ig, "_");
                var label = $(this).data('label');
                var Arr = {};
                var targetRowClass = 'tr.wpt-row.visible_row';
                if(clicked_on_fiter){
                    targetRowClass = 'tr.wpt-row.visible_row';
                    if(clicked_on_fiter == key) return;
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
                console.log(Arr);
                Object.keys(Arr).forEach(function(item) {
                    var realKey = item.replace(/[^A-Z0-9]+/ig, "_");
                    realKey = customizedKey + '_' + realKey;
                    if(currentValue == realKey){
                        selected = 'selected';
                    }
                    
                    thisSelect.append('<option value="' + realKey + '" ' + selected + '>' + item + '</option>');
                });
                
            });
            setTimeout(function(){
                if(typeof $('select.filter_select.filter').select2 !== 'function') return;
                //$('select.filter_select.filter').select2();
            },500); 
        }

        // for message box
        $(document.body).on('keyup','input.specify_size',function(){
            var text = $(this).val();
            $(this).closest('tr').attr('additional_json', text);
        });

        $(document.body).on('keyup','input.option',function(){
            var text = $(this).val();
            $(this).closest('tr').attr('additional_json', text);
        });

    });
});