var frmRoles = document.querySelector("#frmRoles");

document.addEventListener("DOMContentLoaded", function () {
  // Mostrar los datos en la tabla
  tableRoles = $("#tblRoles").DataTable({
    aProcessing: true,
    aServerSide: true,
    sDom: "frtip",
    languaje: {
      url: "//cnd.datatables.net/plug-ins/1.10.20/i18n/spanish.json",
    },
    ajax: {
      url: " " + base_url + "/Roles/getRoles",
      dataSrc: ""
    },
    columns: [{
      data: "Id"
    },
    {
      data: "nombreRol"
    },
    {
      data: "descripcion"
    },
    {
      data: "status"
    },
    {
      data: "options"
    },
    ],
    responsive: "true",
    bDestroy: true,
    iDisplayLenght: 10,
  });
});

// Registrar y editar un producto
if (frmRoles != null) {
  frmRoles.onsubmit = function (e) {
    e.preventDefault();

    // Extraemos los datos
    var idRol = document.querySelector("#idRol").value;
    var nombreRol = document.querySelector("#txtNombreRol").value;
    var descripcion = document.querySelector("#txtDescripcionRol").value;

    // Validamos si los campos estan vacios para mostrar alerta
    if (nombreRol == "" || descripcion == "") {
      swal("Atención", "Todos los campos son obligatorios", "error");
      return false;
    }

    const url = `${base_url}Roles/setRol`;
    frmDatos = new FormData(this);

    const response = fnt_Fetch(url, 'post', frmDatos);
    response.then(objData => {
      if (objData.status) {
        // Reseteamos los campos del formulario de productos
        frmRoles.reset();
        // Cerramos el modal
        $("#modalRoles").modal("hide");
        // Recargamos la tabla
        tableRoles.ajax.reload();
        // Enviamos mensaje de exito
        swal("", objData.msg, "success");
      } else {
        // Mostramos error
        swal("", objData.msg, "error");
      }
    })
  }
}

function fntEditRol(idRol) {
  // Editar el estilo del modal
  document.querySelector("#titleModal").innerHTML = "Actualizar Rol";
  document.querySelector("#btnText").innerHTML = "Actualizar";

  // Obtener los datos
  var url = `${base_url}Roles/getRol/${idRol}`;

  const response = fnt_Fetch(url);
  response.then(objData => {
    if (objData.status) {
      // Mostar los datos en los campos para editar
      document.querySelector("#idRol").value = objData.data.Id;
      document.querySelector("#txtNombreRol").value = objData.data.nombreRol;
      document.querySelector("#txtDescripcionRol").value = objData.data.descripcion;

      // MOSTRAMOS EL MODAL
      $("#modalRoles").modal("show");
    } else {
      // Mostramos error
      swal("", objData.msg, "error");
    }
  })
}

function fntDeleteRol(id) {
  swal({
    title: "Realmente quiere deshabilitar el rol?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    closeOnConfirm: true,
    closeOnCancel: true,
  },
    (isConfirm) => {
      if (isConfirm) {
        const url = `${base_url}Roles/deleteRol/`;
        const frm = new FormData()
        frm.append('id', id)

        const response = fnt_Fetch(url, 'post', frm)
        response.then(objData => {
          if (objData.status) {
            tableRoles.ajax.reload();
            swal("", objData.msg, "success");
          } else {
            swal("", objData.msg, "error");
          }
        })
      }
    })
}

function fntEnableRol(id) {
  swal({
    title: "Realmente quiere habilitar el rol?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    closeOnConfirm: true,
    closeOnCancel: true,
  },
    (isConfirm) => {
      if (isConfirm) {
        const url = `${base_url}Roles/enableRol/`;
        const frm = new FormData()
        frm.append('id', id)

        const response = fnt_Fetch(url, 'post', frm)
        response.then(objData => {
          if (objData.status) {
            tableRoles.ajax.reload();
            swal("", objData.msg, "success");
          } else {
            swal("", objData.msg, "error");
          }
        })
      }
    })
}

// Funcion para mostrar el modal
function OpenModal() {
  document.querySelector("#idRol").value = "";
  document.querySelector("#titleModal").innerHTML = "Nuevo Rol";
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#frmRoles").reset();

  selectPermisos(0)

  $("#modalRoles").modal("show");
}

function selectPermisos(idRol) {
  const url = `${base_url}roles/getPermisos/`;
  const frmDatos = new FormData();
  frmDatos.append('idRol', idRol);

  var response = fnt_Fetch(url, 'post', frmDatos);
  response.then(data => {
    if (data.status) {
      document.getElementById('Permisos').innerHTML = data.html;
    } else {
      swal("", data.msg, "error");
    }
  })
}