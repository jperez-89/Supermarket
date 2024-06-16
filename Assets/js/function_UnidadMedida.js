document.addEventListener("DOMContentLoaded", function () {
    tblUnidadMedida = $("#tblUnidadMedida").dataTable({
        aProcessing: true,
        aServerSide: true,
        dom: "frtip",
        "language": {
            "url": `${base_url}assets/js/plugins/Spanish.json`,
        },
        ajax: {
            url: ` ${base_url}/productos/getUnidadesMedida`,
            dataSrc: "",
        },
        columns: [{
            data: "id",
        },
        {
            data: "unidad",
        },
        {
            data: "nomenclatura",
        },
        {
            data: "equivalencia",
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

var frmUnidadMedida = document.querySelectorAll('#frmUnidadMedida')
Array.prototype.slice.call(frmUnidadMedida).forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            form.classList.add('was-validated')
            event.preventDefault()
            event.stopPropagation()
        } else {
            event.preventDefault();
            form.classList.remove('was-validated')

            const frmUnidadMedida = document.querySelector('#frmUnidadMedida');
            const url = `${base_url}productos/setUnidadMedida`;
            const frmDatos = new FormData(frmUnidadMedida);

            const response = fnt_Fetch(url, 'post', frmDatos)
            response.then(response => {
                if (response.status) {
                    frmUnidadMedida.reset();
                    tblUnidadMedida._fnAjaxUpdate();

                    $("#modalUnidadMedida").modal("hide");
                    swalMixin('success', response.msg, 'bottom-end', 2000)
                } else {
                    swal("", response.msg, "error");
                }
            });
        }

    }, false)
});

$(document).on('click', '.editUnidadMedida', function (e) {
    e.preventDefault();
    document.querySelector("#titleModal").innerHTML = "Actualizar Unidad de Medida";
    document.querySelector("#btnText").innerHTML = "Actualizar";

    let filaEditar = $(this).closest("tr").get(0);
    let data = tblUnidadMedida.fnGetData(filaEditar._DT_RowIndex);

    document.querySelector("#idUnidadMedida").value = data.id;
    document.querySelector("#nombreUnidad").value = data.unidad;
    document.querySelector("#nomenclatura").value = data.nomenclatura;
    document.querySelector("#equivalencia").value = data.equivalencia;

    $("#modalUnidadMedida").modal('show')
});

$(document).on('click', '.deleteUnidadMedida', function (e) {
    e.preventDefault();

    let filaEditar = $(this).closest("tr").get(0);
    let data = tblUnidadMedida.fnGetData(filaEditar._DT_RowIndex);
    let idUnidad = data['id'];

    const frmDatos = new FormData();
    frmDatos.append('idUnidad', idUnidad);
    const url = `${base_url}productos/deleteUnidadMedida`;

    const response = fnt_Fetch(url, 'post', frmDatos);
    response.then((res) => {
        if (res.status) {
            tblUnidadMedida._fnAjaxUpdate();
            swalMixin('success', res.msg, 'bottom-end', 2000)
        } else {
            swal('', res.msg, "error");
        }
    });
});

$(document).on('click', '.enableUnidadMedida', function (e) {
    e.preventDefault();

    let filaEditar = $(this).closest("tr").get(0);
    let data = tblUnidadMedida.fnGetData(filaEditar._DT_RowIndex);
    let idUnidad = data['id'];

    const frmDatos = new FormData();
    frmDatos.append('idUnidad', idUnidad);
    const url = `${base_url}productos/enableUnidadMedida`;

    const response = fnt_Fetch(url, 'post', frmDatos);
    response.then((res) => {
        if (res.status) {
            tblUnidadMedida._fnAjaxUpdate();
            swalMixin('success', res.msg, 'bottom-end', 2000)
        } else {
            swal('', res.msg + res.error.errorInfo[2], "error");
        }
    });
});

function OpenModal() {
    document.querySelector("#idUnidadMedida").value = "0";
    document.querySelector("#titleModal").innerHTML = "Nueva Unidad de Medida";
    document.querySelector("#btnText").innerHTML = "Guardar";
    document.querySelector("#frmUnidadMedida").reset();
}