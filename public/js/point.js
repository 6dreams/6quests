points = {
    getTeamIndex: function (id) {
        for (var i = 0; i < window.teams.length; i++) {
            if (window.teams[i].id === id) {
                return i;
            }
        }

        return -1;
    },

    getTeam: function (id) {
        return window.teams[points.getTeamIndex(id)];
    },

    serverCallback: function (team) {
        window.teams[points.getTeamIndex(team.id)] = team;
        points.renderTeam(team.id);
    },

    clickArrived: function (t) {
        $.request('/team/arrive', { team: t, point: window.point.id }, points.serverCallback);
    },

    clickHint: function(t) {
        $.request('/team/hint', { team: t, point: window.point.id }, points.serverCallback)
    },

    clickDepart: function(t) {
        $.request('/team/depart', { team: t, point: window.point.id }, points.serverCallback);
    },

    renderTeam: function (id) {
        var team = points.getTeam(id);
        id = team.id;
        $.show('team' + id, team.arrived !== null && !team.finished);
        $.show('team' + id + 'arr-ctl', team.arrived === null);
        for (var i = 1; i <= point.hints; i++) {
            var el = $.id('team' + id + 'hint' + i);
            team.hints >= i ? $.addClass(el, 'red') : $.removeClass(el, 'red');
        }
    },

    refreshAllTeams: function() {
        for (var i = 0; i < window.teams.length; i++) {
            points.renderTeam(window.teams[i].id);
        }
    },

    teamTimer: function (t) {
        var dt = new Date(t.arrived*1000);
        dt.setMinutes(dt.getMinutes() + point.time);

        var d = $.dateDiff(dt, new Date());
        if (!d.remain) {
            t.finished = true;
            window.teams[points.getTeamIndex(t.id)] = t;
            points.renderTeam(t.id);
            return;
        }
        var pointTime = point.time * 60;
        var teamTime = pointTime - (d.minutes * 60 + d.seconds);
        $.id('team' + t.id + 'progress').value = teamTime / pointTime * 100;
        $.html($.id('team'+t.id+'progress'), $.lpad(d.minutes, 0, 2) + ':' + $.lpad(d.seconds, 0, 2));
    },

    tick: function() {
        for (var i = 0; i < window.teams.length; i++) {
            var team = window.teams[i];
            if (team.arrived !== null && !team.finished) {
                points.teamTimer(team);
            }
        }
        setTimeout(points.tick, 1000);
    }
};
