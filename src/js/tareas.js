(function () {
	// Boton para mostrar el modal de agregar tarea
	const nuevaTareaBtn = document.querySelector("#agregar-tarea");
	nuevaTareaBtn.addEventListener("click", mostrarFormulario);

	function mostrarFormulario() {
		const modal = document.createElement("div");
		modal.classList.add("modal");
		modal.innerHTML = `
		<form action="" class="formulario nueva-tarea">
			<legend>Añade una nueva tarea</legend>
			<div class="campo">
				<label for="">Tarea</label>
				<input type="text" name="tarea" id="tarea" placeholder="Añadir Tarea al proyecto Actual" />
			</div>
			<div class="opciones">
				<input type="submit" value="Añadir Tarea" class="submit-nueva-tarea" />
				<button type="button" class="cerrar-modal">Regresar</button>
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
				submitFormularioNuevaTarea();
			}
		});

		document.querySelector(".dashboard").appendChild(modal);
	}

	function submitFormularioNuevaTarea() {
		const tarea = document.querySelector("#tarea").value.trim();

		if (tarea === "") {
			// mostrar alerta de error
			mostrarAlerta("El nombre de la tarea es obligatorio", "error", document.querySelector(".formulario legend"));
		} else if (tarea.length > 60) {
			mostrarAlerta("El nombre de la tarea no puede tener mas de 60 caracteres", "error", document.querySelector(".formulario legend"));
		} else {
			agregarTarea(tarea);
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

			mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector(".formulario legend"));

			if (resultado.tipo === "exito") {
				const nuevaTareaBtn = document.querySelector(".submit-nueva-tarea");
				const cerrarModalBtn = document.querySelector(".cerrar-modal");
				nuevaTareaBtn.classList.add("ocultar");
				setTimeout(() => {
					cerrarModalBtn.click();
				}, 2000);
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
})();
