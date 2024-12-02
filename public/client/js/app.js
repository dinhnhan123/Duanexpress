

$(document).ready(function(){
    $('.navbar-toggle').click(function(){
        $('.wp-responsive').stop().slideToggle(500);
        $(this).toggleClass('bg-red');
        $(this).toggleClass('color-white');
            hide_responsive_submenu()
    })
   $('.responsive-menu-toggle').click(function(){
        $(this).next('ul.sub-menu').slideToggle(500)
        $(this).toggleClass('open')
   })
    function hide_responsive_menu(){
        $('.navbar-toggle').removeClass('bg-red');
        $('.wp-responsive').slideUp(500);
    }
    function hide_responsive_submenu(){
        $('ul#menu-responsive ul.sub-menu').slideUp(500);
        $('.responsive-menu-toggle').removeClass('open')
    }
        $(window).resize(function(){
            hide_responsive_menu()
            hide_responsive_submenu()
        })
        $(window).scroll(function(){
            hide_responsive_menu()
            hide_responsive_submenu()
        });

        //form
        $('.search-responsive').click(function(){
           if($(this).prev('input.search-form-responsive').hasClass('display-none')){
            $(this).prev('input.search-form-responsive').removeClass('display-none')
            $(this).prev('input.search-form-responsive').addClass('display-block')
            $($(this)).addClass('bg-gray')
           }else if($(this).prev('input.search-form-responsive').hasClass('display-block')){
            $(this).prev('input.search-form-responsive').removeClass('display-block')
            $(this).prev('input.search-form-responsive').addClass('display-none')
            $($(this)).removeClass('bg-gray')
           }
        })
        // $('.search-responsive').click(function(){
        //     $(this).prev('input.search-form-responsive').toggleClass('display-block')
        //  })
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:2
                },
                1000:{
                    items:4
                }
            }
        })
})

