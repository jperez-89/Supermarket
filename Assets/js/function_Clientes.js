var tblClientes, arrProvincias, arrCantones, arrDistritos, IdCa, idProvincia, idCanton, idDistrito, encontro, idCantonSeleccionado, data, statusHacienda;
const selecProvincia = document.getElementById("selecProvincia");
const selecCanton = document.getElementById("selecCanton");
const selecDistrito = document.getElementById("selecDistrito");
const selecRegimen = document.getElementById("selecRegimen");
const selecEstado = document.getElementById("selecEstado");
const frmClientes = document.querySelector("#frmClientes");
const Identificacion = document.querySelector("#txtIdentificacion");
const btnIdentificacion = document.querySelector("#btnIdentificacion");

document.addEventListener("DOMContentLoaded", function () {
  CargaProvincia();
  CargaRegimen();

  tblClientes = $("#tblClientes").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "frtip",
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    ajax: {
      url: ` ${base_url}/Clientes/getClientes`,
      dataSrc: "",
    },
    columns: [{
      data: "Id",
    },
    {
      data: "Identificacion",
    },
    {
      data: "Nombre",
    },
    {
      data: "Telefono",
    },
    {
      data: "Email",
    },
    {
      data: "Direccion",
    },
    {
      data: "regimen",
    },
    {
      data: "estadoHacienda",
    },
    {
      data: "Status",
    },
    {
      data: "options",
    },
    ],
    responsive: "true",
    bDestroy: true,
    iDisplayLenght: 10,
    order: [
      [0, "desc"]
    ],
    columnDefs: [{
      targets: [0],
      visible: false,
      searchable: false
    }],
  });
});

Identificacion.onkeypress = function (e) {
  if (e.keyCode == 13) {
    e.preventDefault();
    BuscarCliente(Identificacion.value);
  }
}

btnIdentificacion.onclick = function (e) {
  e.preventDefault();
  BuscarCliente(Identificacion.value)
}

frmClientes.onsubmit = function (e) {
  e.preventDefault();
  // Extraemos los datos
  const idCliente = document.querySelector("#idCliente").value;
  const txtIdentificacion = document.querySelector("#txtIdentificacion").value;
  const txtNombre = document.querySelector("#txtNombre").value;
  const txtTelefono = document.querySelector("#txtTelefono").value;
  const txtEmail = document.querySelector("#txtEmail").value;
  const selecProvincia = document.querySelector("#selecProvincia").value;
  const selecCanton = document.querySelector("#selecCanton").value;
  const selecDistrito = document.querySelector("#selecDistrito").value;
  const txtDireccion = document.querySelector("#txtDireccion").value;
  const selecRegimen = document.querySelector("#selecRegimen").value;
  const estadoHacienda = statusHacienda;

  // Validamos si los campos estan vacios para mostrar alerta
  if (
    txtIdentificacion == "" ||
    txtNombre == "" ||
    txtTelefono == "" ||
    txtEmail == "" ||
    selecProvincia == "" ||
    selecCanton == "" ||
    selecDistrito == "" ||
    txtDireccion == "" ||
    // txtActividad == "" ||
    selecRegimen == "" ||
    estadoHacienda == ""
  ) {
    swal("Atención", "Todos los campos son obligatorios", "warning");
    return false;
  }

  const url = `${base_url}clientes/setCliente`;
  frmDatos = new FormData(frmClientes);
  frmDatos.append('estadoHacienda', statusHacienda);

  const response = fnt_Fetch(url, 'post', frmDatos)
  response.then(objData => {
    if (objData.status) {
      frmClientes.reset();
      tblClientes.ajax.reload();

      $("#modalCliente").modal("hide");
      swal("", objData.msg, "success");
    } else {
      swal("Error", objData.msg, "error");
    }
  });
};

function fntEditClient(idCliente) {
  document.querySelector("#titleModal").innerHTML = "Actualizar Cliente";
  document.querySelector("#btnText").innerHTML = "Actualizar";

  const url = `${base_url}clientes/getCliente/${idCliente}`;
  const response = fnt_Fetch(url)
  response.then(InfoCliente => {
    if (InfoCliente.status) {
      // MOSTRAMOS LOS DATOS EN LOS CAMPOS DE TEXTO
      document.querySelector("#idCliente").value = InfoCliente.data.Id;
      document.querySelector("#txtIdentificacion").value = InfoCliente.data.Identificacion;
      document.querySelector("#txtNombre").value = InfoCliente.data.Nombre;
      document.querySelector("#txtTelefono").value = InfoCliente.data.Telefono;
      document.querySelector("#txtEmail").value = InfoCliente.data.Email;
      document.querySelector("#txtDireccion").value = InfoCliente.data.Direccion;
      document.querySelector("#estadoHacienda").value = InfoCliente.data.estadoHacienda;

      // HACEMOS SELECT DE LA PROVINCIA DEL CLIENTE
      selecProvincia.selectedIndex = InfoCliente.data.idProvincia;

      // FUNCIÓN PARA SELECCIONAR EL CANTÓN Y DISTRITO DEL CLIENTE
      llenarDireccion(InfoCliente.data.idProvincia, InfoCliente.data.idCanton, InfoCliente.data.idDistrito)

      selecRegimen.selectedIndex = InfoCliente.data.idRegimen;
      // selecEstado.selectedIndex = InfoCliente.data.Status - 1;

      // MOSTRAMOS EL MODAL
      $("#modalCliente").modal('show')
    } else {
      // MOSTRAMOS ERROR
      swal("", InfoCliente.msg, "error");
    }
  })
}

function fntDeleteClient(idCliente) {
  swal({
    title: "",
    text: "Realmente quiere deshabilitar el cliente?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    closeOnConfirm: false,
    closeOnCancel: true,
  },
    (isConfirm) => {
      if (isConfirm) {
        const url = `${base_url}clientes/deleteClient/`;
        const frm = new FormData()
        frm.append('idCliente', idCliente)

        const response = fnt_Fetch(url, 'post', frm)
        response.then(objData => {
          if (objData.status) {
            tblClientes.ajax.reload();
            swal("", objData.msg, "success");
          } else {
            swal("", objData.msg, "error");
          }
        })
      }
    })
}

function fntEnableClient(idCliente) {
  swal({
    title: "",
    text: "Realmente quiere Habilitar el cliente?",
    type: "info",
    showCancelButton: true,
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    closeOnConfirm: false,
    closeOnCancel: true,
  },
    (isConfirm) => {
      if (isConfirm) {
        const url = `${base_url}Clientes/enableClient/`;
        const frm = new FormData()
        frm.append('idCliente', idCliente)

        const response = fnt_Fetch(url, 'post', frm)
        response.then(objData => {
          if (objData.status) {
            tblClientes.ajax.reload();
            swal("", objData.msg, "success");
          } else {
            swal("", objData.msg, "error");
          }
        })
      }
    })
}

async function llenarDireccion(idProvincia, idCanton, idDistrito) {
  const idCantonSeleccionado = await SeleccionaCantonCliente(idCanton, idProvincia)
  SeleccionaDistritoCliente(idDistrito, idCantonSeleccionado)
}

async function SeleccionaCantonCliente(idCanton, idProvincia) {
  const arrCantones = await CargaCanton_Fetch(idProvincia);

  for (let i = 0; i < arrCantones.length; i++) {
    if (idCanton == arrCantones[i].Id) {
      encontro = i + 1;
      selecCanton.selectedIndex = encontro;
      idCantonSeleccionado = arrCantones[i].Id;
      break;
    }
  }
  return idCantonSeleccionado;
}

async function SeleccionaDistritoCliente(idDistrito, idCantonSeleccionado) {
  const arrDistritos = await CargaDistrito_Fetch(idCantonSeleccionado);

  for (let i = 0; i < arrDistritos.length; i++) {
    if (idDistrito == arrDistritos[i].Id) {
      encontro = i + 1;
      selecDistrito.selectedIndex = encontro;
      break;
    }
  }
}

// LLENADO DEL SELEC PROVINCIA
function CargaProvincia() {
  const url = base_url + "Clientes/getProvincia";
  fetch(url)
    .then(response => response.json())
    .then(data => {
      if (data.status) {
        selecProvincia.options[0] = new Option("Selecciona una Provincia", "0");
        arrProvincias = data.data;

        for (let i = 1; i <= arrProvincias.length; i++) {
          selecProvincia.options[i] = new Option(
            arrProvincias[i - 1]["NombreProvincia"],
            arrProvincias[i - 1]["Id"]
          );
        }
      } else {
        swal("Error", data.msg, "error");
      }
    });
}

// LLENADO DEL SELEC PROVINCIA
function CargaRegimen() {
  const url = base_url + "clientes/getRegimen";
  fetch(url)
    .then(response => response.json())
    .then(data => {
      if (data.status) {
        selecRegimen.options[0] = new Option("Selecciona una opción", "0");

        for (let i = 1; i <= data.data.length; i++) {
          selecRegimen.options[i] = new Option(
            data.data[i - 1]["regimen"],
            data.data[i - 1]["id"]
          );
        }
      } else {
        swal("Error", data.msg, "error");
      }
    });
}

// FUNCION FETCH QUE CARGA EL SELECT DE CANTONES
async function CargaCanton_Fetch(IdProvincia) {
  resetListaCanton();
  resetListaDistrito();
  let url = `${base_url}Clientes/getCanton/${IdProvincia}`;
  await fetch(url)
    .then(response => response.json())
    .then(data => {
      if (data.status) {
        selecCanton.options[0] = new Option("Selecciona un Cantón", "0");
        arrCantones = data.data;

        // ASIGNAMOS LOS VALORES AL SELECT DE CANTONES
        for (let i = 1; i <= arrCantones.length; i++) {
          selecCanton.options[i] = new Option(
            arrCantones[i - 1]["NombreCanton"],
            arrCantones[i - 1]["Id"]
          );
        }
      } else {
        swal("Error", data.msg, "error");
      }
    });
  return arrCantones;
}

// FUNCION FETC QUE CARGA EL SELECT DE DISTRITOS
const CargaDistrito_Fetch = async (idCantonSeleccionado) => {
  let url = `${base_url}Clientes/getDistrito/${idCantonSeleccionado}`;
  await fetch(url)
    .then(response => response.json())
    .then(data => {
      if (data.status) {
        selecDistrito.options[0] = new Option("Selecciona un Distrito", "0");
        arrDistritos = data.data;

        // ASIGNAMOS LOS VALORES AL SELECT DE DISTRITOS
        for (let i = 1; i <= arrDistritos.length; i++) {
          selecDistrito.options[i] = new Option(
            arrDistritos[i - 1]["nombreDistrito"],
            arrDistritos[i - 1]["Id"]
          );
        }
      } else {
        swal("Error", data.msg, "error");
      }
    });
  return arrDistritos;
}

// RESETEA EL SELECT DE CANTONES
function resetListaCanton() {
  //Elimina los items cuando se elige otra Provincia
  var lengthddlCanton = selecCanton.length;
  for (var i = lengthddlCanton; i >= 0; i--) {
    selecCanton.options[i] = null;
  }
}

// RESETEA EL SELECT DE DISTRITOS
function resetListaDistrito() {
  //Elimina los items cuando se elige otra Provincia
  var lengthddlDistrito = selecDistrito.length;
  for (var i = lengthddlDistrito; i >= 0; i--) {
    selecDistrito.options[i] = null;
  }
}

// DESPLIEGA EL MODAL
function OpenModal() {
  resetListaCanton();
  resetListaDistrito();
  document.querySelector("#idCliente").value = "";
  document.querySelector("#titleModal").innerHTML = "Nuevo Cliente";
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#frmClientes").reset();
}