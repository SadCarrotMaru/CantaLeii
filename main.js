
var lightblue= "rgb(184,241,241)";
var lightpurple= "rgb(211,172,212)";
var pink="rgb(236, 158, 180)";
var red= "rgb(218, 88, 125)";

window.onload = function () {
    let buttons = document.getElementsByClassName("button");
    let pop_bkg = document.getElementById("background");
    let pop_space = document.getElementById("space");
    buttons[1].addEventListener("click", event => {
        pop_bkg.style.display = 'block';
        pop_space.style.display = 'grid';
        document.getElementById("pop-transfer").style.display = 'block';
    });
    buttons[2].addEventListener("click", event => {
        console.log('date card ok');
    });
    buttons[3].addEventListener("click", event => {
        pop_bkg.style.display = 'block';
        pop_space.style.display = 'grid';
        document.getElementById("pop-istoric").style.display = 'block';
    });
    buttons[4].addEventListener("click", event => {
        pop_bkg.style.display = 'block';
        pop_space.style.display = 'grid';
        document.getElementById("pop-roundup").style.display = 'block';

    });
    buttons[5].addEventListener("click", event => {
        pop_bkg.style.display = 'block';
        pop_space.style.display = 'grid';
        document.getElementById("pop-setari").style.display = 'block';
    });
    let soldv=document.getElementById("sold").innerHTML;
    let ibanv=document.getElementById("iban").innerHTML;

    let sold = document.getElementById("soldb");
    let iban = document.getElementById("ibanb");
    sold.addEventListener("click", event=>{
        if(sold.innerHTML==soldv){
            sold.innerHTML="(SOLD)";
        }
        else
            sold.innerHTML = soldv;
    });
    iban.addEventListener("click", event=>{
        if(iban.innerHTML==ibanv){
            iban.innerHTML="(IBAN)";
        }
        else
        iban.innerHTML = ibanv;
    });

    document.getElementById("pop-exit").onclick = function(){
        pop_bkg.style.display = 'none';
        pop_space.style.display = 'none';
        document.getElementById("pop-transfer").style.display = 'none';
        document.getElementById("pop-istoric").style.display = 'none';
        document.getElementById("pop-setari").style.display = 'none';
        document.getElementById("pop-roundup").style.display = 'none';
    }
    document.getElementById("eco").onclick = function(){
        window.location.href = "eco.html";
    }
    var harta= document.getElementById("card-container");
    var ha = document.createElement("canvas");
    h = harta.offsetHeight;//-0.05*harta.clientHeight;
    w = harta.offsetWidth;//-0.05*harta.clientWidth;
    ha.setAttribute('id','canvcard');
    ha.setAttribute('width',w+'px');
    ha.setAttribute('height',h+'px');
    harta.appendChild(ha);
    //door.addEventListener("click",onclick);
    draw(h,w);
 }  

 var cornerRadius = 20;

    // Draw a rounded rectangle
    function drawRoundedRect(ctx,x, y, width, height, radius) {
        ctx.fillStyle = lightblue;
        ctx.beginPath();
      ctx.moveTo(x + radius, y);
      ctx.arcTo(x + width, y, x + width, y + height, radius);
      ctx.arcTo(x + width, y + height, x, y + height, radius);
      ctx.arcTo(x, y + height, x, y, radius);
      ctx.arcTo(x, y, x + width, y, radius);
      ctx.closePath();
      ctx.stroke();
      ctx.fill();
    }

    function drawText(ctx, text, x, y, fontSize, color) {
        ctx.fillStyle = color; // Set the fill color for the text
        ctx.font = fontSize + "px Arial";
        ctx.fillText(text, x, y);
    }
    

    function draw(h, w) {
        //$acc_id=$row["account_id"];
        //iban=document.getElementById("iban").innerHTML();
        cnum=document.getElementById("card_nr");
        valid=document.getElementById("valid_thru").innerHTML;
        cvc=document.getElementById("cvc").innerHtML;
        sold=document.getElementById("sold").innerHTML;
        fn=document.getElementById("first_name").innerHTML;
        ln=document.getElementById("last_name").innerHTML;
        str = fn+" "+ln+" "+valid;
                
        const canvas = document.getElementById("canvcard");
        if (canvas.getContext) {
            const ctx = canvas.getContext("2d");
            drawRoundedRect(ctx, 2, 2, w - 4, h - 4, cornerRadius);
            var text = cnum.innerHTML;
            console.log(text);
            drawText(ctx, text, 20, (2 / 3) * h, 30, "black");
            drawText(ctx, str, 20, (2.5/3) *h,16,"black");
        }
}

/*
window.onload = function() {
    var harta= document.getElementById("card-container");
    var ha = document.createElement("canvas");
    h = harta.offsetHeight;//-0.05*harta.clientHeight;
    w = harta.offsetWidth;//-0.05*harta.clientWidth;
    ha.setAttribute('id','canvcard');
    ha.setAttribute('width',w+'px');
    ha.setAttribute('height',h+'px');
    harta.appendChild(ha);
    //door.addEventListener("click",onclick);
    draw(h,w);
 }  

 var cornerRadius = 20;

    // Draw a rounded rectangle
    function drawRoundedRect(ctx,x, y, width, height, radius) {
        ctx.fillStyle = lightblue;
        ctx.beginPath();
      ctx.moveTo(x + radius, y);
      ctx.arcTo(x + width, y, x + width, y + height, radius);
      ctx.arcTo(x + width, y + height, x, y + height, radius);
      ctx.arcTo(x, y + height, x, y, radius);
      ctx.arcTo(x, y, x + width, y, radius);
      ctx.closePath();
      ctx.stroke();
      ctx.fill();
    }

    function drawText(ctx, text, x, y, fontSize, color) {
        ctx.fillStyle = color; // Set the fill color for the text
        ctx.font = fontSize + "px Arial";
        ctx.fillText(text, x, y);
    }
    

    function draw(h, w) {
        //$acc_id=$row["account_id"];
        //iban=document.getElementById("iban").innerHTML();
        cnum=document.getElementById("card_nr");
        valid=document.getElementById("valid_thru").innerHTML;
        cvc=document.getElementById("cvc").innerHtML;
        sold=document.getElementById("sold").innerHTML;
        fn=document.getElementById("first_name").innerHTML;
        ln=document.getElementById("last_name").innerHTML;
        str = fn+" "+ln+" "+valid;
                
        const canvas = document.getElementById("canvcard");
        if (canvas.getContext) {
            const ctx = canvas.getContext("2d");
            drawRoundedRect(ctx, 2, 2, w - 4, h - 4, cornerRadius);
            var text = cnum.innerHTML;
            console.log(text);
            drawText(ctx, text, 20, (2 / 3) * h, 25, "black");
            drawText(ctx, str, 20, (2.5/3) *h,16,"black");
        }
    }
    */