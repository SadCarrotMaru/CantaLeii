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
function generate_tree(min_tree, max_tree)
{
    const treeElement = document.createElement('img');
    treeElement.className = "copac";
    
    var x = Math.random() * (width - max_tree);
    var y = Math.random() * (height - max_tree);
    var size = min_tree + ( y / (height - max_tree) ) * (max_tree - min_tree);
    var cnt = 0;
    while(check_collision(x,y,size,size,cnt))
    {
        x = Math.random() * (width - max_tree);
        y = Math.random() * (height - max_tree);
        size = min_tree + ( y / (height - max_tree) ) * (max_tree - min_tree);
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


function generate_trees(user_eco_points, min_tree, max_tree)
{
    console.log(width);
    console.log(height);
    trees = user_eco_points / 10;
    for(var i = 0; i < trees; i++)
        generate_tree(min_tree, max_tree);
}

var body, html, height, width;


window.onload = function(){
    body = document.body;
    html = document.documentElement;

    height = Math.max( body.scrollHeight, body.offsetHeight, 
                        html.clientHeight, html.scrollHeight, html.offsetHeight );
    width = Math.max( body.scrollWidth, body.offsetWidth, 
                            html.clientWidth, html.scrollWidth, html.offsetWidth );

    var points = 122, min_tree = 150, max_tree = 450;
    generate_trees(points, min_tree, max_tree);
}
