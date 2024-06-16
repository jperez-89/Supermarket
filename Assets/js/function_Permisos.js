//#region  Declaracion de Variables
const frmPermiso = document.querySelector("#frmPermiso");
const idPermiso = document.querySelector('#idPermiso');
const nombrePermiso = document.querySelector('#nombrePermiso');
//#endregion

document.addEventListener("DOMContentLoaded", function () {
    tblPermisos = $("#tblPermisos").dataTable({
        aProcessing: true,
        aServerSide: true,
        dom: "frtp",
        "language": {
            "url": `${base_url}assets/js/plugins/Spanish.json`,
        },
        ajax: {
            url: ` ${base_url}/permisos/getPermisos`,
            dataSrc: "",
        },
        columns: [{
            data: "id",
        },
        {
            data: "nombre",
        },
        {
            data: "estado",
        },
        {
            data: "options",
        },
        ],
        responsive: "true",
        bDestroy: true,
        iDisplayLenght: 10,
        order: [
            [0, "asc"]
        ],
        columnDefs: [{
            targets: [0],
            visible: false,
            searchable: false
        }],
    });
});

const frmPermisoAll = document.querySelectorAll("#frmPermiso");
Array.prototype.slice.call(frmPermisoAll).forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            form.classList.add('was-validated')
            event.preventDefault()
            event.stopPropagation()
        } else {
            event.preventDefault();
            form.classList.remove('was-validated')

            const url = `${base_url}permisos/setPermiso`;
            const frmDatos = new FormData(frmPermiso);

            const response = fnt_Fetch(url, 'post', frmDatos)
            response.then(response => {
                if (response.status) {
                    frmPermiso.reset();
                    tblPermisos._fnAjaxUpdate();

                    $("#modalPermisos").modal("hide");
                    swalMixin('success', response.msg, 'bottom-end', 2000)
                } else {
                    swal("", response.msg, "error");
                }
            });
        }

    }, false)
});

$(document).on('click', '.editPermiso', function (e) {
    e.preventDefault();
    document.querySelector("#titleModal").innerHTML = "Actualizar Permiso";
    document.querySelector("#btnText").innerHTML = "Actualizar";

    let filaEditar = $(this).closest("tr").get(0);
    let data = tblPermisos.fnGetData(filaEditar._DT_RowIndex);

    document.querySelector("#idPermiso").value = data.id;
    document.querySelector("#nombrePermiso").value = data.nombre;

    $("#modalPermisos").modal('show')
});

$(document).on('click', '.deletePermiso', function (e) {
    e.preventDefault();

    let filaEditar = $(this).closest("tr").get(0);
    let data = tblPermisos.fnGetData(filaEditar._DT_RowIndex);
    let idPermiso = data['id'];

    const frmDatos = new FormData();
    frmDatos.append('idPermiso', idPermiso);
    const url = `${base_url}permisos/deletePermiso`;

    const response = fnt_Fetch(url, 'post', frmDatos);
    response.then((res) => {
        if (res.status) {
            tblPermisos._fnAjaxUpdate();
            swalMixin('success', res.msg, 'bottom-end', 2000)
        } else {
            swal('', res.msg, "error");
        }
    });
});

$(document).on('click', '.enablePermiso', function (e) {
    e.preventDefault();

    let filaEditar = $(this).closest("tr").get(0);
    let data = tblPermisos.fnGetData(filaEditar._DT_RowIndex);
    let idPermiso = data['id'];

    const frmDatos = new FormData();
    frmDatos.append('idPermiso', idPermiso);
    const url = `${base_url}permisos/enablePermiso`;

    const response = fnt_Fetch(url, 'post', frmDatos);
    response.then((res) => {
        if (res.status) {
            tblPermisos._fnAjaxUpdate();
            swalMixin('success', res.msg, 'bottom-end', 2000)
        } else {
            swal('', res.msg, "error");
        }
    });
});

nombrePermiso.onkeyup = (e) => {
    if (e.key.length != 1 || 1 + e.key.search(/^[a-zA-Z-_]/)) {
    } else {
        nombrePermiso.value = "";
        swal("", "No se permiten caracteres numericos", 'info')
    }
}

// DESPLIEGA EL MODAL
function OpenModal() {
    document.querySelector("#idPermiso").value = "0";
    document.querySelector("#titleModal").innerHTML = "Nuevo Permiso";
    document.querySelector("#btnText").innerHTML = "Guardar";
    document.querySelector("#frmPermiso").reset();
}