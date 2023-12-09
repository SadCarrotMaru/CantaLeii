var body = document.body,
    html = document.documentElement;

var height = Math.max( body.scrollHeight, body.offsetHeight, 
                       html.clientHeight, html.scrollHeight, html.offsetHeight );
var width = Math.max( body.scrollWidth, body.offsetWidth, 
                        html.clientWidth, html.scrollWidth, html.offsetWidth );


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

function areSquaresColliding_2(square1TL, square1BR, square2TL, square2BR) 
{
    if (square1BR.x < square2TL.x || square1TL.x > square2BR.x) {
        return false; 
    }

    if (square1BR.y < square2TL.y || square1TL.y > square2BR.y) {
        return false;
    }

    if (square1TL.y > square2TL.y) return false;
    return true;
}

function areSquaresColliding(square1TL, square1BR, square2TL, square2BR) 
{
    if (square1BR.x < square2TL.x || square1TL.x > square2BR.x) {
        return false; 
    }

    if (square1BR.y < square2TL.y || square1TL.y > square2BR.y) {
        return false;
    }

    return true;
}



function check_collision(x, y, w, h, cnt)
{
    var treeTL = {x: x, y: y}
    //var wV = parseInt(w, 10) ;
    //var wH = parseInt(h, 10) ;
    var treeBR = {x: x+w, y:y+h};
    var treeElements = document.getElementsByClassName('copac');
    for (var i = 0; i < treeElements.length; i++) 
    {
        var x1 = parseInt(treeElements[i].style.left);
        var y1 = parseInt(treeElements[i].style.top);
        var widthValue = parseInt(treeElements[i].style.width, 10) ;
        var heightValue = parseInt(treeElements[i].style.height, 10) ;
        var treeITL = {x: x1, y: y1};
        var treeIBR = {x: x1+widthValue, y:y1+heightValue};
        if(cnt>7)
        {
            if(areSquaresColliding(treeTL,treeBR,treeITL,treeIBR) == true)
                return true;
        }
            else
            {
                if(areSquaresColliding_2(treeTL,treeBR,treeITL,treeIBR) == true)
                return true;
            }        
    }
    return false;
}
function generate_tree()
{
    const treeElement = document.createElement('img');
    treeElement.className = "copac";
    
    var x = Math.random() * (width - 150);
    var y = Math.random() * (height - 150);
    var size = 50 + ( y / (height - 150) ) * 100;
    var cnt = 0;
    while(check_collision(x,y,size,size,cnt))
    {
        x = Math.random() * (width - 150);
        y = Math.random() * (height - 150);
        size = 50 + ( y / (height - 150) ) * 100;
        cnt ++;
    }
    var tree_ = getRandInt(3)
    if(tree_ == 0) treeElement.src = 'tree1.svg';
        else if(tree_ == 1) treeElement.src = 'tree2.svg'
            else treeElement.src='tree3.svg'
    treeElement.style.position = 'absolute';
    
    treeElement.style.left = x + 'px';
    treeElement.style.top = y + 'px';
    treeElement.style.width = size + 'px';
    treeElement.style.height = size + 'px';
    
    document.getElementById('tree_container').appendChild(treeElement);
}


function generate_trees(user_eco_points)
{
    console.log(width);
    console.log(height);
    trees = user_eco_points / 10;
    for(var i=0;i<trees;i++)
        generate_tree()
}

generate_trees(605)
