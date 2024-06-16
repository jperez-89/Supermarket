//#region Declaraciones
const Identificacion = document.querySelector("#Identificacion");
const Nombre = document.querySelector("#Nombre");
const NombreProducto = document.querySelector("#nombreProducto");
const txtCodigo = document.querySelector("#txtCodigo");
var listaIdentificacion = document.getElementById('listaIdentificacion');
var listaNombre = document.getElementById('listaNombre');
var listaProductos = document.getElementById('listaProductos');
var select_TipoDocumento = document.querySelector('#tipoDocumento');
var select_TipoPago = document.querySelector('#tipoPago');
const btnAgregarProducto = document.querySelector("#btnAgregarProducto");
var NuevaCantidad = 0, NuevoSubtotal = 0, existe = false, CantExistente = 0, cantidad = 0, precio = 0, iva = 0, subTotal = 0, total = 0, miva = 0, DatosTabla, idProducto, cfilas = 0, idFactura, tipoFactura, tipoPago, codigo, infoTable, creditoActual = 0, estadoCredito;

var tabla = $("#tblFactura").dataTable({
     retrieve: true,
     paging: false,
     searching: false,
     dom: "",
     'language': {
          //      // "lengthMenu": "Mostrar _MENU_ registros por página",
          //      // "search": "Buscar:",
          // "sEmptyTable": "",
          //      "sInfo": " ", // Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros
          //      "infoEmpty": " ",
          "zeroRecords": " ",
          //      "oPaginate": {
          //           "sFirst": "Primero",
          //           "sLast": "Ultimo",
          //           "sNext": "Siguiente",
          //           "sPrevious": "Anterior",
          //      }
     }
});
//#endregion

window.onload = function () {
     // $("#txtCodigo").focus();
     FechaActual();
     getTipoDocumento()
     getTipoPago()
     MostrarCliente(4, 'data')
};

//#region -----------------> BUSCAR CLIENTE POR NOMBRE O IDENTIFICACION <-------------------------
Identificacion.onkeyup = (e) => {
     if (e.key.length != 9) {
          if (e.key.length != 1 || 1 + e.key.search(/^[0-9]/)) {

               if (Identificacion.value.length >= 1) {
                    const url = `${base_url}facturacion/getCliente`;
                    const datos = new FormData();
                    datos.append('op', 'i');
                    datos.append('dato', e.target.value);

                    const response = fnt_Fetch(url, 'post', datos);
                    response.then((info) => {
                         if (info.status) {
                              Nombre.setAttribute("disabled", "true");
                              listaIdentificacion.innerHTML = info.data;
                              listaIdentificacion.style.display = 'block';
                         }
                    })
               }
          }
     } else {
          Nombre.removeAttribute("disabled", "true");
          Identificacion.removeAttribute("disabled", "true");
          document.querySelector("#Nombre").value = "";
          document.querySelector("#Email").value = "";
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
          }
     } else {
          Nombre.removeAttribute("disabled", "true");
          Identificacion.removeAttribute("disabled", "true");
          document.querySelector("#Identificacion").value = "";
          // document.querySelector("#Telefono").value = "";
          document.querySelector("#Email").value = "";
          // document.querySelector("#Direccion").value = "";
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
               document.querySelector("#Identificacion").value = info.data.Identificacion;
               document.querySelector("#Nombre").value = info.data.Nombre;
               var telef = info.data.Telefono;
               document.querySelector("#Email").value = info.data.Email;
               var direc = info.data.Direccion;
               creditoActual = info.data.creditoActual;
               estadoCredito = info.data.estado;
          } else {
               swal('', info.msg, "info");
          }
     });
}
//#endregion

//#region -----------------> BUSCAR PRODUCTOS POR NOMBRE O CODIGO <-------------------------
NombreProducto.onkeyup = (e) => {
     if (e.key.length != 9) {
          if (e.key.length != 1 || 1 + e.key.search(/^[a-zA-Z]/)) {

               if (NombreProducto.value.length >= 2) {
                    const url = `${base_url}facturacion/getProducto`;
                    const datos = new FormData();
                    datos.append('op', 'n');
                    datos.append('dato', NombreProducto.value);

                    const response = fnt_Fetch(url, 'post', datos);
                    response.then((info) => {
                         if (info.status) {
                              listaProductos.innerHTML = info.data;
                              listaProductos.style.display = 'block';
                         }
                    });
               }
          }
     } else {
          listaProductos.style.display = 'none';
     }
}

function MostrarProducto(dato, op) {
     const url = `${base_url}facturacion/getProducto`;
     const datos = new FormData();
     datos.append('op', op);
     datos.append('dato', dato);

     const response = fnt_Fetch(url, 'post', datos);
     response.then((info) => {
          if (info.status) {
               listaProductos.style.display = 'none';

               $("#btnAgregarProducto").removeClass("disabled");
               document.querySelector("#codigo").value = info.data.codigo;
               document.querySelector("#nombreProducto").value = info.data.name;
               document.querySelector("#Precio").value = info.data.price;
               document.querySelector("#Stock").value = info.data.cantidad;
               porceIva = info.data.valor / 100;
               document.querySelector("#Cantidad").focus();
          } else {
               swal('', info.msg, 'info');
          }
     });
}

$('#txtCodigo').change(function (e) {
     e.preventDefault();

     const url = `${base_url}facturacion/getProducto`;
     const datos = new FormData();
     datos.append('op', 'data');
     datos.append('dato', e.target.value);

     const response = fnt_Fetch(url, 'post', datos);
     response.then((info) => {
          if (info.status) {
               codigo = $("#txtCodigo").val();
               NombreProduct = info.data.name;
               precio = info.data.price;
               porceIva = info.data.valor / 100;
               cantidad = 1;

               // INSERTA PRIMER PRODUCTO
               if (cfilas == 0) {
                    CalcularTotalLinea(Number(precio), Number(cantidad));
                    cfilas += 1;
                    AgregarLinea(tabla, cfilas, codigo, cantidad, NombreProduct, precio, subTotal, miva, total);
               }
               // SI EXISTE EL CODIGO SE ACTUALIZA LAS CANTIDADES Y TOTALES DE LINEA
               else if (buscarCodigo(tabla, codigo)) {
                    NuevaCantidad = Number(CantExistente) + Number(cantidad);
                    tabla.fnUpdate(`<div class="w-100"><input name="cantidadT" id="cantidadT" type="number" value="${NuevaCantidad}" min="1" class="form-control text-center" ></div>`, nfila, 2, 0, false);

                    NuevoIva = (precio * porceIva) * NuevaCantidad;
                    tabla.fnUpdate(Number.parseFloat(NuevoIva).toFixed(2), nfila, 6, 0, false);

                    NuevoSubtotal = (precio * NuevaCantidad);
                    tabla.fnUpdate(Number.parseFloat(NuevoSubtotal).toFixed(2), nfila, 5, 0, false);

                    NuevoTotal = NuevoSubtotal + NuevoIva;
                    tabla.fnUpdate(Number.parseFloat(NuevoTotal).toFixed(2), nfila, 7, 0, false);
                    /* Dato, nfila, ncolumna, 0, false */

                    // se cambia a falso por que en el if del for no se implemento el else, para que no se ejecute tantas veces por si no se valida el if
                    existe = false;
               }
               //SI NO EXISTE EL CODIGO DEL PRODUCTO, AGREGA LA INFORMACION A LA TABLA ----------------------
               else {
                    CalcularTotalLinea(Number(precio), Number(cantidad));
                    cfilas += 1;
                    AgregarLinea(tabla, cfilas, codigo, cantidad, NombreProduct, precio, subTotal, miva, total);
               }
               CalcularTotales(tabla, cfilas);

               $("#txtCodigo").val('');
               $("#txtCodigo").focus();
          } else {
               swal('', info.msg, "info");
          }
     });
});
//#endregion

//#region -----------------> AGREGAR DATOS A LA TABLA <-------------------------
btnAgregarProducto.onclick = function () {
     codigo = document.querySelector("#codigo").value;
     cantidad = document.querySelector("#Cantidad").value;
     precio = document.querySelector("#Precio").value;
     let stock = parseInt($('#Stock').val());

     if (codigo == '') {
          $("#nombreProducto").focus();
          swal("", "Debe agregar un producto", "error");
          return false;
     } else if (cantidad == '') {
          $("#Cantidad").focus();
          swal("", "Agregar cantidad válida", "error");
          return false;
     } else if (stock < cantidad) {
          swal('', `Solo hay ${stock} en existencia`, "info");
          return false;
     }

     // ------------ PROCESO EN CASO DE QUE SEA EL PRIMER PRODUCTO ------------------------------
     if (cfilas == 0) {
          CalcularTotalLinea(Number(precio), Number(cantidad));
          cfilas += 1;
          AgregarLinea(tabla, cfilas, codigo, cantidad, NombreProducto.value, precio, subTotal, miva, total);
     }
     // ------------ PROCESO EN CASO DE QUE YA EXISTA EL PRODUCTO -------------------------------
     else {
          // ------------ SI EXISTE EL CODIGO SE ACTUALIZA LAS CANTIDADES Y TOTALES DE LINEA -------------------------------
          if (buscarCodigo(tabla, codigo)) {
               NuevaCantidad = Number(CantExistente) + Number(cantidad);
               tabla.fnUpdate(`<div class="w-100"><input name="cantidadT" id="cantidadT" type="number" value="${NuevaCantidad}" min="1" class="form-control text-center" ></div>`, nfila, 2, 0, false);

               NuevoIva = (precio * porceIva) * NuevaCantidad;
               tabla.fnUpdate(Number.parseFloat(NuevoIva).toFixed(2), nfila, 6, 0, false);

               NuevoSubtotal = (precio * NuevaCantidad);
               tabla.fnUpdate(Number.parseFloat(NuevoSubtotal).toFixed(2), nfila, 5, 0, false);

               NuevoTotal = NuevoSubtotal + NuevoIva;
               tabla.fnUpdate(Number.parseFloat(NuevoTotal).toFixed(2), nfila, 7, 0, false);
               /* Dato, nfila, ncolumna, 0, false */

               // se cambia a falso por que en el if del for no se implemento el else, para que no se ejecute tantas veces por si no se valida el if
               existe = false;
          }
          // ------------ SI NO EXISTE EL CODIGO DEL PRODUCTO, AGREGA LA INFORMACION A LA TABLA ----------------------
          else {
               CalcularTotalLinea(Number(precio), Number(cantidad));
               cfilas += 1;
               AgregarLinea(tabla, cfilas, codigo, cantidad, NombreProducto.value, precio, subTotal, miva, total);
          }
     }
     $("#nombreProducto").focus();
     LimpiarCampos();
     CalcularTotales(tabla, cfilas);
};

function buscarCodigo(tabla, codigo) {
     infoTable = tabla.fnGetNodes();
     for (let i = 0; i < infoTable.length; i++) {
          if (infoTable[i].cells[1].innerHTML == codigo) {
               existe = true;
               CantExistente = infoTable[i].cells[2].childNodes[0].children.cantidadT.value;
               nfila = i;
               break;
          }
     };
     return existe;
}

function AgregarLinea(tabla, cfilas, codigo, cantidad, NombreProducto, precio, subTotal, miva, total) {
     tabla.fnAddData([
          cfilas,
          codigo,
          `<div class="w-100"><input name="cantidadT" id="cantidadT" type="number" value="${cantidad}" min="1" class="form-control text-center"></div>`,
          `<div class="w-100">${NombreProducto}</div>`,
          Number.parseFloat(precio).toFixed(2),
          Number.parseFloat(subTotal).toFixed(2),
          Number.parseFloat(miva).toFixed(2),
          Number.parseFloat(total).toFixed(2),
          `<div class="flex-center"> <div class="btn-group"> <i id="btnEliminarLinea" class="fa fa-trash btn btn-danger2" title="Eliminar Linea"></i> </div> </div>`,
     ]);
}
//#endregion

//#region -----------------> FUNCIONES DE LA TABLA <-------------------------
$(document).on('change', '#cantidadT', function (e) {
     e.preventDefault();
     // obtener la fila a editar
     filaEditar = $(this).closest("tr").get(0);
     nFila = filaEditar._DT_RowIndex;

     // De la tabla obtiene los datos de esa fila 
     data = tabla.fnGetData(nFila);
     let preUnitario = data[4];
     codigo = data[1];

     const url = `${base_url}facturacion/getProducto`;
     const datos = new FormData();
     datos.append('op', 'data');
     datos.append('dato', codigo);
     let cant = e.target.value;

     const response = fnt_Fetch(url, 'post', datos);
     response.then((info) => {
          if (info.status) {
               if (parseInt(info.data.cantidad) >= parseInt(cant)) {
                    CalcularTotalLinea(Number(preUnitario), Number(cant));

                    tabla.fnUpdate(subTotal.toFixed(2), nFila, 5, 0, false);
                    tabla.fnUpdate(miva.toFixed(2), nFila, 6, 0, false);
                    tabla.fnUpdate(total.toFixed(2), nFila, 7, 0, false);

                    CalcularTotales(tabla, cfilas);

                    if (select_TipoPago.value == 4) {
                         validaCredito();
                    }
               } else {
                    tabla.fnUpdate(`<div class="w-100"><input name="cantidadT" id="cantidadT" type="number" value="${parseInt(info.data.cantidad)}" min="1" class="form-control text-center"></div>`, nFila, 2, 0, false);

                    if (select_TipoPago.value == 4) {
                         validaCredito();
                    }

                    swal('', `Solo hay ${parseInt(info.data.cantidad)} en existencia`, "info");
               }
          } else {
               swal('', info.msg, "info");
          }
     });
});

$(document).on('click', '#btnEditarLinea', function (e) {
     e.preventDefault();
     // obtener la fila a editar
     filaEditar = $(this).closest("tr").get(0);
     // De la tabla obtiene los datos de esa fila 
     data = tabla.fnGetData(filaEditar._DT_RowIndex);
     // Imprime la posicion 1 del array, o sea, el Codigo del Producto
     $("#nombreProducto").val(data[2]); // nombre
     $("#Cantidad").val(data[1]); // cantidad
     $("#Precio").val(data[3]); // prec unit

     document.getElementById('add').style.display = 'none';
     document.getElementById('update').style.display = 'block';
});

$(document).on('click', '#btnActualizarProducto', function (e) {
     e.preventDefault();
     // OBTENER LA FILA SELECCIONADA
     nFila = filaEditar._DT_RowIndex;

     CalcularTotalLinea($("#Precio").val(), $("#Cantidad").val());

     // SE ACTUALIZAN LOS CAMPOS EN LA TABLA
     /* Orden de los campos: Dato nuevo, nfila, ncolumna, 0, false */
     $("#cantidadT").val($("#Cantidad").val())
     // tabla.fnUpdate($("#Cantidad").val(), nFila, 1, 0, false);
     tabla.fnUpdate(subTotal.toFixed(2), nFila, 4, 0, false);
     tabla.fnUpdate(iva.toFixed(2), nFila, 5, 0, false);
     tabla.fnUpdate(total.toFixed(2), nFila, 6, 0, false);

     CalcularTotales(tabla, cfilas);

     LimpiarCampos();
     document.getElementById('add').style.display = 'block';
     document.getElementById('update').style.display = 'none';
});

$(document).on('click', '#btnEliminarLinea', function (e) {
     e.preventDefault();
     var row = $(this).closest("tr").get(0);
     tabla.fnDeleteRow(tabla.fnGetPosition(row));
     cfilas -= 1;

     CalcularTotales(tabla, cfilas);
     validaCredito();
});
//#endregion

//#region -----------------> CALCULOS <-------------------------
function CalcularTotalLinea(precio, cantidad) {
     miva = (precio * porceIva) * cantidad;
     subTotal = precio * cantidad;
     total = subTotal + miva;
}

function CalcularTotales(tabla, cfilas) {
     var SubTotal = 0,
          TotalFactura = 0,
          SubTotalIVA = 0;

     for (var i = 0; i < cfilas; i++) {
          DatosTabla = tabla.fnGetData(i);

          SubTotal += Number(DatosTabla[5]);
          SubTotalIVA += Number(DatosTabla[6]);
          TotalFactura += Number(DatosTabla[7]);
     }

     document.querySelector("#Subtotal").value = Number.parseFloat(SubTotal).toFixed(2);
     document.querySelector("#Subtotal1").value = Number.parseFloat(SubTotal).toFixed(2);
     document.querySelector("#iva").value = Number.parseFloat(SubTotalIVA).toFixed(2);
     document.querySelector("#iva1").value = Number.parseFloat(SubTotalIVA).toFixed(2);
     document.querySelector("#totalFactura").value = Number.parseFloat(TotalFactura).toFixed(2);
     document.querySelector("#totalFactura1").value = Number.parseFloat(TotalFactura).toFixed(2);
     document.querySelector("#totalFacturaLbl").innerHTML = Math.round(TotalFactura).toFixed(2);
}
//#endregion

//#region -----------------> OTRAS FUNCIONES <-------------------------
function getTipoDocumento() {
     const url = `${base_url}facturacion/getTipoDocumento`
     const response = fnt_Fetch(url);
     response.then((res) => {
          if (res.status) {
               arrTipoDoc = res.data;

               for (let i = 0; i < arrTipoDoc.length; i++) {
                    select_TipoDocumento.options[i] = new Option(
                         arrTipoDoc[i]["nombre"],
                         arrTipoDoc[i]["codigo"]
                    );
               }
               select_TipoDocumento.options[2].defaultSelected = true;
          } else {
               swal('', res.msg, "error");
          }
     });
}

function getTipoPago() {
     const url = `${base_url}facturacion/getTipoPago`
     const response = fnt_Fetch(url);
     response.then((res) => {
          if (res.status) {
               arrTipoDoc = res.data;

               for (let i = 0; i < arrTipoDoc.length; i++) {
                    select_TipoPago.options[i] = new Option(
                         arrTipoDoc[i]["nombre"],
                         arrTipoDoc[i]["id"]
                    );
               }
               select_TipoPago.options[0].defaultSelected = true;
          } else {
               swal('', res.msg, "error");
          }
     });
}

function LimpiarCampos() {
     document.querySelector("#nombreProducto").value = '';
     document.querySelector("#codigo").value = '';
     document.querySelector("#Cantidad").value = '';
     document.querySelector("#Precio").value = '';
     document.querySelector("#Stock").value = '';
}

$('#tipoPago').on('change', (e) => {
     tipoPago = e.target.value;

     if (tipoPago == 4) {
          validaCredito();
     } else {
          document.querySelector('#btnFacturar').removeAttribute('disabled');
     }
});

function validaCredito() {
     if (Number(creditoActual) == "" || estadoCredito == 0) {
          swal('', `El cliente no tiene crédito disponible`, "warning");
          document.querySelector('#btnFacturar').setAttribute('disabled', '');

          return false;
     }

     if (Number(creditoActual) < Number(totalFactura.value)) {
          swal('', `El cliente sobre pasa el limite de crédito. Saldo actual ${creditoActual} colones`, "warning");
          document.querySelector('#btnFacturar').setAttribute('disabled', '');

          return true;
     } else {
          document.querySelector('#btnFacturar').removeAttribute('disabled');

          return false;
     }
}

$("#Nombre").on({
     keydown: (e) => {
          return (e.key.length != 1 || 1 + e.key.search(/[a-zA-Z]/)) ? true : false;
     },
     paste: function (e) {
          return false;
     }
});

$("#Identificacion").on({
     keydown: (e) => {
          return (e.key.length != 1 || 1 + e.key.search(/^[0-9]/)) ? true : false;
     },
     paste: function (e) {
          return false;
     }
});

function FechaActual() {
     var fecha = new Date(); //Fecha actual
     var mes = fecha.getMonth() + 1; //obteniendo mes
     var dia = fecha.getDate(); //obteniendo dia
     var anho = fecha.getFullYear(); //obteniendo año
     if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
     if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
     var fchActual = document.querySelectorAll('#Fecha');
     fchActual.forEach(function (fchActual) {
          fchActual.value = dia + "/" + mes + "/" + anho;
     })
};

function getUrl() {
     var loc = window.location;
     var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
     alert(loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length)));
}
//#endregion

//#region -----------------> FACTURACION <-------------------------
$('#btnFacturar').click(function (e) {
     e.preventDefault();
     infoTable = tabla.fnGetNodes();
     if (infoTable.length > 0) {
          switch (select_TipoPago.selectedIndex) {
               case 0:
                    // Efectivo
                    PagoRecibido();
                    break;
               case 1:
                    // Tarjeta
                    PagoTarjeta();
                    break;
               case 2:
                    // Sinpe
                    PagoTarjeta();
                    break;
               case 3:
                    // Credito
                    if (!validaCredito()) {
                         PagoRecibido();
                    }
                    break;

               default:
                    break;
          }
     } else {
          swal('', 'No hay datos para procesar', "info");
     }
});

let modal = `<div class="form-group text-left">
                    <label for="pagaCon" class="control-label">Monto:</label>
                    <input id="pagaCon" type="text" class="form-control" name="pagaCon" placeholder="Digite monto recibido">
               </div>
               
               <div class="form-group text-left">
                    <label for="nComprobante" class="control-label">Número de Comprobante</label>
                    <input id="nComprobante" type="text" class="form-control" name="nComprobante" placeholder= "Digite número de comprobante" autocomplete="off">
               </div>
               <div class="input-group">
                    <input type="checkbox" class="form-check" name="MontoAdelanto" id="MontoAdelanto" > Es adelanto?
                </div>`;

function PagoRecibido() {
     const totalFactura = document.querySelector("#totalFactura").value;

     if (select_TipoPago.value == 4) {
          guardarDatos(totalFactura, 0.00, 0);
     } else {
          Swal.fire({
               title: 'Total: ' + totalFactura,
               html: modal,
               // text: 'Paga con:',
               // input: 'text',
               inputAttributes: {
                    autocapitalize: 'off'
               },
               showCancelButton: true,
               confirmButtonText: 'Facturar',
               showLoaderOnConfirm: true,
               confirmButtonColor: '#35b8e0',
               cancelButtonColor: '#6c757d',
               preConfirm: (pagaCon) => {
                    if (pagaCon != "") {
                         if (parseFloat(pagaCon) >= parseFloat(totalFactura)) {
                              return JSON.stringify({ pagaCon: pagaCon, montoCancelar: totalFactura })
                         } else {
                              swal("Atención", "Revisar monto digitado", 'warning')
                              return false;
                         }
                    } else {
                         swal("", "Digitar dinero recibido", 'info')
                         return false;
                    }
               },
               allowOutsideClick: false,
          }).then((result) => {
               if (result.isConfirmed) {
                    var data = JSON.parse(result.value)
                    let vuelto = Math.round(data.pagaCon - data.montoCancelar);
                    guardarDatos(data.pagaCon, vuelto, 0);
               }
               // else if (result.isDismissed) {
               //      swal("", "No se a realizado el pago", 'warning')
               // }
          });
     }
}

function PagoTarjeta() {
     const totalFactura = document.querySelector("#totalFactura").value;

     Swal.fire({
          title: 'Total: ' + totalFactura,
          html:
               `<div class="form-group text-left">
                    <label for="pagaCon" class="control-label">Monto:</label>
                    <input id="pagaCon" type="text" class="form-control" name="pagaCon" placeholder="Monto recibido">
               </div>
               <div class="form-group text-left">
                    <label for="nComprobante" class="control-label">Número de Comprobante</label>
                    <input id="nComprobante" type="text" class="form-control" name="nComprobante" placeholder= "Número de comprobante" autocomplete="off">
               </div>`,
          confirmButtonText: 'Facturar',
          confirmButtonColor: '#35b8e0',
          showCancelButton: true,
          cancelButtonColor: '#6c757d',
          focusConfirm: false,
          preConfirm: () => {
               const pagaCon = document.getElementById('pagaCon');
               const nComprobante = document.getElementById('nComprobante');

               if (pagaCon.value != "" && nComprobante.value != "") {
                    if (parseFloat(pagaCon.value) >= parseFloat(totalFactura)) {
                         return JSON.stringify({ pagaCon: pagaCon.value, nComprobante: nComprobante });
                    } else {
                         pagaCon.focus();
                         swal("Atención", "Revisar monto digitado", 'warning')
                         return false;
                    }
               } else {
                    pagaCon.focus();
                    swal("", "Digitar dinero recibido y número de comprobante", 'error')
                    return false;
               }
          },
          allowOutsideClick: false
     }).then((result) => {
          if (result.isConfirmed) {
               var data = JSON.parse(result.value)
               guardarDatos(data.pagaCon, 0.00, data.nComprobante);
          } else if (result.isDismissed) {
               swal("", "No se a realizado el pago", 'warning')
          }
     });
}

function guardarDatos(pagaCon, vuelto, nComprobante) {
     const frmFacturacion = document.querySelector("#frmFacturacion");
     const frmDatos = new FormData(frmFacturacion);
     const url = `${base_url}facturacion/insertEncaFactura`
     const response = fnt_Fetch(url, 'post', frmDatos);
     response.then((res) => {
          if (res.status) {
               const detaFactura = Array();
               const idVenta = res.id;

               for (let i = 0; i < infoTable.length; i++) {
                    let codProducto = infoTable[i].cells[1].innerHTML;
                    let cantidadProducto = infoTable[i].cells[2].childNodes[0].children.cantidadT.value;
                    let precioUnit = infoTable[i].cells[4].innerHTML;
                    let subTotal = infoTable[i].cells[5].innerHTML;
                    let iva = infoTable[i].cells[6].innerHTML;
                    let total = infoTable[i].cells[7].innerHTML;

                    detaFactura.push({ idVenta, codProducto, cantidadProducto, precioUnit, subTotal, iva, total });
               };

               const url = `${base_url}facturacion/insertDetaFactura`
               $.post(url, { datos: detaFactura }, (info) => {
                    const response = JSON.parse(info)
                    if (response.status) {
                         GenerarFactura(idVenta, select_TipoDocumento.value, pagaCon, vuelto);

                         if (nComprobante != 0) {
                              insertar_nComprobante(idVenta, nComprobante);
                         }

                         if (select_TipoPago.value == 4) {
                              insertar_FacturaCredito(idVenta);
                         }
                    } else {
                         swal("", response.msg, "error");
                    }
               });
          } else {
               swal('', res.msg, "error");
          }
     });
}

const GenerarFactura = async (idVenta, tipoFactura, pagaCon, Vuelto) => {
     const url = `${base_url}facturacion/GeneraFactura`
     datos = new FormData();
     datos.append('idVenta', idVenta);
     datos.append('tipoFactura', tipoFactura);

     const response = fnt_Fetch(url, 'post', datos);
     response.then((response) => {
          if (response.status) {
               const enviarFactura = swalEnviarFactura(`Vuelto: ${Vuelto}`, `¿Enviarle el documento #${response.nfactura} al correo del cliente?`, "question")
               enviarFactura.then((result) => {
                    if (result.isConfirmed) {
                         generarPDF(idVenta, pagaCon, Vuelto);
                         setTimeout(() => {
                              enviarFacturaPDF(response.emailCliente, response.nfactura);
                         }, 100);
                    } else {
                         generarPDF(idVenta, pagaCon, Vuelto);
                         location.reload();
                    }
               });
          } else {
               swal('', response.msg, 'error');
          }
     })
}

function insertar_nComprobante(idVenta, nComprobante) {
     const frmDatos = new FormData();
     frmDatos.append('idVenta', idVenta);
     frmDatos.append('nComprobante', nComprobante);

     const url = `${base_url}facturacion/insertarComprobante`
     const response = fnt_Fetch(url, 'post', frmDatos);
     response.then((res) => {
          console.log(`Comprobante insertado. Mensaje: ${res.msg}`);
     });
}

function insertar_FacturaCredito(idVenta) {
     const frmDatos = new FormData();
     frmDatos.append('idVenta', idVenta);

     const url = `${base_url}facturacion/insertFacturaCredito`
     const response = fnt_Fetch(url, 'post', frmDatos);
     response.then((res) => {
          console.log(res);
     });
}
//#endregion


// $('#modal').click(function (e) {
//      e.preventDefault();
//      Swal.fire({
//           title: 'Total: ' + totalFactura,
//           html: modal,
//           confirmButtonText: 'Facturar',
//           confirmButtonColor: '#35b8e0',
//           showCancelButton: true,
//           cancelButtonColor: '#6c757d',
//           focusConfirm: false,
//           preConfirm: () => {
//                const pagaCon = document.getElementById('pagaCon');
//                const nComprobante = document.getElementById('nComprobante');

//                if (pagaCon.value != "" && nComprobante.value != "") {
//                     if (parseFloat(pagaCon.value) >= parseFloat(totalFactura)) {
//                          return JSON.stringify({ pagaCon: pagaCon.value, nComprobante: nComprobante });
//                     } else {
//                          pagaCon.focus();
//                          swal("Atención", "Revisar monto digitado", 'warning')
//                          return false;
//                     }
//                } else {
//                     pagaCon.focus();
//                     swal("", "Digitar dinero recibido y número de comprobante", 'error')
//                     return false;
//                }
//           },
//           allowOutsideClick: false
//      }).then((result) => {
//           if (result.isConfirmed) {
//                var data = JSON.parse(result.value)
//                guardarDatos(data.pagaCon, 0.00, data.nComprobante);
//           }
//           // else if (result.isDismissed) {
//           //      swal("", "No se a realizado el pago", 'warning')
//           // }
//      });

// });