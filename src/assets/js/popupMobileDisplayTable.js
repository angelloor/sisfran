// Precarga del Script
var formMDT;
var overlayMDT;
var popupMDT;

$(document).ready(function () {
  formMDT = document.getElementById("formMDT");
  overlayMDT = document.getElementById("overlayMDT");
  popupMDT = document.getElementById("popupMDT");
});

function verMas(data) {
  var html = "";
  // Iterar sobre las claves y valores de la data
  for (const [key, value] of Object.entries(data)) {
    let finalKey = key
    let finalValue = value

    // remplazar valores sensibles o valores nulos
    if (key == 'clave') {
      finalValue = '******';
    } else if (value == '') {
      finalValue = "S/D"
    }

    // remplazar _ por espacio en blanco
    finalKey = key.replace(/_/g, " ");

    // Solo renderizar las claves que no sean un ID
    if (!finalKey.endsWith("id")) {
      html += "<div class='containerRow'>";
      html += "<div class='key'>" + finalKey.toUpperCase() + "</div>";
      html += "<div class='value'>" + finalValue + "</div>";
      html += "</div>";
    }
  }
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
