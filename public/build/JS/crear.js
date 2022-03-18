// Variables

const nombreHiddenA = document.querySelector('input[value="Es necesario ingresar un Nombre de Servicio"]');
const nombreHiddenB = document.querySelector('input[value="Nombre no válido"]');
const precioHiddenA = document.querySelector('input[value="Es necesario ingresar un Precio"]');
const precioHiddenB = document.querySelector('input[value="Precio no válido"]');

const hidden = [
	nombreHiddenA, nombreHiddenB,
	precioHiddenA, precioHiddenB
];

const nombreInput = document.querySelector('#nombre');
const precioInput = document.querySelector('#precio');

const ubicacionArray = [
	nombreInput.id, nombreInput.id,
	precioInput.id, precioInput.id
];

// Iniciar

window.onload = function() {
	iniciar();
}

function iniciar() {
	identificarMensajes();
}

// Funciones
function identificarMensajes() {
	let mensaje;

	for(let i = 0; i < hidden.length; i++) {
		if(hidden[i]) {
			mensaje = hidden[i].value;
			mostrarAviso(mensaje, ubicacionArray[i]);
		}
	}
}

function mostrarAviso(mensaje, ubicacion) {
	const aviso = document.createElement('P');
	aviso.textContent = mensaje;
	
	switch(ubicacion) {
		case 'nombre':
			aviso.classList.add('incorrecto');
			nombreInput.parentElement.insertAdjacentElement('afterend', aviso);
			break
		case 'precio':
			aviso.classList.add('incorrecto');
			precioInput.parentElement.insertAdjacentElement('afterend', aviso);
			break
		default:
			break	
	}
}

