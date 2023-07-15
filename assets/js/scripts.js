jQuery(function ($) {
    'use strict';
    $(document).ready(function () {
        console.log(WPT_ADDON_DATA_ORDERBY);

        
        $(document.body).on('click','.test-my-button',function(){
            $('.target-order_by_text').each(function(){
                var table_id = $(this).data('table_id');
                var settings = $(this).data('settings');
                
                var table_body_selector = '#table_id_' + table_id + ' table>tbody';
                var tableObject = $(table_body_selector);
                var html = '';
                // console.log(typeof settings);
                $(settings).each(function(index,text){
                    var startText = text.toLowerCase();
                    // console.log(startText);
                    tableObject.find('tr').each(function(){
                        var thisRowObject = $(this);
                        var title = $(this).find('.wpt_product_title a').text().trim().toLowerCase();
                        if(title.startsWith(startText)){
                            html += thisRowObject.prop('outerHTML');
                        }
                    });
                });
                tableObject.html(html);
                
    
            });
        });

        $(".my-button").click(function() {
            var sortBy = ['saiful', 'test', 'aaa']; // Sorting base array

            // Get all the table rows except the first one (header)
            var rows = $(".my-table tr");

            // Sort the rows
            rows.sort(function(a, b) {
                var titleA = $(a).find(".product-title").text().trim().toLowerCase();
                var titleB = $(b).find(".product-title").text().trim().toLowerCase();

                var indexA = sortBy.indexOf(titleA);
                var indexB = sortBy.indexOf(titleB);

                if (indexA !== -1 && indexB !== -1) {
                    return indexA - indexB; // Sort based on array index
                } else if (indexA !== -1 && indexB === -1) {
                    return -1; // 'titleA' comes before 'titleB'
                } else if (indexA === -1 && indexB !== -1) {
                    return 1; // 'titleB' comes before 'titleA'
                } else {
                    return titleA.localeCompare(titleB); // Sort alphabetically
                }
            });

            // Append the sorted rows back to the table
            $(".my-table").append(rows);
        });
    });
});