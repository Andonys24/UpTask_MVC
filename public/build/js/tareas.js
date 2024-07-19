!function(){!async function(){try{const a=`/api/tareas?id=${o()}`,n=await fetch(a),r=await n.json();t=r.tareas,e()}catch(t){console.log(t)}}();let t=[];function e(){if(function(){const t=document.querySelector("#listado-tareas");for(;t.firstChild;)t.removeChild(t.firstChild)}(),0===t.length){const t=document.querySelector("#listado-tareas"),e=document.createElement("li");e.textContent="No hay Tareas",e.classList.add("no-tareas"),t.appendChild(e)}const n={0:"Pendiente",1:"Completa"};t.forEach((r=>{const c=document.createElement("li");c.dataset.tareaId=r.id,c.classList.add("tarea");const s=document.createElement("p");s.textContent=r.nombre;const i=document.createElement("div");i.classList.add("opciones");const d=document.createElement("button");d.classList.add("estado-tarea"),d.classList.add(`${n[r.estado].toLowerCase()}`),d.textContent=n[r.estado],d.dataset.estadoTarea=r.estado,d.ondblclick=function(){!function(n){const r="1"===n.estado?"0":"1";n.estado=r,async function(n){const{estado:r,id:c,nombre:s,proyectoId:i}=n,d=new FormData;d.append("id",c),d.append("nombre",s),d.append("estado",r),d.append("proyectoId",o());try{const o="/api/tarea/actualizar",n=await fetch(o,{method:"POST",body:d}),s=await n.json();"exito"===s.respuesta.tipo&&a(s.respuesta.mensaje,s.respuesta.tipo,document.querySelector(".contenedor-nueva-tarea")),t=t.map((t=>(t.id===c&&(t.estado=r),t))),e()}catch(t){console.log(t)}}(n)}({...r})};const l=document.createElement("button");l.classList.add("eliminar-tareas"),l.dataset.idTarea=r.id,l.textContent="Eliminar",l.ondblclick=function(){!function(a){Swal.fire({title:"¿Eliminar Tarea?",text:"¡No podrás revertir esto!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"¡Si, Eliminar!",cancelButtonText:"Cancelar",customClass:{popup:"swal2-popup",title:"swal2-title",text:"swal2-text"}}).then((n=>{n.isConfirmed&&async function(a){const{estado:n,id:r,nombre:c}=a,s=new FormData;s.append("id",r),s.append("nombre",c),s.append("estado",n),s.append("proyectoId",o());try{const o="/api/tarea/eliminar",n=await fetch(o,{method:"POST",body:s}),r=await n.json();r.resultado&&(Swal.fire({title:"Accion Completada!",text:r.mensaje,icon:"success",customClass:{popup:"swal2-popup",title:"swal2-title",text:"swal2-text"}}),t=t.filter((t=>t.id!==a.id)),e())}catch(t){console.log(t)}}(a)}))}(r)},i.appendChild(d),i.appendChild(l),c.appendChild(s),c.appendChild(i);document.querySelector("#listado-tareas").appendChild(c)}))}function a(t,e,a){const o=document.querySelector(".alerta");o&&o.remove();const n=document.createElement("div");n.classList.add("alerta",e),n.textContent=t,a.parentElement.insertBefore(n,a.nextElementSibling),setTimeout((()=>{n.remove()}),5e3)}function o(){const t=new URLSearchParams(window.location.search);return Object.fromEntries(t.entries()).id}document.querySelector("#agregar-tarea").addEventListener("click",(function(){const n=document.createElement("div");n.classList.add("modal"),n.innerHTML='\n\t\t<form action="" class="formulario nueva-tarea">\n\t\t\t<legend>Añade una nueva tarea</legend>\n\t\t\t<div class="campo">\n\t\t\t\t<label for="">Tarea</label>\n\t\t\t\t<input type="text" name="tarea" id="tarea" placeholder="Añadir Tarea al proyecto Actual" />\n\t\t\t</div>\n\t\t\t<div class="opciones">\n\t\t\t\t<input type="submit" value="Añadir Tarea" class="submit-nueva-tarea" />\n\t\t\t\t<button type="button" class="cerrar-modal">Regresar</button>\n\t\t\t</div>\n\t\t</form>\n\t\t',setTimeout((()=>{document.querySelector(".formulario").classList.add("animar")}),0),n.addEventListener("click",(function(r){if(r.preventDefault(),r.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout((()=>{n.remove()}),500)}r.target.classList.contains("submit-nueva-tarea")&&function(){const n=document.querySelector("#tarea").value.trim();""===n?a("El nombre de la tarea es obligatorio","error",document.querySelector(".formulario legend")):n.length>60?a("El nombre de la tarea no puede tener mas de 60 caracteres","error",document.querySelector(".formulario legend")):async function(n){const r=new FormData;r.append("nombre",n),r.append("proyectoId",o());try{const o="/api/tarea",c=await fetch(o,{method:"POST",body:r}),s=await c.json();if(a(s.mensaje,s.tipo,document.querySelector(".formulario legend")),"exito"===s.tipo){const a=document.querySelector(".submit-nueva-tarea"),o=document.querySelector(".cerrar-modal");a.classList.add("ocultar"),setTimeout((()=>{o.click()}),2e3);const r={id:String(s.id),nombre:n,estado:"0",proyectoId:s.proyectoId};t=[...t,r],e()}}catch(t){console.log(t)}}(n)}()})),document.querySelector(".dashboard").appendChild(n)}))}();