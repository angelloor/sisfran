// Precarga del Script
var formMDT;
var overlayMDT;
var popupMDT;

$(document).ready(function () {
  formMDT = document.getElementById("formMDT");
  overlayMDT = document.getElementById("overlayMDT");
  popupMDT = document.getElementById("popupMDT");
});

function verMas(data, orden = false, ordenClaves = []) {
  let html = "";

  // Determinar las claves que se van a iterar
  let keys = Object.keys(data);

  // Aplicar el orden si `orden` es true
  if (orden && Array.isArray(ordenClaves) && ordenClaves.length > 0) {
    keys = ordenClaves.filter((key) => keys.includes(key)); // Ordenar según las claves definidas en `ordenClaves`
  }

  // Iterar sobre las claves y valores de la data
  for (const key of keys) {
    let finalKey = key;
    let finalValue = data[key];

    // Reemplazar valores sensibles o valores nulos
    if (key === "clave") {
      finalValue = "******";
    } else if (finalValue === "") {
      finalValue = "S/D";
    }

    // Reemplazar _ por espacio en blanco
    finalKey = key.replace(/_/g, " ");

    // Solo renderizar las claves que no sean un ID
    if (!finalKey.toLowerCase().endsWith("id")) {
      html += "<div class='containerRow'>";
      html += "<div class='key'>" + finalKey.toUpperCase() + "</div>";
      html += "<div class='value'>" + finalValue + "</div>";
      html += "</div>";
    }
  }

  // Insertar el HTML generado en el contenedor
  document.getElementById("datosMDT").innerHTML = html;

  callPopupFrame();
}

function callPopupFrame() {
  overlayMDT.classList.add("active");
  popupMDT.classList.add("active");
  formMDT.removeAttribute("hidden");
}

function cerrar(e) {
  e.preventDefault();
  close();
  clear();
}

function close() {
  overlayMDT.classList.remove("active");
  popupMDT.classList.remove("active");
}

function clear() {
  formMDT.setAttribute("hidden", true);
}
