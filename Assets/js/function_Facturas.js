var tblFacturas;

document.addEventListener("DOMContentLoaded", function () {
     tblFacturas = $("#tblFacturas").DataTable({
          aProcessing: true,
          aServerSide: true,
          dom: "frtp",
          "language": {
               "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },
          ajax: {
               url: ` ${base_url}/facturacion/getFacturas`,
               dataSrc: "",
          },
          columns: [
               {
                    data: "id",
               },
               {
                    data: "nombre",
               },
               {
                    data: "identificacion",
               },
               {
                    data: "fecha",
               },
               {
                    data: "nfactura",
               },
               {
                    data: "m_total",
                    render: $.fn.dataTable.render.number(',', '.', 2,)
               },
               {
                    data: "tipo_factura",
               },
               {
                    data: "tipo_pago",
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
          "iDisplayLength": 12,
     });
});

function fntVerDetalleFactura(idFactura) {
     $("#tblDetalleFactura").DataTable({
          aProcessing: true,
          aServerSide: true,
          dom: "rt",
          "language": {
               "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },
          ajax: {
               url: ` ${base_url}/facturacion/getDetalleFactura/${idFactura}`,
               dataSrc: "",
          },
          columns: [
               {
                    data: "name",
               },
               {
                    data: "cantidad",
               },
               {
                    data: "preUnitario",
                    render: $.fn.dataTable.render.number(',', '.', 2,)
               },
               {
                    data: "subtotal",
                    render: $.fn.dataTable.render.number(',', '.', 2,)
               },
               {
                    data: "iva",
                    render: $.fn.dataTable.render.number(',', '.', 2,)
               },
               {
                    data: "total",
                    render: $.fn.dataTable.render.number(',', '.', 2,)
               },
          ],
          responsive: "true",
          bDestroy: true,
          "iDisplayLength": 12,
     });
}

function fntReenviarFactura(idFactura, emailCliente) {
     enviarFacturaPDF(emailCliente, idFactura);
}