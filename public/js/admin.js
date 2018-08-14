$(function(){

    /* dropdown */
    let isMobile = false;

    $('.dropdown').click(function ()
    {

        if (isMobile)
        {
            $(this).children('.m-nav-link').toggleClass('m-dd-active');
            $(this).children('ul').slideToggle();
        }
        else 
        {
            $(this).children('.nav-link').toggleClass('dd-active');
            $(this).children('ul').slideToggle();
        }

    });

    /* mobile navigation */
    $('#toggle-nav-left').click(function ()
    {
        
        $(this).parent().toggle();
        $('#m-nav-left').toggle();

        isMobile = true;

    });

    // if mobile nav is off show normal nav
    $('#m-toggle-nav-left').click(function ()
    {

        $(this).parent().toggle();
        $('#nav-left').toggle();

        isMobile = false;

    });

});