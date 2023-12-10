function getRandInt(max) {
    return Math.floor(Math.random() * max);
}

function areSquaresColliding_3(square1TL, square1BR, square2TL, square2BR) {
    if (square1BR.x < square2TL.x || square1TL.x > square2BR.x) {
        return false; 
    }
    if (square1BR.y < square2TL.y || square1TL.y > square2BR.y) {
        return false;
    }
    if (square1TL.y > square2TL.y) 
        return false;
    return true;
}

function areSquaresColliding_2(square1TL, square1BR, square2TL, square2BR) {
    if (square1BR.x < square2TL.x || square1TL.x > square2BR.x) {
        return false; 
    }
    if (square1BR.y < square2TL.y || square1TL.y > square2BR.y) {
        return false;
    }
    if (square1TL.y > square2TL.y + 20 && Math.abs(square1TL.x - square2TL.x) > 35) 
        return false;
    return true;
}

function areSquaresColliding(square1TL, square1BR, square2TL, square2BR) {
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
        if(cnt < 15) {
            if(areSquaresColliding(treeTL,treeBR,treeITL,treeIBR) == true)
                return true;
        }
        else {
            if(cnt < 30){
                if(areSquaresColliding_2(treeTL,treeBR,treeITL,treeIBR) == true)
                    return true;
            }
            else{
                if(areSquaresColliding_3(treeTL,treeBR,treeITL,treeIBR) == true)
                    return true;
            }   
        }        
    }
    return false;
}

function generate_apple(treeDiv, x, y, radius, size){
    const apple = document.createElement('img');
    var new_radius = Math.random() * radius;
    var direction = Math.random() * Math.PI;
    random_apple = getRandInt(4);
    switch(random_apple){
        case 0: apple.src = 'apple1.svg'; break;
        case 1: apple.src = 'apple2.svg'; break;
        case 2: apple.src = 'apple3.svg'; break;
        case 3: apple.src = 'apple4.svg'; break;
        default: break;
    }
    apple.style.position = 'absolute';
    apple.style.left = (x + Math.cos(direction) * new_radius - size / 2) + 'px';
    apple.style.top = (y + (-1) * Math.sin(direction) * new_radius - size / 2) + 'px';
    apple.style.width = size + 'px';
    apple.style.height = size + 'px';
    apple.classList.add("tree_apple");
    // apples.push(apple);
    treeDiv.appendChild(apple);
}

function generate_tree(min_tree, max_tree) {
    const treeElement = document.createElement('img');
    treeElement.className = "copac";
    
    var x = Math.random() * (width - max_tree);
    var y = Math.random() * (height - max_tree);
    var size = min_tree + ( y / (height - max_tree) ) * (max_tree - min_tree);
    var cnt = 0;
    while(check_collision(x,y,size,size,cnt)) {
        x = Math.random() * (width - max_tree);
        y = Math.random() * (height - max_tree);
        size = min_tree + ( y / (height - max_tree) ) * (max_tree - min_tree);
        cnt ++;
    }
    var tree_ = getRandInt(3);
    var offset_y = 0;
    var offset_size = -25;
    switch(tree_){
        case 0: treeElement.src = 'tree1.svg'; offset_y = 25; break;
        case 1: treeElement.src = 'tree2.svg'; break;
        case 2: treeElement.src = 'tree3.svg'; offset_y = -10; offset_size = -30; break;
        default: break;
    }
    treeElement.style.position = 'absolute';
    treeElement.style.left = x + 'px';
    treeElement.style.top = y + 'px';
    treeElement.style.width = size + 'px';
    treeElement.style.height = size + 'px';

    const treeDiv = document.createElement('div');
    treeDiv.appendChild(treeElement);
    var nr_apples = getRandInt(5);
    for(let i = 0; i <= nr_apples; i++){
        generate_apple(treeDiv, x + size/2, y + size/2 + offset_y, size/2 + offset_size, 20);
    }
    treeDiv.style.overflow = 'hidden';
    document.getElementById('tree_container').appendChild(treeDiv);
}


function generate_trees(user_eco_points, min_tree, max_tree)
{
    console.log(width);
    console.log(height);
    trees = Math.trunc(user_eco_points / 10);
    console.log(trees);
    for(var i = 0; i < trees; i++)
        generate_tree(min_tree, max_tree);
}

var body, html, height, width;
var apples = [];

window.onload = function(){
    eco();
    body = document.body;
    html = document.documentElement;

    height = Math.max( body.scrollHeight, body.offsetHeight, 
                        html.clientHeight, html.scrollHeight, html.offsetHeight );
    width = Math.max( body.scrollWidth, body.offsetWidth, 
                            html.clientWidth, html.scrollWidth, html.offsetWidth );

    var points = document.getElementById("total").innerHTML, min_tree = 150, max_tree = 300;
    console.log(points);
    generate_trees(points, min_tree, max_tree);
    apples = Array.from(document.getElementsByClassName("tree_apple"));
    apple_maybe_fall = setInterval(function () {
        if (apples.length == 0)
          clearInterval(apple_maybe_fall);
        else{
            for(let i = 0; i < apples.length; i++){
                var rando = Math.random() < 0.03; 
                if(rando){
                    apples[i].classList.remove("tree_apple");
                    apples[i].classList.add("falling_apple");
                    setTimeout(function () {
                        apples[i].classList.remove("falling_apple");
                        apples[i].classList.add("no_apple");
                        apples.splice(i, 1);                       
                    }, 5000);
                    break;
                }
            }
        }
      }, 1000);
}
