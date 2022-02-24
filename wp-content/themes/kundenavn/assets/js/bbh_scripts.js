(function($) {


/*========================================
=           filter ajax                  =
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

            if(data.filter){
                wrapper.html(data.filter) // insert data from output buffer in archives-filter.php
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

})( jQuery )
lazySizes.init(); //fallback if img is above-the-fold
