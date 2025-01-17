const mobileMenuBtn = document.querySelector("#mobile-menu");
const sidebar = document.querySelector(".sidebar");
const cerrarMenuBtn = document.querySelector("#cerrar-menu");

if (mobileMenuBtn) {
	mobileMenuBtn.addEventListener("click", function () {
		sidebar.classList.add("mostrar");
	});
}
if (cerrarMenuBtn) {
	cerrarMenuBtn.addEventListener("click", function () {
		sidebar.classList.add("ocultar");
		setTimeout(() => {
			sidebar.classList.remove("mostrar");
			sidebar.classList.remove("ocultar");
		}, 500);
	});
}

// Elimina la clase de mostrar en un tamano de tablet o mayor
window.addEventListener("resize", function () {
	const anchoPantalla = document.body.clientHeight;
	if (anchoPantalla >= 768) {
		sidebar.classList.remove("mostrar");
	}
});
