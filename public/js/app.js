document.addEventListener("DOMContentLoaded", function() {

    setTimeout(showPage, 1000);
    
    function showPage() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("myDiv").style.display = "block";
    }

    ///////////////////////////////////////////////////////////// 

    $(window).scroll(function() {
        if ($(window).scrollTop() >= 10) {
            $('.topBtn').addClass('hide');
        } else {
            $('.topBtn').removeClass('hide');
        }
    })
    $('.topBtn').on('click', function() {
        $('html').animate({scrollTop:0});
    })

});