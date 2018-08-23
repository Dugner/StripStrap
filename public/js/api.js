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
    dataType: "json"
}).done(function(articles){
    for(let article of articles){
        $('#articles').append("<h5>"+article.title+"</h5>");
        console.log(articles);
    }
});