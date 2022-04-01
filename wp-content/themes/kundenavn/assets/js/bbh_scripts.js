(function($) {


    /*========================================
    =           Cases ajax                  =
    ========================================*/
    function runAjax() {
        var filter = $('#filter') // Get form
        var wrapper = $('#response') // Get markup grid container
        $.ajax({
            url:filter.attr('action'), // Get form action
            data:filter.serialize(), // Get form data
            type:filter.attr('method'), // Get form method
            beforeSend:function(){
                wrapper.animate({opacity:0},100)// Fade markup out
            },
            success:function(data){
                if(data.cases){
                    wrapper.html(data.cases) // insert data from output buffer in archives-cases.php
                } else if(data.news){
                    wrapper.html(data.news) // insert data from output buffer in archives-nyheder.php
                }
            },
            complete:function(){
               wrapper.delay(200).animate({opacity:1},200) // Fade markup in
            },
            error:function(error){
                wrapper.css('opacity', 1) // Fade markup in
                console.log(error) // Console log error
            }
        })
    }

    //Run ajax on form change
    $('#filter').change(function(){
        runAjax()
        return false
    })
    //Reset when 'all' is pressed
    $('#resetform').click(function() {
      $('#filter input').each(function () {
        $(this).attr('checked',false)
      })
      $(this).attr('checked',true)
      runAjax()
    })
    //Label click = input click
    $('#filter label, #filter-tags label').click(function() {
      $(this).siblings('input').click()
      $(this).parent().siblings().children('input').attr('checked',false)
    })


    /*-------------- C1 - VIDEO -------------*/
    function openVideoPopup(e){
        e.preventDefault()

        var trigger = $(this),
        src         = trigger.attr('data-video-src'),
        lightbox    = $('#video-lightbox'),
        iframe      = lightbox.find('iframe'),
        overlay     = $('#video-overlay');

        if(src.length < 1){
            return
        }

        iframe.attr('src', src)
        lightbox.fadeIn('400')
        overlay.fadeIn('400')
    }

    function closeVideoPopup(){
        var lightbox = $('#video-lightbox'),
        iframe       = lightbox.find('iframe'),
        overlay      = $('#video-overlay')

        lightbox.fadeOut('400', function(){
            iframe.attr('src', '')
        })
        overlay.fadeOut('400')
    }

    $(document).ready(function(){
      // open on trigger click
        $('.video-trigger').on('click', openVideoPopup);
        $('.fp-banner .link a[data-video-src]').on('click', openVideoPopup);
        // mandatory close triggers.
        $('#video-lightbox .close-button').on('click', closeVideoPopup);
        $('#video-overlay').on('click', closeVideoPopup);

        // close video on esc key
        $(document).on('keydown', function(e){
        if(e.which == 27 ){
            closeVideoPopup()
        }
        })


        $('.primary-button').wrapInner('<span></span>')
    })





})( jQuery )
lazySizes.init(); //fallback if img is above-the-fold
