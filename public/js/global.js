$ = {
    id: function(i){
        return document.getElementById(i)
    },
    class: function(c) {
        return document.getElementsByClassName(c)
    },
    request: function (u, d, c) {
        var request = new XMLHttpRequest();
        request.open('POST', u, true);
        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                c(JSON.parse(request.responseText));
            }
        };
        var fd = new FormData();
        for (var k in d) {
            fd.append(k, d[k]);
        }
        request.send(fd);
    },
    show: function(e,s) {
        e.style.display = s ? '' : 'none';
    },
    hide: function (e) {
        e.style.display='none';
    }
};