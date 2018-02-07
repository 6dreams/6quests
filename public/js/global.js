$ = {
    id: function(i){
        return document.getElementById(i)
    },
    class: function(c) {
        return document.getElementsByClassName(c)
    },
    html: function (e,v) {
        e.innerHTML = v;
    },
    request: function (u, d, c) {
        var request = new XMLHttpRequest();
        request.open(d === null ? 'GET' : 'POST', u, true);
        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                c(JSON.parse(request.responseText));
            }
        };
        var fd = null;
        if (d !== null) {
            fd = new FormData();
            for (var k in d) {
                fd.append(k, d[k]);
            }
        }
        request.send(fd);
    },
    show: function(e,s) {
        e.style.display = s ? '' : 'none';
    },
    hide: function (e) {
        e.style.display='none';
    },
    ready: function(fn) {
        if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    },
    dateDiff: function(d1, d2) {
        var diff=d2-d1, sign=diff < 0 ?-1:1,seconds,minutes,hours,days;
        diff/=sign;
        diff=(diff-(diff%1000))/1000;
        diff=(diff-(seconds=diff%60))/60;
        diff=(diff-(minutes=diff%60))/60;
        days=(diff-(hours=diff%24))/24;

        return {days: days, hours: hours, minutes: minutes, seconds: seconds, remain: sign !== 1};
    },

    lpad: function(s, v, l) {
        s = s.toString();
        if (!l) { l = 0; }
        while(s.length < l){
            s = v + s;
        }

        return s;
    }
};