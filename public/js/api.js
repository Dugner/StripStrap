$.ajax({
    method: 'GET',
    url: '/gamespot/events',
    dataType: "json"

}).done(function(events){
    for(let event of events){
         $('#games').append("<ul><li><h4 style='color:rgb(7, 223, 43)'>"+ event.title + "</h4><p>"+ event.description +"</p>"+"</li></ul>");

        console.log(events);
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

        // console.log(articles);
    }
});

$.ajax({
    method: 'GET',
    url: '/game/videos',
    data: {page: appConfig.api_limit},
    dataType: "json"
}).done(function(videos){
    for(video of videos){
        $('#videosTitlePage').append('<a href="#'+video.title+'">'+video.title+'</a><br><br>');
        $('#videos').append('<h2 id="'+video.title+'">'+video.title+'</h2>');
        $('#videos').append('<video width="600" height="400" controls><source src="'+video.low_url+'" type="video/mp4" preload="auto|metadata|none">Your browser does not support the video tag.</video><br><hr>')
    }
});