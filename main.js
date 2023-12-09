window.onload = function () {
    let buttons = document.getElementsByClassName("button");
    buttons[1].addEventListener("click", event => {
        console.log('transfer ok');
    });
    buttons[2].addEventListener("click", event => {
        console.log('date card ok');
    });
    buttons[3].addEventListener("click", event => {
        console.log('istoric ok');
    });
    buttons[4].addEventListener("click", event => {
        console.log('round up ok');
    });
    document.getElementById("eco").onclick = function(){
        window.location.href = "eco.html";
    }
}