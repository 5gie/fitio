$(document).ready(() => {
    
    const tl = gsap.timeline();

    if($('#alerts').length) {

        const $alert = $('#alerts .alert');
        
        tl.to($alert, 0.6, {

            y:0,
            opacity:1,
            ease: Power2.easeInOut

        }, 0.2).to($alert, 0.6, {
            
            y:'-100%',
            opacity:0,
            ease: Power2.easeInOut

        }, 5).then(() => {

            $('#alerts').remove();
            
        });
        
    }

});