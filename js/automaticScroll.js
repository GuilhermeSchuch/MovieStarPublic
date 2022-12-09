var target_offset = $(".scroll").offset();

if(target_offset){
    var target_top = target_offset.top;
    $('html, body').animate({ scrollTop: target_top }, 0);
}