jQuery(function ($) {
    'use strict';
    $(document).ready(function () {
        console.log(WPT_ADDON_DATA_ORDERBY);

        $('.target-order_by_text').each(function(){
            var table_id = $(this).data('table_id');
            var settings = $(this).data('settings');

            console.log(settings, table_id);

        });

        $(".my-button").click(function() {
            var sortBy = ['saiful', 'test', 'aaa']; // Sorting base array

            // Get all the table rows except the first one (header)
            var rows = $(".my-table tr:not(:first)");

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