$(document).ready(function () {

    // $('#navbar>ul>li>a').on('click', function () {
    //     $('#navbar').removeClass('navbar-mobile')
    //     $('.mobile-nav-toggle').removeClass('bi-x').addClass('bi-list');
    //     // alert('ok');
    // });

    $('#navbar>ul>li>a').click(function () {
        setTimeout(function () {
            $('#navbar').removeClass('navbar-mobile')
            $('.mobile-nav-toggle').removeClass('bi-x').addClass('bi-list');
        }, 500);
    });
});