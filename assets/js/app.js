const text = `> Inicializando projeto...

✔ PHP 8.2
✔ MySQL
✔ JavaScript
✔ HTML5
✔ CSS3
✔ APIs REST
✔ Sistemas Web
✔ Landing Pages
✔ FiveM
✔ Bots Discord
✔ Inteligência Artificial

Projeto compilado com sucesso...
`;

let i = 0;

function typeWriter(){

    if(i < text.length){

        document.getElementById("typing").innerHTML += text.charAt(i);

        i++;

        setTimeout(typeWriter,25);

    }

}

typeWriter();

window.addEventListener("scroll",()=>{

    const header=document.querySelector("header");

    if(window.scrollY>40){

        header.classList.add("scrolled");

    }else{

        header.classList.remove("scrolled");

    }

});