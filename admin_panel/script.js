document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);

var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

// Configuración inicial para asegurar que el formulario de inicio de sesión esté visible y accesible
function inicializarPagina() {
    formulario_login.style.display = "block";
    formulario_login.style.opacity = "1";
    formulario_login.style.zIndex = "1";
    formulario_register.style.display = "none";
    formulario_register.style.opacity = "0";
    formulario_register.style.zIndex = "0";
}

function anchoPage() {
    if (window.innerWidth > 850) {
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    } else {
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        formulario_register.style.display = "none";
        contenedor_login_register.style.left = "0px";
    }
}

inicializarPagina(); // Llamada inicial para asegurar visibilidad correcta
anchoPage();

function iniciarSesion() {
    formulario_login.style.display = "block";
    formulario_login.style.opacity = "1";
    formulario_login.style.zIndex = "1";
    formulario_register.style.opacity = "0";
    formulario_register.style.zIndex = "0"; 

    setTimeout(() => {
        formulario_register.style.display = "none";
    }, 500);

    contenedor_login_register.style.transform = "translateX(0)";
    caja_trasera_login.style.opacity = "0";
    caja_trasera_register.style.opacity = "1";
}

function register() {
    formulario_register.style.display = "block";
    formulario_register.style.opacity = "1";
    formulario_register.style.zIndex = "1";
    formulario_login.style.opacity = "0";
    formulario_login.style.zIndex = "0"; 

    setTimeout(() => {
        formulario_login.style.display = "none";
    }, 500);

    contenedor_login_register.style.transform = "translateX(400px)";
    caja_trasera_login.style.opacity = "1";
    caja_trasera_register.style.opacity = "0";
}
