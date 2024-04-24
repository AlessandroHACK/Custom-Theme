function iniciarMenuHamburguesa() {
    const hamburger = document.querySelector('.hamburguer-menu svg')
    hamburger.addEventListener('click', function() {
        const menuPrincipal = document.querySelector('.contenedor-menu');
        menuPrincipal.classList.toggle('mostrar');
    })
}

document.addEventListener('DOMContentLoaded', iniciarMenuHamburguesa);
