(function () {
	obtenerTareas();

	let tareas = [];
	let filtradas = [];

	// Boton para mostrar el modal de agregar tarea
	const nuevaTareaBtn = document.querySelector("#agregar-tarea");
	nuevaTareaBtn.addEventListener("click", function () {
		mostrarFormulario();
	});

	// Filtros de busqueda
	const filtros = document.querySelectorAll('#filtros input[type="radio"]');
	filtros.forEach((radio) => {
		radio.addEventListener("input", filtrarTareas);
	});

	function filtrarTareas(e) {
		const filtro = e.target.value;

		if (filtro !== "") {
			filtradas = tareas.filter((tarea) => tarea.estado === filtro);
		} else {
			filtradas = [];
		}
		mostrarTareas();
	}

	async function obtenerTareas() {
		try {
			const id = obtenerProyecto();
			const url = `/api/tareas?id=${id}`;
			const respuesta = await fetch(url);
			const resultado = await respuesta.json();
			tareas = resultado.tareas;
			mostrarTareas(tareas);
		} catch (error) {
			console.log(error);
		}
	}

	function mostrarTareas() {
		limpiarTareas();
		totalPendiente();
		totalCompletas();
		const arrayTareas = filtradas.length ? filtradas : tareas;
		if (arrayTareas.length === 0) {
			const contenedorTareas = document.querySelector("#listado-tareas");
			const textoNoTareas = document.createElement("li");
			textoNoTareas.textContent = "No hay Tareas";
			textoNoTareas.classList.add("no-tareas");
			contenedorTareas.appendChild(textoNoTareas);
		}
		const estados = {
			0: "Pendiente",
			1: "Completa",
		};

		arrayTareas.forEach((tarea) => {
			const contenedorTarea = document.createElement("li");
			contenedorTarea.dataset.tareaId = tarea.id;
			contenedorTarea.classList.add("tarea");

			const nombreTarea = document.createElement("p");
			nombreTarea.textContent = tarea.nombre;
			nombreTarea.ondblclick = function () {
				mostrarFormulario((editar = true), { ...tarea });
			};

			const opcionesDiv = document.createElement("div");
			opcionesDiv.classList.add("opciones");

			// Botones
			// Btn estado de la tarea
			const btnEstadoTarea = document.createElement("button");
			btnEstadoTarea.classList.add("estado-tarea");
			btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
			btnEstadoTarea.textContent = estados[tarea.estado];
			btnEstadoTarea.dataset.estadoTarea = tarea.estado;
			btnEstadoTarea.ondblclick = function () {
				cambiarEstadoTarea({ ...tarea });
			};

			// Btn eliminar
			const btnEliminarTarea = document.createElement("button");
			btnEliminarTarea.classList.add("eliminar-tareas");
			btnEliminarTarea.dataset.idTarea = tarea.id;
			btnEliminarTarea.textContent = "Eliminar";
			btnEliminarTarea.ondblclick = function () {
				confirmarEliminarTarea(tarea);
			};

			opcionesDiv.appendChild(btnEstadoTarea);
			opcionesDiv.appendChild(btnEliminarTarea);

			contenedorTarea.appendChild(nombreTarea);
			contenedorTarea.appendChild(opcionesDiv);

			const listadoTareas = document.querySelector("#listado-tareas");
			listadoTareas.appendChild(contenedorTarea);
		});
	}

	function totalPendiente() {
		const totalPendientes = tareas.filter((tarea) => tarea.estado === "0");
		const pendinentesRadio = document.querySelector("#pendientes");

		if (totalPendientes.length === 0) {
			pendinentesRadio.disabled = true;
		} else {
			pendinentesRadio.disabled = false;
		}
	}

	function totalCompletas() {
		const totalCompletadas = tareas.filter((tarea) => tarea.estado === "1");
		const completadosRadio = document.querySelector("#completadas");

		if (totalCompletadas.length === 0) {
			completadosRadio.disabled = true;
		} else {
			completadosRadio.disabled = false;
		}
	}

	function mostrarFormulario(editar = false, tarea = {}) {
		const modal = document.createElement("div");
		modal.classList.add("modal");
		modal.innerHTML = `
		<form action="" class="formulario nueva-tarea">
			<legend>${editar ? "Editar Tarea" : "Añade una nueva tarea"}</legend>
			<div class="campo">
				<label for="">Tarea</label>
				<input 
				type="text" 
				name="tarea" 
				id="tarea" 
				placeholder="${tarea.nombre ? "Editar Tarea" : "Añadir Tarea al proyecto Actual"}"  
				value="${tarea.nombre ? tarea.nombre : ""}"/>
			</div>
			<div class="opciones">
				<input 
				type="submit" 
				value="${tarea.nombre ? "Guardar Cambios" : "Añadir Tarea"}" 
				class="submit-nueva-tarea" />
				<button 
				type="button" 
				class="cerrar-modal">Regresar</button>
			</div>
		</form>
		`;
		setTimeout(() => {
			const formulario = document.querySelector(".formulario");
			formulario.classList.add("animar");
		}, 0);

		modal.addEventListener("click", function (e) {
			e.preventDefault();

			if (e.target.classList.contains("cerrar-modal")) {
				const formulario = document.querySelector(".formulario");
				formulario.classList.add("cerrar");
				setTimeout(() => {
					modal.remove();
				}, 500);
			}
			if (e.target.classList.contains("submit-nueva-tarea")) {
				const nombreTarea = document.querySelector("#tarea").value.trim();

				if (nombreTarea === "") {
					// mostrar alerta de error
					mostrarAlerta("El nombre de la tarea es obligatorio", "error", document.querySelector(".formulario legend"));
					return;
				} else if (nombreTarea.length > 60) {
					mostrarAlerta("El nombre de la tarea no puede tener mas de 60 caracteres", "error", document.querySelector(".formulario legend"));
					return;
				}

				if (editar) {
					tarea.nombre = nombreTarea;
					actualizarTarea(tarea);
				} else {
					agregarTarea(nombreTarea);
				}
			}
		});

		document.querySelector(".dashboard").appendChild(modal);
	}

	// Muestra un mensaje en la interfaz
	function mostrarAlerta(mensaje, tipo, referencia) {
		// previene la creacin de multiples alertas
		const alertaPrevia = document.querySelector(".alerta");
		if (alertaPrevia) {
			alertaPrevia.remove();
		}
		const alerta = document.createElement("div");
		alerta.classList.add("alerta", tipo);
		alerta.textContent = mensaje;

		// Inserta la alerta antes del legend
		referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

		// Eliminar la alerta despues de 5 segundos
		setTimeout(() => {
			alerta.remove();
		}, 5000);
	}

	// Consultar el servidor para anadir una nueva tarea al proyecto actual
	async function agregarTarea(tarea) {
		// Construir la peticion
		const datos = new FormData();
		datos.append("nombre", tarea);
		datos.append("proyectoId", obtenerProyecto());

		try {
			const url = "/api/tarea";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			const resultado = await respuesta.json();

			if (resultado.tipo === "exito") {
				const cerrarModalBtn = document.querySelector(".cerrar-modal");
				cerrarModalBtn.click();
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: resultado.mensaje,
					showConfirmButton: false,
					timer: 1500,
					customClass: {
						popup: "swal2-popup",
						title: "swal2-title",
						text: "swal2-text",
					},
				});
				// Agregar el objeto de tarea al global de tareas
				const tareaObj = {
					id: String(resultado.id),
					nombre: tarea,
					estado: "0",
					proyectoId: resultado.proyectoId,
				};
				tareas = [...tareas, tareaObj];
				mostrarTareas();
			}
		} catch (error) {
			console.log(error);
		}
	}

	function cambiarEstadoTarea(tarea) {
		const nuevoEstado = tarea.estado === "1" ? "0" : "1";
		tarea.estado = nuevoEstado;
		actualizarTarea(tarea);
	}

	async function actualizarTarea(tarea) {
		const { estado, id, nombre, proyectoId } = tarea;
		const datos = new FormData();
		datos.append("id", id);
		datos.append("nombre", nombre);
		datos.append("estado", estado);
		datos.append("proyectoId", obtenerProyecto());

		// Comprobar datos del FormData
		// for (let valor of datos.values()) {
		// 	console.log(valor);
		// }

		try {
			const url = "/api/tarea/actualizar";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			const resultado = await respuesta.json();

			if (resultado.respuesta.tipo === "exito") {
				const cerrarModalBtn = document.querySelector(".cerrar-modal");
				if (cerrarModalBtn) {
					cerrarModalBtn.click();
				}
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: resultado.respuesta.mensaje,
					showConfirmButton: false,
					timer: 1500,
					customClass: {
						popup: "swal2-popup",
						title: "swal2-title",
						text: "swal2-text",
					},
				});
			}

			tareas = tareas.map((tareaMemoria) => {
				if (tareaMemoria.id === id) {
					tareaMemoria.estado = estado;
					tareaMemoria.nombre = nombre;
				}
				return tareaMemoria;
			});
			mostrarTareas();
		} catch (error) {
			console.log(error);
		}
	}

	function confirmarEliminarTarea(tarea) {
		Swal.fire({
			title: "¿Eliminar Tarea?",
			text: "¡No podrás revertir esto!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "¡Si, Eliminar!",
			cancelButtonText: "Cancelar",
			customClass: {
				popup: "swal2-popup",
				title: "swal2-title",
				text: "swal2-text",
			},
		}).then((result) => {
			if (result.isConfirmed) {
				eliminarTarea(tarea);
			}
		});
	}

	async function eliminarTarea(tarea) {
		const { estado, id, nombre } = tarea;
		const datos = new FormData();
		datos.append("id", id);
		datos.append("nombre", nombre);
		datos.append("estado", estado);
		datos.append("proyectoId", obtenerProyecto());

		try {
			const url = "/api/tarea/eliminar";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			const resultado = await respuesta.json();

			if (resultado.resultado) {
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: resultado.mensaje,
					showConfirmButton: false,
					timer: 1500,
					customClass: {
						popup: "swal2-popup",
						title: "swal2-title",
						text: "swal2-text",
					},
				});

				tareas = tareas.filter((tareaMemoria) => tareaMemoria.id !== tarea.id);
				mostrarTareas();
			}
		} catch (error) {
			console.log(error);
		}
	}

	function obtenerProyecto() {
		const proyectoParams = new URLSearchParams(window.location.search);

		const proyecto = Object.fromEntries(proyectoParams.entries());
		return proyecto.id;
	}

	function limpiarTareas() {
		const listadoTareas = document.querySelector("#listado-tareas");
		while (listadoTareas.firstChild) {
			listadoTareas.removeChild(listadoTareas.firstChild);
		}
	}
})();
