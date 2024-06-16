//#region  Declaracion de Variables
const frmCredito = document.querySelector("#frmCredito");
const Identificacion = document.querySelector('#txtIdentificacion');
const Nombre = document.querySelector('#txtNombre');
const Telefono = document.querySelector('#txtTelefono');
const btnIdentificacion = document.querySelector("#btnIdentificacion");
const montoCredito = document.querySelector("#montoCredito");
const btnModalFacturasCredito = document.querySelector('#btnModalFacturasCredito');
//#endregion

document.addEventListener("DOMContentLoaded", function () {
    tblCreditos = $("#tblCreditos").dataTable({
        aProcessing: true,
        aServerSide: true,
        dom: "frtp",
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        ajax: {
            url: ` ${base_url}/creditos/getCreditos`,
            dataSrc: "",
        },
        columns: [{
            data: "id",
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
            data: "montoCredito",
            render: $.fn.dataTable.render.number(',', '.', 2, '¢')
        },
        {
            data: 'pendiente_pago',
            render: $.fn.dataTable.render.number(',', '.', 2, '¢')
        },
        {
            data: "creditoActual",
            render: $.fn.dataTable.render.number(',', '.', 2, '¢')
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

Identificacion.onkeyup = (e) => {
    if (e.key.length != 9) {
        if (e.key.length != 1 || 1 + e.key.search(/^[0-9]/)) {
            if (Identificacion.value.length >= 1) {
                const url = `${base_url}facturacion/getCliente`;
                const datos = new FormData();
                datos.append('op', 'i');
                datos.append('dato', Identificacion.value);

                const response = fnt_Fetch(url, 'post', datos);
                response.then((info) => {
                    if (info.status) {
                        Nombre.setAttribute("disabled", "true");
                        listaIdentificacion.innerHTML = info.data;
                        listaIdentificacion.style.display = 'block';
                    }
                })
            }
        } else {
            swal("", "No se permiten caracteres alfabeticos", 'info')
        }
    } else {
        Nombre.removeAttribute("disabled", "true");
        Identificacion.removeAttribute("disabled", "true");
        Nombre.value = "";
        listaIdentificacion.style.display = 'none';
        listaNombre.style.display = 'none';
    }
}

Nombre.onkeyup = (e) => {
    if (e.key.length != 9) {
        if (e.key.length != 1 || 1 + e.key.search(/^[a-zA-Z]/)) {
            if (Nombre.value.length >= 2) {
                const url = `${base_url}facturacion/getCliente`;
                const datos = new FormData();
                datos.append('op', 'n');
                datos.append('dato', Nombre.value);

                const response = fnt_Fetch(url, 'post', datos);
                response.then((info) => {
                    if (info.status) {
                        Identificacion.setAttribute("disabled", "true");
                        listaNombre.innerHTML = info.data;
                        listaNombre.style.display = 'block';
                    }
                });
            }
        } else {
            Nombre.value = "";
            swal("", "No se permiten caracteres numericos", 'info')
        }
    } else {
        Nombre.removeAttribute("disabled", "true");
        Identificacion.removeAttribute("disabled", "true");
        Identificacion.value = "";
        montoCredito.value = "";
        listaIdentificacion.style.display = 'none';
        listaNombre.style.display = 'none';
    }
}

function MostrarCliente(dato, op) {
    const url = `${base_url}facturacion/getCliente`;
    const datos = new FormData();
    datos.append('op', op);
    datos.append('dato', dato);

    const response = fnt_Fetch(url, 'post', datos);
    response.then((info) => {
        if (info.status) {
            document.getElementById('listaIdentificacion').style.display = 'none';
            document.getElementById('listaNombre').style.display = 'none';

            document.querySelector("#idCliente").value = info.data.id;
            Identificacion.value = info.data.Identificacion
            Nombre.value = info.data.Nombre;
            Telefono.value = info.data.Telefono;
        } else {
            swal('', info.msg, "info");
        }
    });
}

frmCredito.onsubmit = (e) => {
    e.preventDefault();

    const nombre = document.querySelector("#txtNombre");
    if (nombre.value == "") {
        Identificacion.focus();
        swal("", "Ingresa el número de identificación", "warning");
        return false;
    }

    if (montoCredito.value == "") {
        montoCredito.focus();
        swal("", "Ingresa el monto del crédito", "warning");
        return false;
    }

    const url = `${base_url}creditos/setCredito`;
    const frmDatos = new FormData(frmCredito);

    const response = fnt_Fetch(url, 'post', frmDatos)
    response.then(response => {
        if (response.status) {
            frmCredito.reset();
            // tblCreditos.ajax.reload();
            tblCreditos._fnAjaxUpdate();

            $("#modalCredito").modal("hide");
            swal("", response.msg, "success");
        } else {
            swal("", response.msg, "error");
        }
    });
}

function fntVerFacturas(idCliente) {
    tblFacturaCreditoCliente = $("#tblFacturaCreditoCliente").dataTable({
        aProcessing: true,
        aServerSide: true,
        dom: "frtp",
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        ajax: {
            url: `${base_url}creditos/getFacturasCreditoCliente/${idCliente}`,
            dataSrc: "",
        },
        columns: [{
            data: "id",
        },
        {
            data: "fecha",
        },
        {
            data: "nfactura",
        },
        {
            data: "tipo_factura",
        },
        {
            data: "tipo_pago",
        },
        {
            data: "m_total",
            render: $.fn.dataTable.render.number(',', '.', 2, '¢')
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
        ]
    });
}

function tPago() {
    const tpago = document.querySelector('#tipoPago');
    tpago.onchange = function (e) {
        if (e.target.value != 1) {
            document.querySelector('#div_nComprobante').classList.remove('d-none')
            $("#pagaCon").focus();
        } else {
            document.querySelector('#div_nComprobante').classList.add('d-none');
        }
    }
}

$(document).on('click', '#pagarFactura', function (e) {
    e.preventDefault();
    $('#ModalFacturasCreditoCliente').modal('hide');
    let filaEditar = $(this).closest("tr").get(0);
    let data = tblFacturaCreditoCliente.fnGetData(filaEditar._DT_RowIndex);
    let idVenta = data['id'];
    let total = new Intl.NumberFormat('en-US',).format(data['m_total']);

    Swal.fire({
        title: 'Total: ' + total,
        html:
            `<div class="form-group text-left">
                    <label for="tipoPago" class="control-label text-uppercase">Tipo Pago</label>
                    <select id="tipoPago" name="tipoPago" class="custom-select form-control">
                    <option value="1" selected="">Efectivo</option><option value="2">Tarjeta</option><option value="3">Sinpe</option></select>
                </div>
            <div class="form-group text-left">
                    <label for="pagaCon" class="control-label text-uppercase">Monto recibido</label>
                    <input id="pagaCon" type="text" class="form-control" name="pagaCon" placeholder="Monto recibido">
               </div>
               <div id="div_nComprobante" class="form-group text-left d-none">
                    <label for="nComprobante" class="control-label text-uppercase">Número de Comprobante</label>
                    <input id="nComprobante" type="text" class="form-control" name="nComprobante" placeholder= "Número de comprobante" autocomplete="off">
               </div>`,
        confirmButtonText: 'Pagar',
        confirmButtonColor: '#35b8e0',
        showCancelButton: true,
        cancelButtonColor: '#6c757d',
        focusConfirm: false,
        preConfirm: () => {
            const tipoPago = document.getElementById('tipoPago').value;
            const pagaCon = document.getElementById('pagaCon').value;
            const nComprobante = document.getElementById('nComprobante').value

            if (tipoPago == 1) {
                if (pagaCon != "") {
                    return JSON.stringify({ idVenta: idVenta, tipoPago: tipoPago, pagaCon: pagaCon, nComprobante: 0, total: data['m_total'] });

                } else {
                    swal("", "Digitar dinero recibido", 'info')
                    return false;
                }
            } else {
                if (pagaCon != "" || nComprobante != "") {
                    return JSON.stringify({ idVenta: idVenta, tipoPago: tipoPago, pagaCon: pagaCon, nComprobante: nComprobante, total: data['m_total'] });
                } else {
                    swal("", "Digitar dinero recibido y número de comprobante", 'info')
                    return false;
                }
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            var data = JSON.parse(result.value)
            let vuelto = Math.round(parseInt(data.pagaCon) - parseInt(data.total))

            const response = swalConfirmed(`Vuelto ${vuelto}`, "success")
            response.then((result) => {
                if (result.isConfirmed) {
                    guardarDatos(data.idVenta, data.tipoPago, data.pagaCon, data.nComprobante, vuelto);
                } else {
                    swal("", "Confirmar el vuelto para generar factutra", 'error')
                }
            });
        } else if (result.isDismissed) {
            swal("", "No se a realizado el pago", 'warning')
        }
    });

    tPago();
});

$(document).on('click', '#EditMontoCredito', function (e) {
    e.preventDefault();
    document.querySelector("#titleModal").innerHTML = "Actualizar Crédito";
    document.querySelector("#btnText").innerHTML = "Actualizar";

    let filaEditar = $(this).closest("tr").get(0);
    let data = tblCreditos.fnGetData(filaEditar._DT_RowIndex);

    document.querySelector("#idCredito").value = data['id'];
    document.querySelector("#txtIdentificacion").value = data['Identificacion'];
    document.querySelector("#txtNombre").value = data['Nombre'];
    document.querySelector("#txtTelefono").value = data['Telefono'];
    document.querySelector("#montoCredito").value = data['montoCredito'];

    $("#modalCredito").modal('show')
});

$(document).on('click', '#DeleteCredito', function (e) {
    e.preventDefault();

    let filaEditar = $(this).closest("tr").get(0);
    let data = tblCreditos.fnGetData(filaEditar._DT_RowIndex);
    let idCredito = data['id'];
    let pendiente_pago = data['pendiente_pago'];

    if (pendiente_pago > 0) {
        swal('Atención!', 'Cliente tiene saldo pendiente por pagar', 'warning');
        return false;
    }

    const frmDatos = new FormData();
    frmDatos.append('idCredito', idCredito);
    const url = `${base_url}creditos/deleteCredito`;

    const response = fnt_Fetch(url, 'post', frmDatos);
    response.then((res) => {
        if (res.status) {
            tblCreditos._fnAjaxUpdate();
            swal('', res.msg, "success");
        } else {
            swal('', res.msg, "error");
        }
    });
});

$(document).on('click', '#EnableCredito', function (e) {
    e.preventDefault();

    let filaEditar = $(this).closest("tr").get(0);
    let data = tblCreditos.fnGetData(filaEditar._DT_RowIndex);
    let idCredito = data['id'];

    const frmDatos = new FormData();
    frmDatos.append('idCredito', idCredito);
    const url = `${base_url}creditos/enableCredito`;

    const response = fnt_Fetch(url, 'post', frmDatos);
    response.then((res) => {
        if (res.status) {
            tblCreditos._fnAjaxUpdate();
            swal('', res.msg, "success");
        } else {
            swal('', res.msg, "error");
        }
    });
});

function guardarDatos(idVenta, tipoPago, pagaCon, nComprobante, vuelto) {
    const frmDatos = new FormData();
    const url = `${base_url}creditos/updateFactura`
    frmDatos.append('idVenta', idVenta);
    frmDatos.append('tipoPago', tipoPago);

    if (tipoPago == 1) {
        const response = fnt_Fetch(url, 'post', frmDatos);
        response.then((res) => {
            if (res.status) {
                GenerarFactura(idVenta, pagaCon, vuelto);
                tblCreditos._fnAjaxUpdate();
                swal('', res.msg, "success");
            } else {
                swal('', res.msg, "error");
            }
        });
    } else {
        const response = fnt_Fetch(url, 'post', frmDatos);
        response.then((res) => {
            if (res.status) {
                frmDatos.append('nComprobante', nComprobante);
                const url = `${base_url}facturacion/insertarComprobante`

                const response = fnt_Fetch(url, 'post', frmDatos);
                response.then((res) => {
                    if (res.status) {
                        GenerarFactura(idVenta, pagaCon, vuelto);
                        tblCreditos._fnAjaxUpdate();
                        swal('', res.msg, "success");
                    } else {
                        swal('', res.msg, "error");
                    }
                });
            } else {
                swal('', res.msg, "error");
            }
        });
    };
}

const GenerarFactura = async (idVenta, pagaCon, Vuelto) => {
    generarPDF(idVenta, pagaCon, Vuelto);
}

isNumber('txtIdentificacion');
isNumber('montoCredito');

// DESPLIEGA EL MODAL
function OpenModal() {
    document.querySelector("#idCredito").value = "0";
    document.querySelector("#titleModal").innerHTML = "Nuevo Crédito";
    document.querySelector("#btnText").innerHTML = "Guardar";
    document.querySelector("#frmCredito").reset();
}