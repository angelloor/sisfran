// Definición Params
const params = new URLSearchParams(window.location.search);
// Definición de Alertas
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    cancelButton: "btn btn-primary mr-2 ml-2",
    confirmButton: "btn btn-success mr-2 ml-2",
  },
  buttonsStyling: false,
});

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
  Swal.fire(titulo, descripcion, tipoAlerta);
}

const getValue = (elementId) => {
  return document.getElementById(elementId).value;
};

const setValue = (elementId, value) => {
  document.getElementById(elementId).value = value;
};

const clearInput = (elementId) => {
  document.getElementById(elementId).value = "";
};

const disabledInput = (elementId) => {
  document.getElementById(elementId).disabled = true;
};

const enabledInput = (elementId) => {
  document.getElementById(elementId).disabled = false;
};

const hiddenInput = (elementId) => {
  document.getElementById(elementId).style.display = "none";
};

const visibleInput = (elementId) => {
  document.getElementById(elementId).style.display = "block";
};