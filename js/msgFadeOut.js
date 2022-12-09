let $msgContainer = document.querySelector(".msg-container");
let $msg = document.querySelector(".msg");

if($msg){
    $($msg).fadeOut(10000);
    
    setTimeout(function () {
        $($msgContainer).fadeOut(1);
    }, 9999);
}