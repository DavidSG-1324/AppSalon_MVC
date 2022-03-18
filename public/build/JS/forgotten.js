// Variables

const emailHiddenA = document.querySelector('input[value="Es necesario agregar un Email"]');
const emailHiddenB = document.querySelector('input[value="El Email no es válido"]');
const comprobarUsuarioHidden = document.querySelector('input[value="El Usuario no está registrado"]');
const instruccionesHidden = document.querySelector('input[value="Hemos enviado las instrucciones de recuperación de Cuenta a tu email"]');

let hidden;

const emailInput = document.querySelector('#email');
const descripcion = document.querySelector('.descripcion-pagina');
const nombre = document.querySelector('.nombre-pagina');

let ubicacionArray;

if(emailInput) {
	hidden = [
		emailHiddenA, emailHiddenB,
		comprobarUsuarioHidden
	];

	ubicacionArray = [
		emailInput.id, emailInput.id,
		descripcion.classList[0]
	];
	
} else {
	hidden = [
		instruccionesHidden
	];

	ubicacionArray = [
		nombre.classList[0]
	];
}

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
		case 'nombre-pagina':
			aviso.classList.add('aviso', 'correcto');
			nombre.insertAdjacentElement('afterend', aviso);
			break
		case 'descripcion-pagina':
			aviso.classList.add('aviso', 'error');
			descripcion.insertAdjacentElement('afterend', aviso);
			break
		case 'email':
			aviso.classList.add('incorrecto');
			emailInput.parentElement.insertAdjacentElement('afterend', aviso);
			break
		default:
			break	
	}
}

