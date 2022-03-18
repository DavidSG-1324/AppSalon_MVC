// Variables

const fechaInput = document.querySelector('#fecha');
const aviso = document.querySelector('.correcto');
const btnsEliminar = document.querySelectorAll('input[value="Eliminar"]');

// Iniciar

window.onload = function() {
	iniciarApp();
}

function iniciarApp() {
	seleccionarFecha();

	quitarAvisoCorrecto();

	eventListeners();
}

// Funciones
function seleccionarFecha() {
	fechaInput.addEventListener('input', evento => {
		const fecha = evento.target.value;

		window.location = `?fecha=${fecha}`;
	});
}

function quitarAvisoCorrecto() {
	if(aviso) {
		const contenedorAviso = aviso.parentElement;
		setTimeout(() => {
			contenedorAviso.removeChild(aviso);
		}, 3000);
	}
}

function eventListeners() {
	btnsEliminar.forEach(btnEliminar => {
		btnEliminar.addEventListener('click', evento => {
			const paramClick = document.querySelector('input[data-click="true"]');

			if(!paramClick) {
				evento.preventDefault();
				
				popUp(evento);
			}
		});
	});
}

function popUp(evento) {
	Swal.fire({
		icon: 'warning',
		title: '¿Quieres eliminar la cita?',
		text: "Esta acción no se puede revertir",
		confirmButtonColor: '#3085D6',
		confirmButtonText: 'Sí, Eliminar',
		showCancelButton: true,
		cancelButtonColor: '#D33',
		cancelButtonText: 'No, Cancelar'

	}).then((result) => {
	    if(result.isConfirmed) {
	    	evento.target.dataset.click = 'true';
	    	evento.target.click();
		}
	})
}

