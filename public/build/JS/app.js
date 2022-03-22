// Variables

let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const btnAnterior = document.querySelector('#anterior');
const btnSiguiente = document.querySelector('#siguiente');

const cita = {
	usuarioId: '',
	nombre: '',
	nombreApellido: '',
	fecha: '',
	hora: '',
	servicios: []
}

const formulario = document.querySelector('.formulario');
const fechaInput = document.querySelector('#fecha');
const horaInput = document.querySelector('#hora');
const resumen = document.querySelector('.contenido-resumen');

let fechaFormateada;

horaInput.step = '600';

// Iniciar

window.onload = function() {
	iniciarApp();	
}

function iniciarApp() {

	// Cambia la Sección
	cambiarSeccion();

	// Resalta el Tab correspondiente a la Sección actual y la muestra
	mostrarSeccion();

	// Seccion anterior
	paginaAnterior();

	// Seccion siguiente
	paginaSiguiente();

	// Agrega o quita los botones del paginador
	botonesPaginador();

	// Consulta la API en el backend de PHP
	consultarAPI();

	// Almacena el id en el Objeto Cita
	idCliente();

	// Almacena el nombre en el Objeto Cita
	nombreCliente();

	// Almacena la fecha en el Objeto Cita
	seleccionarFecha();

	// Almacena la hora en el Objeto Cita
	seleccionarHora();

	// Muestra el resumen de la cita o un mensaje de error
	mostrarResumen();	
}

// Funciones

function cambiarSeccion() {
	const botones = document.querySelectorAll('.tabs button');

	botones.forEach(boton => {
		boton.addEventListener('click', evento => {
			paso = parseInt(evento.target.dataset.paso);
			mostrarSeccion();
		});
	});
}

function mostrarSeccion() {

	// Quitar y agregar "actual" a los Tabs correspondientes
	const tabInicial = document.querySelector('.tabs .actual');
	if(tabInicial) {
		tabInicial.classList.remove('actual');	
	}

	const tabFinal = document.querySelector(`[data-paso="${paso}"]`);
	tabFinal.classList.add('actual');

	// Quitar y agregar "mostrar" a las Secciones
	const seccionInicial = document.querySelector('.mostrar');
	if(seccionInicial) {
		seccionInicial.classList.remove('mostrar');
	}

	const seccionFinal = document.querySelector(`#paso-${paso}`);
	seccionFinal.classList.add('mostrar');

	botonesPaginador();
}

function paginaAnterior() {
	btnAnterior.addEventListener('click', () => {

		if(paso == pasoInicial) {
			return;
		}

		paso--;
		mostrarSeccion();
	});
}

function paginaSiguiente() {
	btnSiguiente.addEventListener('click', () => {

		if(paso == pasoFinal) return;

		paso++;
		mostrarSeccion();
	});
}

function botonesPaginador() {
	if(paso === 1) {
		btnAnterior.classList.add('ocultar');
		btnSiguiente.classList.remove('ocultar');
	} else if(paso === 3) {
		btnAnterior.classList.remove('ocultar');
		btnSiguiente.classList.add('ocultar');
		mostrarResumen();
	} else {
		btnAnterior.classList.remove('ocultar');
		btnSiguiente.classList.remove('ocultar');
	}
}

async function consultarAPI() {
	try {
		const url = 'http://localhost:5000/API/servicios';
		const resultado = await fetch(url);
		const servicios = await resultado.json();

		mostrarServicios(servicios);

	} catch(error) {
		console.log(error);
	}
}

function mostrarServicios(servicios) {
	
	// Generar el HTML
	servicios.forEach(servicio => {
		const {id, nombre, precio} = servicio;

		// Generar DIV contenedor de servicio
		const divServicio = document.createElement('DIV');
		divServicio.classList.add('servicio');
		divServicio.dataset.idServicio = id;
		divServicio.onclick = function() {
			seleccionarServicio(servicio);
		};

		// Generar nombre de servicio
		const nombreServicio = document.createElement('P');
		nombreServicio.textContent = nombre;
		nombreServicio.classList.add('nombre-servicio');

		// Generar precio de servicio
		const precioServicio = document.createElement('P');
		precioServicio.textContent = `$ ${precio}`;
		precioServicio.classList.add('precio-servicio');

		// Agregar precio y nombre a DIV de servicio
		divServicio.appendChild(nombreServicio);
		divServicio.appendChild(precioServicio);

		const listado = document.querySelector('#servicios');
		listado.appendChild(divServicio);
	});
}

function seleccionarServicio(servicio) {
	const {id} = servicio;
	const {servicios} = cita;
	const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

	// Comprobar si un servicio ya fue agregado
	if(servicios.some(agregado => agregado.id === id)) {
		divServicio.classList.remove('seleccionado');
		quitarServicio(servicios, id);

	} else {
		divServicio.classList.add('seleccionado');
		agregarServicio(servicios, servicio);
	}
}

function agregarServicio(servicios, servicio) {
	cita.servicios = [...servicios, servicio];
}

function quitarServicio(servicios, id) {
	cita.servicios = servicios.filter(agregado => agregado.id !== id );
}

function idCliente() {
	const id = document.querySelector('#id').value;
	cita.usuarioId = id;
}

function nombreCliente() {
	const nombre = document.querySelector('.barra span').textContent;
	cita.nombre = nombre;

	const nombreApellido = document.querySelector('#nombre').value;
	cita.nombreApellido = nombreApellido;
}

function seleccionarFecha() {
	fechaInput.addEventListener('input', evento => {
		const dia = new Date(evento.target.value).getUTCDay();

		if([0, 6].includes(dia)) {
			mostrarAviso('Los Fines de Semana no Trabajamos', 'error', 'fecha');
			fechaInput.value = '';
			cita.fecha = '';

		} else {
			mostrarAviso('Día seleccionado', 'correcto', 'general', 'fecha');
			cita.fecha = fechaInput.value;
		}		
	});
}

function seleccionarHora() {
	horaInput.addEventListener('input', evento => {
		const hora = evento.target.value.split(':');

		if(hora[0] < 10 || hora[0] >= 18) {
			mostrarAviso('Cerrado, trabajamos de 10:00 a.m. a 06:00 p.m.', 'error', 'hora');
			horaInput.value = '';
			cita.hora = '';

		} else {
			mostrarAviso('Horario seleccionado', 'correcto', 'general', 'hora');
			cita.hora = horaInput.value;
		}
	});
}

function mostrarAviso(mensaje, tipo, ubicacion, aux = '') {
	const avisoPrevioFecha = document.querySelector('.fecha');
	if(avisoPrevioFecha) {
		if(ubicacion === 'fecha' || (tipo === 'correcto' && aux === 'fecha')) {
			avisoPrevioFecha.remove();
		}
	}

	const avisoPrevioHora = document.querySelector('.hora');
	if(avisoPrevioHora) {
		if(ubicacion === 'hora' || (tipo === 'correcto' && aux === 'hora')) {
			avisoPrevioHora.remove();
		}
	}

	const avisoCorrecto = document.querySelector('p.aviso.correcto');
	if(avisoCorrecto) {
		avisoCorrecto.remove();
	}

	const avisoPrevioResumen = document.querySelector('.resumen');
	if(avisoPrevioResumen) {
		avisoPrevioResumen.remove();
	}

	const aviso = document.createElement('P');
	aviso.textContent = mensaje;
	aviso.classList.add('aviso', `${tipo}`, `${ubicacion}`);

	switch(ubicacion) {
		case 'general':
			formulario.appendChild(aviso);
			break
		case 'fecha':
			fechaInput.parentElement.insertAdjacentElement('afterend', aviso);
			break
		case 'hora':
			horaInput.parentElement.insertAdjacentElement('afterend', aviso);
			break
		case 'resumen':
			resumen.appendChild(aviso);
			break
		default:
			break
	}

	if(tipo === 'correcto') {
		setTimeout(() => {
			aviso.remove();
		}, 3000);
	}
}

function mostrarResumen() {
	const header = document.querySelector('.contenido-resumen h2');
	const parrafo = document.querySelector('.contenido-resumen .descripcion-paso');

	// Validación de Objeto
	if(Object.values(cita).includes('') || cita.servicios.length === 0) {
		mostrarAviso('Faltan datos por completar o no seleccionaste ningún servicio', 'error', 'resumen');
		header.style.display = 'none';
		parrafo.style.display = 'none';
		
		return;
	}

	header.style.display = 'block';
	parrafo.style.display = 'block';

	// Eliminar el HTML previo
	while(parrafo.nextElementSibling) {
		parrafo.nextElementSibling.remove();
	}

	// Generar el HTML
	const {nombreApellido, fecha, hora, servicios} = cita;

	const divCita = document.createElement('DIV');

	//								Información Cita
	const headingCita = document.createElement('H3');
	headingCita.textContent = 'Tus Datos y Cita';

	const nombreCita = document.createElement('P');
	nombreCita.innerHTML = `<span>Nombre:</span> ${nombreApellido}`;	

	const fechaCita = document.createElement('P');
	const fechaObj = new Date(fecha);
	const dia = fechaObj.getDate() + 2;
	const mes = fechaObj.getMonth();
	const year = fechaObj.getFullYear();
	const fechaCorrecta = new Date(Date.UTC(year, mes, dia));
	const opciones = {weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'};
	fechaFormateada = fechaCorrecta.toLocaleDateString('es-MX', opciones);
	fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

	const horaCita = document.createElement('P');
	const horaOrdenActual = hora.split(':');
	let horaOrdenNuevo;
	if(horaOrdenActual[0] < 12) {
		horaOrdenNuevo = `${horaOrdenActual[0]}:${horaOrdenActual[1]} a.m.`;
	} else if(horaOrdenActual[0] === '12') {
		horaOrdenNuevo = `${horaOrdenActual[0]}:${horaOrdenActual[1]} p.m.`;
	}
	 else {
		horaOrdenNuevo = `${horaOrdenActual[0]-12}:${horaOrdenActual[1]} p.m.`;
	}
	horaCita.innerHTML = `<span>Hora:</span> ${horaOrdenNuevo}`;

	divCita.appendChild(headingCita);
	divCita.appendChild(nombreCita);
	divCita.appendChild(fechaCita);
	divCita.appendChild(horaCita);

	//								Servicios
	const headingServicios = document.createElement('H3');
	headingServicios.textContent = 'Servicios solicitados';

	divCita.appendChild(headingServicios);

	let total = 0;
	servicios.forEach(servicio => {
		const {nombre, precio} = servicio;

		const contenedorServicio = document.createElement('DIV');
		contenedorServicio.classList.add('contenedor-servicio');

		const textoServicio = document.createElement('P');
		textoServicio.textContent = nombre;

		const precioServicio = document.createElement('P');
		precioServicio.innerHTML = `<span>Precio:</span> $ ${precio}`;

		contenedorServicio.appendChild(textoServicio);
		contenedorServicio.appendChild(precioServicio);

		divCita.appendChild(contenedorServicio);

		const cantidadServicio = parseInt(precio);

		total += cantidadServicio;
	});

	const divTotalBoton = document.createElement('DIV');
	divTotalBoton.classList.add('izquierda-derecha');

	//								Total
	const cantidadPagar = document.createElement('P');
	cantidadPagar.innerHTML = `<span>Total:</span> $ ${total}`;

	divTotalBoton.appendChild(cantidadPagar);

	//								Botón
	const btnReservar = document.createElement('BUTTON');
	btnReservar.textContent = 'Reservar Cita';
	btnReservar.classList.add('boton');
	btnReservar.onclick = reservarCita;

	divTotalBoton.appendChild(btnReservar);

	divCita.appendChild(divTotalBoton);

	resumen.appendChild(divCita);
}

async function reservarCita() {
	const {usuarioId, nombre, fecha, hora, servicios} = cita;
	const serviciosId = servicios.map(servicio => servicio.id);

	const datos = new FormData();
	datos.append('fecha', fecha);
	datos.append('hora', hora);
	datos.append('usuarioId', usuarioId);
	datos.append('serviciosId', serviciosId);

	// console.log([...datos]);

	try {
		// Petición hacia la API
		const url = 'http://localhost:5000/API/citas';
		const resultado = await fetch(url, {
			method: 'POST',
			body: datos
		});
		const respuesta = await resultado.json();

		if(respuesta.insercion) {
			Swal.fire({
				icon: 'success',
				title: 'Cita Creada',
				text: `${nombre} tu cita es el ${fechaFormateada}`,
				confirmButtonText: 'OK'

			}).then(() => {
				window.location.reload();
			})
		}

	} catch(error) {
		Swal.fire({
			icon: 'error',
			title: 'Error',
			text0: 'La cita no pudo ser creada'
			
		}).then(() => {
			window.location.reload();
		})
	}
}

