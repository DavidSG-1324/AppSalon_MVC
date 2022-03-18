// Variables

const confirmadaHidden = document.querySelector('input[value="Cuenta confirmada"]');
const tokenHidden = document.querySelector('input[value="Token no válido"]');

const hidden = [
	confirmadaHidden,
	tokenHidden
];

const nombre = document.querySelector('.nombre-pagina');

ubicacionArray = [
	nombre.classList[0],
	nombre.classList[0],
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
		case 'nombre-pagina':
			if(confirmadaHidden) {
				aviso.classList.add('aviso', 'correcto');		
			} else if(tokenHidden) {
				aviso.classList.add('aviso', 'error');
			}
			nombre.insertAdjacentElement('afterend', aviso);
			break
		default:
			break	
	}
}

