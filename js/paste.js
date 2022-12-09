let input = document.querySelector("#confirmpassword");

if(input){
    input.addEventListener("paste", function(e){
        e.preventDefault();
    });
}