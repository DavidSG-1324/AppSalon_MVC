// Variables

const passwordHiddenA = document.querySelector('input[value="Es necesario agregar una Contraseña"]');
const passwordHiddenB = document.querySelector('input[value="La Contraseña debe ser de al menos 8 caracteres"]');
const iniciarHidden = document.querySelector('input[value="Ahora puedes iniciar Sesión con tu Nueva Contraseña"]');
const tokenHidden = document.querySelector('input[value="Token no válido"]');

let hidden;

const passwordInput = document.querySelector('#password');
const nombre = document.querySelector('.nombre-pagina');

let ubicacionArray;

if(passwordInput) {
	hidden = [
		passwordHiddenA, passwordHiddenB,
	];

	ubicacionArray = [
		passwordInput.id, passwordInput.id,
	];

} else {
	hidden = [
		iniciarHidden,
		tokenHidden
	];

	ubicacionArray = [
		nombre.classList[0],
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
			if(iniciarHidden) {
				aviso.classList.add('aviso', 'correcto');		
			} else if(tokenHidden) {
				aviso.classList.add('aviso', 'error');
			}
			nombre.insertAdjacentElement('afterend', aviso);
			break
		case 'password':
			aviso.classList.add('incorrecto');
			passwordInput.parentElement.insertAdjacentElement('afterend', aviso);
			break
		default:
			break	
	}
}

