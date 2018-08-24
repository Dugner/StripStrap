$.ajax({
    method: 'GET',
    url: '/game/events',
    dataType: "json"

}).done(function(events){
    for(let event of events){
         $('#games').append("<ul><li><h4 style='color:rgb(7, 223, 43)'>"+ event.title + "</h4><p></li></ul>");
         $('#eventsTitlePage').append('<a href="#'+event.title+'">'+event.title+'</a><br><br>');
         $('#events').append('<h2 id="'+event.title+'">'+event.title+'</h2>');
         $('#events').append('<p>'+event.description+'</p>');

        // console.log(events);
    }
});

$.ajax({
    method: 'GET',
    url: '/game/articles',
    data: {page: appConfig.api_limit},
    dataType: "json"
}).done(function(articles){
    for(let article of articles){
        $('#articles').append('<h2 id="'+article.title+'">'+article.title+'</h2>');
        $('#articles').append("<p>"+article.body+"</p>");
        $('#articles').append("<small>"+article.authors+","+article.publish_date+"</small><hr>");
        $('#articleTitle').append(article.title+"<br>");
        $('#articleTitlePage').append('<a href="#'+article.title+'">'+article.title+'</a><br><br>');
        $('#homepageArticles').append("<p>"+article.title+"</p>");

        //console.log(articles);
    }
});

$.ajax({
    method: 'GET',
    url: '/game/videos',
    data: {page: appConfig.api_limit},
    dataType: "json"
}).done(function(videos){
    for(let video of videos){
        $('#videosTitlePage').append('<a href="#'+video.title+'">'+video.title+'</a><br><br>');
        $('#videos').append('<h2 id="'+video.title+'">'+video.title+'</h2>');
        $('#videos').append('<video width="600" height="400" controls><source src="'+video.low_url+'" type="video/mp4" preload="auto|metadata|none">Your browser does not support the video tag.</video><br><hr>')
    }
});

$.ajax({
    method: 'GET',
    url: '/game/games',    
    data: {page: appConfig.api_limit},
    dataType: "json"
}).done(function(games){
    $('.games-loader').remove();

    console.log(games);
    for(let game of games){
        $('#gamesTitlePage').append('<a href="#'+game.name+'">'+game.name+'</a><br><br>'); 
        $('#gamesDiv').append('<h2 id="'+game.name+'">'+game.name+'</h2>');
        for(let genre of game.genres)
        $('#gamesDiv').append("<p>"+genre.name+"</p>");
        console.log(game);
    }
});