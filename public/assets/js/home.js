$(document).ready(() => {
    
    $('.form-link').on('click', function(e) {

        e.preventDefault();
        $('.form-link').toggleClass('hidden');
        $('.home-form').toggleClass('hidden');

    });

});