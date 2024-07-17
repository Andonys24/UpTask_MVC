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
				<button type="button" class="cerrar-modal">Cancelar</button>
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
		});

		document.querySelector("body").appendChild(modal);
	}
})();
