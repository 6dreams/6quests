admin = {
    prev: null,
    /**
     * @source https://www.w3schools.com/howto/howto_js_sort_table.asp
     * @param table
     * @param index
     */
    sort: function(table, index) {
        var rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = $.id(table);
        switching = true;
        dir = 0;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName('TR');
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName('TD')[index];
                y = rows[i + 1].getElementsByTagName('TD')[index];
                if (dir === 0) {
                    if (x.dataset.value > y.dataset.value) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir === 1) {
                    if (x.dataset.value < y.dataset.value) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;
            } else {
                if (switchcount === 0 && dir === 0) {
                    dir = 1;
                    switching = true;
                }
            }
        }
    },

    toggle: function(i) {
        if (admin.prev !== null && i !== admin.prev) {
            $.addClass($.id('ai' + admin.prev), 'dn');
        }
        var e = $.id('ai' + i);
        if ($.hasClass(e, 'dn')) {
            $.removeClass(e, 'dn');
        } else {
            $.addClass(e, 'dn');
        }
    }
};