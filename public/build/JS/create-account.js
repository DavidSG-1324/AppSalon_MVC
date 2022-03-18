// Variables

const nombreHiddenA = document.querySelector('input[value="Es necesario ingresar un Nombre"]');
const nombreHiddenB = document.querySelector('input[value="Nombre no válido"]');
const apellidoHiddenA = document.querySelector('input[value="Es necesario ingresar un Apellido"]');
const apellidoHiddenB = document.querySelector('input[value="Apellido no válido"]');
const telefonoHiddenA = document.querySelector('input[value="El Número de Teléfono no se ha ingresado"]');
const telefonoHiddenB = document.querySelector('input[value="El Número de Teléfono debe tener 10 dígitos"]');
const emailHiddenA = document.querySelector('input[value="Es necesario agregar un Email"]');
const emailHiddenB = document.querySelector('input[value="El Email no es válido"]');
const passwordHiddenA = document.querySelector('input[value="Es necesario agregar una Contraseña"]');
const passwordHiddenB = document.querySelector('input[value="La Contraseña debe ser de al menos 8 caracteres"]');
const comprobarUsuarioHidden = document.querySelector('input[value="El Usuario ya está registrado"]');

const hidden = [
	nombreHiddenA, nombreHiddenB,
	apellidoHiddenA, apellidoHiddenB,
	telefonoHiddenA, telefonoHiddenB,
	emailHiddenA, emailHiddenB,
	passwordHiddenA, passwordHiddenB,
	comprobarUsuarioHidden
];

const nombreInput = document.querySelector('#nombre');
const apellidoInput = document.querySelector('#apellido');
const telefonoInput = document.querySelector('#telefono');
const emailInput = document.querySelector('#email');
const passwordInput = document.querySelector('#password');
const descripcion = document.querySelector('.descripcion-pagina');

const ubicacionArray = [
	nombreInput.id,	nombreInput.id,
	apellidoInput.id, apellidoInput.id,
	telefonoInput.id, telefonoInput.id,
	emailInput.id, emailInput.id,
	passwordInput.id, passwordInput.id,
	descripcion.classList[0]
];

// Iniciar

window.onload = function() {
	iniciar();
}

function iniciar() {
	identificarMensajesB();
}

// Funciones
function identificarMensajesB() {
	let mensaje;

	for(let i = 0; i < hidden.length; i++) {
		if(hidden[i]) {
			mensaje = hidden[i].value;
			mostrarAviso(mensaje, ubicacionArray[i]);
		}
	}
}

function identificarMensajes() {
	let mensaje;

	if(nombreHiddenA || nombreHiddenB) {
		if(nombreHiddenA) {
			mensaje = nombreHiddenA.value;
		}
		if(nombreHiddenB) {
			mensaje = nombreHiddenB.value;
		}
		mostrarAviso(mensaje, 'nombre');
	}

	if(apellidoHiddenA || apellidoHiddenB) {
		if(apellidoHiddenA) {
			mensaje = apellidoHiddenA.value;
		}
		if(apellidoHiddenB) {
			mensaje = apellidoHiddenB.value;
		}
		mostrarAviso(mensaje, 'apellido');
	}

	if(telefonoHiddenA || telefonoHiddenB) {
		if(telefonoHiddenA) {
			mensaje = telefonoHiddenA.value;
		}
		if(telefonoHiddenB) {
			mensaje = telefonoHiddenB.value;
		}
		mostrarAviso(mensaje, 'telefono');
	}

	if(emailHiddenA || emailHiddenB) {
		if(emailHiddenA) {
			mensaje = emailHiddenA.value;
		}
		if(emailHiddenB) {
			mensaje = emailHiddenB.value;
		}
		mostrarAviso(mensaje, 'email');
	}

	if(passwordHiddenA || passwordHiddenB) {
		if(passwordHiddenA) {
			mensaje = passwordHiddenA.value;
		}
		if(passwordHiddenB) {
			mensaje = passwordHiddenB.value;
		}
		mostrarAviso(mensaje, 'password');
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
		case 'nombre':
			aviso.classList.add('incorrecto');
			nombreInput.parentElement.insertAdjacentElement('afterend', aviso);
			break			
		case 'apellido':
			aviso.classList.add('incorrecto');
			apellidoInput.parentElement.insertAdjacentElement('afterend', aviso);
			break
		case 'telefono':
			aviso.classList.add('incorrecto');
			telefonoInput.parentElement.insertAdjacentElement('afterend', aviso);
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

