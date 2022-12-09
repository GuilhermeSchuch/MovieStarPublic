  function addCapsLockWarning(input, txt){
    let $input = document.querySelector(input);
    let text = document.querySelector(txt);

    $input.addEventListener('keyup', function (e) {
        if (e.getModifierState('CapsLock')) {
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    });
}

