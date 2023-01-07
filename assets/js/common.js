$( document ).ready(function() {    
    setTimeout(function() {
        $("#fmsg").hide('blind', {}, 500)
    }, 5000);

    //for plan details page
    $(".inactive_plans" ).click(function() {//alert("ssss");

        $("#inactive-msg").html('<span class="show alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>This functionality is not available for you. Please contact to the system administrator for further details.</b></span>');

        setTimeout(function() {
            $( "#inactive-msg" ).hide( 'blind', {}, 1000, callback );
        }, 5000 );

    });
});

function callback() {

    $("#inactive-msg").html('');
    $("#inactive-msg" ).removeAttr( "style" ).hide().fadeIn();

};

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
