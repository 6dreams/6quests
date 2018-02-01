points = {
    getTeamIndex: function (id) {
        for (var i = 0; window.teams.length; i++) {
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
        $.request('/team/arrive', {team: t, point: window.point.id}, function (team) {
            window.teams[points.getTeamIndex(t)] = team;
            points.renderTeam(t);
        });
    },

    renderTeam: function (id) {
        var team = points.getTeam(id);
        $.show($.id('team'+id+'n'), team.arrived === null);
        $.show($.id('team'+id+'a'), team.arrived !== null);
        $.show($.id('team'+id+'f'), team.finished);
    }
};