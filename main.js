window.onload = function () {
    let buttons = document.getElementsByClassName("button");
    let pop_bkg = document.getElementById("background");
    let pop_space = document.getElementById("space");
    buttons[1].addEventListener("click", event => {
        console.log('transfer ok');
        pop_bkg.style.display = 'block';
        pop_space.style.display = 'grid';
    });
    buttons[2].addEventListener("click", event => {
        console.log('date card ok');
    });
    buttons[3].addEventListener("click", event => {
        console.log('istoric ok');
        pop_bkg.style.display = 'block';
        pop_space.style.display = 'grid';
    });
    buttons[4].addEventListener("click", event => {
        console.log('round up ok');
    });

    document.getElementById("pop-exit").onclick = function(){
        pop_bkg.style.display = 'none';
        pop_space.style.display = 'none';
    }
    document.getElementById("eco").onclick = function(){
        window.location.href = "eco.html";
    }
}