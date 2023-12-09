function toggleButtons() 
{
    var buttons = document.querySelectorAll('button');
    var backImg = document.getElementById('back');
    var divEcoRoundUp = document.getElementById('div_eco_round_up');
    var livada = document.getElementById('livada');
    var metrou = document.getElementById('metrou');

    if (buttons[0].style.display !== 'none') 
    {
        //hide
        for(var i = 0; i < buttons.length; i++) 
            buttons[i].style.display = 'none';

        backImg.style.display = 'block';
    } 
        else 
        {
            //show
            for (var i = 0; i < buttons.length; i++) 
                buttons[i].style.display = 'inline-block';

        switch_divs(localStorage.pagename,"wrapper");
        localStorage.pagename = "wrapper";
        divEcoRoundUp.style.display = 'none';
        livada.style.display = 'none';
        metrou.style.display = 'none';
        backImg.style.display = 'none';
    }
}

function switch_divs(str1, str2)
{
    let div1 = document.getElementById(str1);
    let div2 = document.getElementById(str2);
    let temp = div1.cloneNode(true);

    div1.innerHTML = div2.innerHTML;
    div1.className = div2.className;

    div2.innerHTML = temp.innerHTML;
    div2.className = temp.className;
}

localStorage.pagename = "none";

function button1()
{
    switch_divs("wrapper","div_eco_round_up")
    localStorage.pagename = "div_eco_round_up";
    toggleButtons()
}
function button2()
{
    switch_divs("wrapper","livada")
    localStorage.pagename = "livada";
    toggleButtons()
}
function button3()
{
    switch_divs("wrapper","metrou")
    localStorage.pagename = "metrou";
    toggleButtons();
}
