$.ajax({
    method: 'GET',
    url: 'http://www.giantbomb.com/api/game/3030-4725/?api_key=7d3e51ce684ca4c6063d50f2646a4cc46fa6ca55&format=json&field_list=genres,nom',
    crossDomain: true,
    dataType: "json"

}).done(function(games){
    for(let game of games){
        // $('#games').append("<h2>game.results.genres[name]</h2>")
        console.log(games);
    }
});