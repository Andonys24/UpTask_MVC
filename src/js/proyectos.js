(function () {
	obtenerProyecto();

	let proyectos = [];
	let filtradas = [];

	// Boton para mostrar el modal de agregar tarea
	const nuevoProyectoBtn = document.querySelector("#agregar-proyecto");
	nuevoProyectoBtn.addEventListener("click", function () {
		mostrarFormulario();
	});

	// Mostrar el formulario para agregar proyecto
	function mostrarFormulario(editar = false, proyecto = {}) {
		const modal = document.createElement("div");
		modal.classList.add("modal");

		modal.innerHTML = `
		<form action="" class="formulario nuevo-proyecto">
			<legend>${editar ? "Editar Proyecto" : "Añade un nuevo proyecto"}</legend>
			<div class="campo">
				<label for="proyecto">Proyecto</label>
				<input 
				type="text" 
				name="proyecto" 
				id="proyecto" 
				placeholder="${proyecto.proyecto ? "Editar Nombre Proyecto" : "Añadir nuevo Proyecto"}"  
				value="${proyecto.proyecto ? proyecto.proyecto : ""}"/>
			</div>
			<div class="opciones">
				<input 
				type="submit" 
				value="${proyecto.proyecto ? "Guardar Cambios" : "Añadir Proyecto"}" 
				class="submit-nuevo-proyecto" />
				<button 
				type="button" 
				class="cerrar-modal">${proyecto.proyecto ? "Cancelar" : "Regresar"}</button>
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

			if (e.target.classList.contains("submit-nuevo-proyecto")) {
				const nombreProyecto = document.querySelector("#proyecto").value.trim();

				if (nombreProyecto === "") {
					// mostrar alerta de error
					mostrarAlerta("El nombre del proyecto es obligatorio", "error", document.querySelector(".formulario legend"));
					return;
				} else if (nombreProyecto.length > 60) {
					mostrarAlerta(
						"El nombre de el proyecto no puede tener mas de 60 caracteres",
						"error",
						document.querySelector(".formulario legend")
					);
					return;
				} else if (!nombreProyecto.match(/^[a-zA-Z0-9\s\-_.áéíóúÁÉÍÓÚ]+$/)) {
					mostrarAlerta(
						"El nombre del proyecto solo puede contener letras, números, espacios, guiones y guiones bajos",
						"error",
						document.querySelector(".formulario legend")
					);
					return;
				}

				if (editar) {
					proyecto.proyecto = nombreProyecto;
					actualizarProyecto(proyecto);
				} else {
					agregarProyecto(nombreProyecto);
					return;
				}
			}
		});

		document.querySelector(".dashboard").appendChild(modal);
	}

	async function obtenerProyecto() {
		try {
			// const id = obtenerProyecto();
			const url = `/api/proyectos`;
			const respuesta = await fetch(url);
			const resultado = await respuesta.json();
			proyectos = resultado.proyectos;
			mostrarProyectos();
		} catch (error) {
			console.log(error);
		}
	}

	function mostrarProyectos() {
		limpiarProyectos();
		if (proyectos.length === 0) {
			const contendorProyectos = document.querySelector("#listado-proyectos");
			const textoNoProyectos = document.createElement("li");

			textoNoProyectos.textContent = "No hay proyectos";
			textoNoProyectos.classList.add("no-proyectos");

			contendorProyectos.appendChild(textoNoProyectos);
			return;
		}

		proyectos.forEach((proyecto) => {
			const contenedorProyecto = document.createElement("li");
			contenedorProyecto.dataset.proyectoId = proyecto.id;
			contenedorProyecto.classList.add("proyecto-api");

			const nombreProyecto = document.createElement("p");
			nombreProyecto.textContent = proyecto.proyecto;
			nombreProyecto.ondblclick = function () {
				// Redireccionar al proyecto
				window.location.href = `/proyecto?id=${proyecto.url}`;
			};

			const opcionesDiv = document.createElement("div");
			opcionesDiv.classList.add("opciones");

			// Botones
			// Boton de editar
			const btnEditar = document.createElement("button");
			btnEditar.classList.add("editar-proyecto");
			btnEditar.textContent = "Editar";
			btnEditar.dataset.IdProyecto = proyecto.id;
			btnEditar.onclick = function () {
				mostrarFormulario(true, { ...proyecto });
			};

			// Boton de eliminar Proyecto
			const btnEliminar = document.createElement("button");
			btnEliminar.classList.add("eliminar-proyecto");
			btnEliminar.dataset.IdProyecto = proyecto.id;
			btnEliminar.textContent = "Eliminar";
			btnEliminar.onclick = function () {
				confirmarEliminarProyecto(proyecto);
			};

			opcionesDiv.appendChild(btnEditar);
			opcionesDiv.appendChild(btnEliminar);

			contenedorProyecto.appendChild(nombreProyecto);
			contenedorProyecto.appendChild(opcionesDiv);

			const listadoTareas = document.querySelector("#listado-proyectos");
			listadoTareas.appendChild(contenedorProyecto);
		});
	}

	function confirmarEliminarProyecto(proyecto) {
		Swal.fire({
			title: "¿Eliminar Proyecto?",
			text: "¡No podrás revertir esto, se perdera todo su contenido!",
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
				eliminarProyecto(proyecto);
			}
		});
	}

	async function eliminarProyecto(proyecto_) {
		const { id, propietarioId, proyecto, url } = proyecto_;
		const datos = new FormData();
		datos.append("id", id);
		datos.append("propietarioId", propietarioId);
		datos.append("proyecto", proyecto);
		datos.append("url", url);

		try {
			const url = "/api/proyecto/eliminar";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			if (respuesta.status === 401) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "¡Algo salió mal!",
				});
				return;
			}

			resultado = await respuesta.json();
			console.log(resultado);
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
			}

			proyectos = proyectos.filter((proyectoMemoria) => proyectoMemoria.id !== proyecto_.id);
			mostrarProyectos();
		} catch (error) {
			console.log(error);
		}
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
	async function agregarProyecto(proyecto) {
		const datos = new FormData();
		datos.append("proyecto", proyecto);
		try {
			const url = "/api/proyecto";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});

			const resultado = await respuesta.json();

			if (resultado.tipo === "error") {
				mostrarAlerta(resultado.mensaje, "error", document.querySelector(".formulario legend"));
				return;
			}

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
			}

			// Agregar el objeto de tarea al global de tareas
			const proyectoObj = {
				id: String(resultado.id),
				proyecto: proyecto,
				url: resultado.url,
				propietarioId: resultado.propietarioId,
			};
			proyectos = [...proyectos, proyectoObj];

			mostrarProyectos();
		} catch (error) {
			console.log(error);
		}
	}

	async function actualizarProyecto(proyecto_) {
		const { id, proyecto, propietarioId, url } = proyecto_;
		const datos = new FormData();
		datos.append("id", id);
		datos.append("proyecto", proyecto);
		datos.append("propietarioId", propietarioId);
		datos.append("url", url);

		try {
			const url = "/api/proyecto/actualizar";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});

			const resultado = await respuesta.json();
			console.log(resultado);
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

			proyectos = proyectos.map((proyectoMemoria) => {
				if (proyectoMemoria.id === id) {
					proyectoMemoria.proyecto = proyecto;
				}
				return proyectoMemoria;
			});

			mostrarProyectos();
		} catch (error) {
			console.log(error);
		}
	}

	function limpiarProyectos() {
		const listadoProyectos = document.querySelector("#listado-proyectos");
		while (listadoProyectos.firstChild) {
			listadoProyectos.removeChild(listadoProyectos.firstChild);
		}
	}
})();
