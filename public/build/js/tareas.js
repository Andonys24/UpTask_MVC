!function(){!async function(){try{const a=`/api/tareas?id=${r()}`,o=await fetch(a),n=await o.json();t=n.tareas,e()}catch(t){console.log(t)}}();let t=[];function e(){if(function(){const t=document.querySelector("#listado-tareas");for(;t.firstChild;)t.removeChild(t.firstChild)}(),0===t.length){const t=document.querySelector("#listado-tareas"),e=document.createElement("li");e.textContent="No hay Tareas",e.classList.add("no-tareas"),t.appendChild(e)}const o={0:"Pendiente",1:"Completa"};t.forEach((i=>{const s=document.createElement("li");s.dataset.tareaId=i.id,s.classList.add("tarea");const c=document.createElement("p");c.textContent=i.nombre,c.ondblclick=function(){a(editar=!0,{...i})};const d=document.createElement("div");d.classList.add("opciones");const l=document.createElement("button");l.classList.add("estado-tarea"),l.classList.add(`${o[i.estado].toLowerCase()}`),l.textContent=o[i.estado],l.dataset.estadoTarea=i.estado,l.ondblclick=function(){!function(t){const e="1"===t.estado?"0":"1";t.estado=e,n(t)}({...i})};const u=document.createElement("button");u.classList.add("eliminar-tareas"),u.dataset.idTarea=i.id,u.textContent="Eliminar",u.ondblclick=function(){!function(a){Swal.fire({title:"¿Eliminar Tarea?",text:"¡No podrás revertir esto!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"¡Si, Eliminar!",cancelButtonText:"Cancelar",customClass:{popup:"swal2-popup",title:"swal2-title",text:"swal2-text"}}).then((o=>{o.isConfirmed&&async function(a){const{estado:o,id:n,nombre:i}=a,s=new FormData;s.append("id",n),s.append("nombre",i),s.append("estado",o),s.append("proyectoId",r());try{const o="/api/tarea/eliminar",n=await fetch(o,{method:"POST",body:s}),r=await n.json();r.resultado&&(Swal.fire({position:"top-end",icon:"success",title:r.mensaje,showConfirmButton:!1,timer:1500,customClass:{popup:"swal2-popup",title:"swal2-title",text:"swal2-text"}}),t=t.filter((t=>t.id!==a.id)),e())}catch(t){console.log(t)}}(a)}))}(i)},d.appendChild(l),d.appendChild(u),s.appendChild(c),s.appendChild(d);document.querySelector("#listado-tareas").appendChild(s)}))}function a(a=!1,i={}){const s=document.createElement("div");s.classList.add("modal"),s.innerHTML=`\n\t\t<form action="" class="formulario nueva-tarea">\n\t\t\t<legend>${a?"Editar Tarea":"Añade una nueva tarea"}</legend>\n\t\t\t<div class="campo">\n\t\t\t\t<label for="">Tarea</label>\n\t\t\t\t<input \n\t\t\t\ttype="text" \n\t\t\t\tname="tarea" \n\t\t\t\tid="tarea" \n\t\t\t\tplaceholder="${i.nombre?"Editar Tarea":"Añadir Tarea al proyecto Actual"}"  \n\t\t\t\tvalue="${i.nombre?i.nombre:""}"/>\n\t\t\t</div>\n\t\t\t<div class="opciones">\n\t\t\t\t<input \n\t\t\t\ttype="submit" \n\t\t\t\tvalue="${i.nombre?"Guardar Cambios":"Añadir Tarea"}" \n\t\t\t\tclass="submit-nueva-tarea" />\n\t\t\t\t<button \n\t\t\t\ttype="button" \n\t\t\t\tclass="cerrar-modal">Regresar</button>\n\t\t\t</div>\n\t\t</form>\n\t\t`,setTimeout((()=>{document.querySelector(".formulario").classList.add("animar")}),0),s.addEventListener("click",(function(c){if(c.preventDefault(),c.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout((()=>{s.remove()}),500)}if(c.target.classList.contains("submit-nueva-tarea")){const s=document.querySelector("#tarea").value.trim();if(""===s)return void o("El nombre de la tarea es obligatorio","error",document.querySelector(".formulario legend"));if(s.length>60)return void o("El nombre de la tarea no puede tener mas de 60 caracteres","error",document.querySelector(".formulario legend"));a?(i.nombre=s,n(i)):async function(a){const o=new FormData;o.append("nombre",a),o.append("proyectoId",r());try{const n="/api/tarea",r=await fetch(n,{method:"POST",body:o}),i=await r.json();if("exito"===i.tipo){document.querySelector(".cerrar-modal").click(),Swal.fire({position:"top-end",icon:"success",title:i.mensaje,showConfirmButton:!1,timer:1500,customClass:{popup:"swal2-popup",title:"swal2-title",text:"swal2-text"}});const o={id:String(i.id),nombre:a,estado:"0",proyectoId:i.proyectoId};t=[...t,o],e()}}catch(t){console.log(t)}}(s)}})),document.querySelector(".dashboard").appendChild(s)}function o(t,e,a){const o=document.querySelector(".alerta");o&&o.remove();const n=document.createElement("div");n.classList.add("alerta",e),n.textContent=t,a.parentElement.insertBefore(n,a.nextElementSibling),setTimeout((()=>{n.remove()}),5e3)}async function n(a){const{estado:o,id:n,nombre:i,proyectoId:s}=a,c=new FormData;c.append("id",n),c.append("nombre",i),c.append("estado",o),c.append("proyectoId",r());try{const a="/api/tarea/actualizar",r=await fetch(a,{method:"POST",body:c}),s=await r.json();if("exito"===s.respuesta.tipo){const t=document.querySelector(".cerrar-modal");t&&t.click(),Swal.fire({position:"top-end",icon:"success",title:s.respuesta.mensaje,showConfirmButton:!1,timer:1500,customClass:{popup:"swal2-popup",title:"swal2-title",text:"swal2-text"}})}t=t.map((t=>(t.id===n&&(t.estado=o,t.nombre=i),t))),e()}catch(t){console.log(t)}}function r(){const t=new URLSearchParams(window.location.search);return Object.fromEntries(t.entries()).id}document.querySelector("#agregar-tarea").addEventListener("click",(function(){a()}))}();