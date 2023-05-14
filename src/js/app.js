//para mostrar este archivo en una sola pagina debemos en la pagina base en este caso la de layout.php vamos a crear una echo $variable ?? '' esta variable va a existir pero si no existe entonces agrega un strign vacio el cual no mostrar error de que la variable no existe; y luego en la pagina html que queramos vamos a cargar este scrip osea nos vamos a la pagina y ponemos <?php $script = 'la estiqueta de html para cargar los arvhicos de js <scripts src ... etc>'

//cuando un numero en console log esta de color negro quiere decir que es un string entoces podemos asegurarnos con un typeof 

//cuando creamos una funcion que va a ser llamada muchas veces 

let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

document.addEventListener('DOMContentLoaded', function(){
    iniciarpApp();
})

function iniciarpApp(){
    tabs();
    mostrarSeccion();
    ocultarBotones();
    paginadorSiguiente();
    paginadorAnterior();

}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach((boton) => {
        boton.addEventListener('click', function(e){
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            tabActual();
            ocultarBotones();
        
        })
    })
}


function mostrarSeccion(){
    const seccion = document.querySelector(`#paso-${paso}`); 
    const seccionAnterior = document.querySelector('.mostrar');

    seccion.classList.add('mostrar');

    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }
}

function tabActual(){
    const botonActual = document.querySelector(`[data-paso='${paso}'`);

    const botonAnterior = document.querySelector('.actual');

    botonActual.classList.add('actual');
    
    if(botonActual){
        botonAnterior.classList.remove('actual');
    }
    
}

function ocultarBotones(){
    const paginadorAnterior = document.querySelector(`#anterior`);

    const paginadorSiguiente = document.querySelector(`#siguiente`)

    if(paso === 1){
        paginadorAnterior.classList.add('ocultar');
        paginadorSiguiente.classList.remove('ocultar');
    }else if(paso === 3){
        paginadorAnterior.classList.remove('ocultar');
        paginadorSiguiente.classList.add('ocultar');
    }else{
        paginadorAnterior.classList.remove('ocultar');
        paginadorSiguiente.classList.remove('ocultar');
    }
}

function paginadorSiguiente(){

    const paginadorSiguiente = document.querySelector(`#siguiente`)

    paginadorSiguiente.addEventListener('click', function(){
        
        if(paso >= pasoFinal) return;
            
        paso++
        ocultarBotones();
        mostrarSeccion();
        tabActual();

        console.log(paso);

      
        
    });

}

function paginadorAnterior(){

    const paginadorAnterior = document.querySelector(`#anterior`)

    paginadorAnterior.addEventListener('click', function(){
        
        if(paso <= pasoInicial)return;            
        paso--;

        ocultarBotones();
        mostrarSeccion();
        tabActual();
        
        console.log(paso);

      
    });

}


