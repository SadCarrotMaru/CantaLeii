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
    generate_trees(55)
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

const options = 
{
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0,
};
  
function success(pos) 
{
    const crd = pos.coords;
    var latitude = crd.latitude;
    var longitude = crd.longitude; 
    console.log("Your current position is:");
    console.log(`Latitude : ${crd.latitude}`);
    console.log(`Longitude: ${crd.longitude}`);
    console.log(`More or less ${crd.accuracy} meters.`);
}
  
function error(err) 
{
    console.warn(`ERROR(${err.code}): ${err.message}`);
}
  
navigator.geolocation.getCurrentPosition(success, error, options);

function getRandInt(max) 
{
    return Math.floor(Math.random() * max);
}

function generate_tree()
{
    const treeElement = document.createElement('img');
    var x = getRandInt(1000) + 300
    var y = getRandInt(1000)
    var tree_ = getRandInt(3)
    if(tree_ == 0) treeElement.src = 'tree1.svg';
        else if(tree_ == 1) treeElement.src = 'tree2.svg'
            else treeElement.src='tree3.svg'
    treeElement.style.position = 'absolute';
    treeElement.style.left = x + 'px';
    treeElement.style.top = y + 'px';
    treeElement.style.width = '50px';
    treeElement.style.height = '50px';
    document.body.appendChild(treeElement);
}


function generate_trees(user_eco_points)
{
    trees = user_eco_points / 10;
    for(var i=0;i<trees;i++)
        generate_tree()
}
