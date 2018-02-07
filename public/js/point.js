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

    clickArrived: function (t) {
        $.request('/team/arrive', { team: t, point: window.point.id }, function (team) {
            points.updateTeam(t, team);
        });
    },

    clickHint: function(t) {
        $.request('/team/hint', { team: t, point: window.point.id }, function (team) {
            points.updateTeam(t, team);
        })
    },

    updateTeam: function(i, t) {
        window.teams[points.getTeamIndex(i)] = t;
        points.renderTeam(i);
    },

    renderTeam: function (id) {
        var team = points.getTeam(id);
        console.log(team);
        $.show($.id('team'+id+'n'), team.arrived === null);
        $.show($.id('team'+id+'a'), team.arrived !== null);
        $.show($.id('team'+id+'f'), !team.finished);
        $.show($.id('team'+id+'h'), !team.finished && team.hints < window.point.hints);
        $.html($.id('team'+id+'c'), team.hints);
        $.show($.id('team'+id+'d'), team.departed !== null);
        $.html($.id('team'+id+'dc'), team.departed);
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
        $.html($.id('team'+t.id+'t'), $.lpad(d.minutes, 0, 2) + ':' + $.lpad(d.seconds, 0, 2));
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