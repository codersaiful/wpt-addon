jQuery(function ($) {
    'use strict';
    $(document).ready(function () {

        function arrangeTable(){
            $('.target-order_by_text').each(function(){
                var table_id = $(this).data('table_id');
                var settings = $(this).data('settings');
                if(settings.length < 1) return;

                
                var table_body_selector = '#table_id_' + table_id + ' table>tbody';
                var tableObject = $(table_body_selector);
                var html = '';
                // console.log(typeof settings);
                $(settings).each(function(index,text){
                    var startText = text.toLowerCase();
                    // console.log(startText);
                    tableObject.find('tr').each(function(){
                        var thisRowObject = $(this);
                        var title = $(this).find('.wpt_custom_order a').text().trim().toLowerCase();
                        if(title.startsWith(startText)){
                            html += thisRowObject.prop('outerHTML');
                            thisRowObject.remove();
                        }
                    });
                });
                tableObject.find('tr').each(function(){
                    var thisRowObject = $(this);
                    html += thisRowObject.prop('outerHTML');
                });
                tableObject.html(html);
                
    
            });
        }
        setTimeout(arrangeTable,500);

    });
});