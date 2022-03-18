// Variables

const emailHiddenA = document.querySelector('input[value="Es necesario ingresar un Email"]');
const emailHiddenB = document.querySelector('input[value="El Email no es válido"]');
const passwordHidden = document.querySelector('input[value="Es necesario ingresar la Contraseña"]');
const comprobarUsuarioHidden = document.querySelector('input[value="El Usuario no está registrado"]');
const comprobarPassAndConfHidden = document.querySelector('input[value="El Password es incorrecto o la Cuenta aún no está confirmada"]');

const hidden = [
	emailHiddenA, emailHiddenB,
	passwordHidden,
	comprobarUsuarioHidden,
	comprobarPassAndConfHidden
];

const emailInput = document.querySelector('#email');
const passwordInput = document.querySelector('#password');
const descripcion = document.querySelector('.descripcion-pagina');

const ubicacionArray = [
	emailInput.id, emailInput.id,
	passwordInput.id,
	descripcion.classList[0],
	descripcion.classList[0]
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
		case 'descripcion-pagina':
			aviso.classList.add('aviso', 'error');
			descripcion.insertAdjacentElement('afterend', aviso);
			break
		case 'email':
			aviso.classList.add('incorrecto');
			emailInput.parentElement.insertAdjacentElement('afterend', aviso);
			break
		case 'password':
			aviso.classList.add('incorrecto');
			passwordInput.parentElement.insertAdjacentElement('afterend', aviso);
			break
		default:
			break	
	}
}

