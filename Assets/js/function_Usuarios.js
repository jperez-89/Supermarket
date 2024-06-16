const frmUsuarios = document.querySelector("#frmUsuarios");

document.addEventListener("DOMContentLoaded", function () {
  GetRoles();

  // Mostrar los datos en la tabla
  tblUsuarios = $("#tblUsuarios").DataTable({
    aProcessing: true,
    aServerSide: true,
    sDom: "frtip",
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    ajax: {
      url: ` ${base_url}/Usuarios/getUsers`,
      dataSrc: "",
    },
    columns: [{
      data: "id",
    },
    {
      data: "dni",
    },
    {
      data: "name",
    },
    {
      data: "surnames",
    },
    {
      data: "phone",
    },
    {
      data: "email",
    },
    {
      data: "username",
    },
    {
      data: "password",
    },
    {
      data: "rol",
    },
    {
      data: "status",
    },
    {
      data: "options",
    }
    ],
    responsive: "true",
    bDestroy: true,
    iDisplayLenght: 10,
    columnDefs: [{
      targets: [0],
      visible: false,
      searchable: false
    }],
  });
});

// Registro de nuevo cliente
frmUsuarios.onsubmit = function (e) {
  e.preventDefault();

  // Extraemos los datos
  const idUsuario = document.querySelector("#idUsuario").value;
  const txtIdentificacion = document.querySelector("#txtIdentificacion").value;
  const txtNombre = document.querySelector("#txtNombre").value;
  const txtApellidos = document.querySelector("#txtApellidos").value;
  const txtTelefono = document.querySelector("#txtTelefono").value;
  const txtEmail = document.querySelector("#txtEmail").value;
  const txtUsuario = document.querySelector("#txtUsuario").value;
  const txtContra = document.querySelector("#txtContra").value;
  const selecRol = document.querySelector("#selecRol").value;

  // Validamos si los campos estan vacios para mostrar alerta
  if (
    txtIdentificacion == "" ||
    txtNombre == "" ||
    txtApellidos == "" ||
    txtTelefono == "" ||
    txtEmail == "" ||
    txtUsuario == "" ||
    txtContra == "" ||
    selecRol == ""
    // imgUsuario == "" ||
    // selecEstado == ""
  ) {
    swal("Atención", "Todos los campos son obligatorios", "error");
    return false;
  }

  const url = `${base_url}usuarios/setUser`;
  frmDatos = new FormData(this)

  const response = fnt_Fetch(url, 'post', frmDatos)
  response.then(objData => {
    if (objData.status) {
      // Reseteamos los campos del formulario de productos
      frmUsuarios.reset();
      // Cerramos el modal
      $("#modalUsuario").modal("hide");
      // Enviamos mensaje de exito
      swal("", objData.msg, "success");
      // Recargamos la tabla
      tblUsuarios.ajax.reload();
    } else {
      // Mostramos error
      swal("", objData.msg, "error");
    }
  })
};

function fntEditUser(id) {
  document.querySelector("#titleModal").innerHTML = "Actualizar Usuario";
  document.querySelector("#btnText").innerHTML = "Actualizar";

  const url = `${base_url}Usuarios/getUser/${id}`;

  const response = fnt_Fetch(url)
  response.then(infoUser => {
    if (infoUser.status) {
      document.querySelector("#idUsuario").value = infoUser.data.id;
      document.querySelector("#txtIdentificacion").value = infoUser.data.dni;
      document.querySelector("#txtNombre").value = infoUser.data.name;
      document.querySelector("#txtApellidos").value = infoUser.data.surnames;
      document.querySelector("#txtTelefono").value = infoUser.data.phone;
      document.querySelector("#txtEmail").value = infoUser.data.email;
      document.querySelector("#txtUsuario").value = infoUser.data.username;
      document.querySelector("#txtContra").value = infoUser.data.password;

      // HACEMOS SELECT DEL ROL DEL USUARIO
      document.getElementById("selecRol").selectedIndex = infoUser.data.idRol;

      // MOSTRAMOS EL MODAL
      $("#modalUsuario").modal("show");
    } else {
      // MOSTRAMOS ERROR
      swal("Error", infoUser.msg, "error");
    }
  })
}

function fntDeleteUser(id) {
  swal({
    title: "",
    text: "Realmente quiere deshabilitar el usuario?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    closeOnConfirm: false,
    closeOnCancel: true,
  },
    (isConfirm) => {
      if (isConfirm) {
        const url = `${base_url}Usuarios/deleteUser/`;
        const frm = new FormData()
        frm.append('id', id)

        const response = fnt_Fetch(url, 'post', frm)
        response.then(objData => {
          if (objData.status) {
            tblUsuarios.ajax.reload();
            swal("", objData.msg, "success");
          } else {
            swal("", objData.msg, "error");
          }
        })
      }
    })
}

function fntEnableUser(id) {
  swal({
    title: "",
    text: "Realmente quiere habilitar el usuario?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    closeOnConfirm: false,
    closeOnCancel: true,
  },
    (isConfirm) => {
      if (isConfirm) {
        const url = `${base_url}Usuarios/enableUser/`;
        const frm = new FormData()
        frm.append('id', id)

        const response = fnt_Fetch(url, 'post', frm)
        response.then(objData => {
          if (objData.status) {
            tblUsuarios.ajax.reload();
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
  document.querySelector("#idUsuario").value = "";
  document.querySelector("#titleModal").innerHTML = "Nuevo Usuario";
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#frmUsuarios").reset();

  $("#modalUsuario").modal("show");
}

// LLENADO DEL SELEC ROLES
function GetRoles() {
  const url = `${base_url}Usuarios/getRoles`;
  fetch(url)
    .then(response => response.json())
    .then(data => {
      if (data.status) {
        selecRol.options[0] = new Option("Seleccione un rol", "0");
        arrRoles = data.data;

        for (let i = 1; i <= arrRoles.length; i++) {
          selecRol.options[i] = new Option(
            arrRoles[i - 1]["nombreRol"],
            arrRoles[i - 1]["Id"]
          );
        }
      } else {
        swal("", data.msg, "error");
      }
    });
}