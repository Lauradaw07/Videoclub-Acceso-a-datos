let body = document.querySelector('body');
let imagenes = ["../Images/Untitled-1.jpg","../Images/Untitled-2.jpg"];
let numFoto = 0;

const interval = setInterval(() => {
    body.style.backgroundImage = "url(" + imagenes[numFoto] + ")";
    body.style.animation = "linear alternate";
    if(numFoto==1) numFoto--;
    else numFoto++;
}, 7000);