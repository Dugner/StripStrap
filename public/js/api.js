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
        // $('#articleTitle').append(article.title+"<br>");
        $('#articleTitlePage').append('<a href="#'+article.title+'">'+article.title+'</a><br><br>');
        // article title dans le right side bar /articleTitle
        $('#homepageArticles').append("<p>"+article.title+"</p>");
        $('#articleTitle').append(article.title);

        console.log(articles);
    }
});