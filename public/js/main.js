
$(document).ready(()=>{
    const facturaDatos = [];
    function cajafacturas(){
        let subtotal = 0, total = 0;
        $('#cajaFacturas').empty();
        facturaDatos.push({
            nombreReceptor: $('#nombreReceptor').val(),
            rfcReceptor: $('#rfcReceptor').val(),
            regimenFiscal: $('#regimenFiscal').val(),
            usoCFDI: $('#usoCFDI').val(),
            domicilioFiscalReceptor : $('#domicilioFiscalReceptor').val(),
            claveProductoServicio : $('#claveProductoServicio').val(),
            cantidadProd : $('#cantidadProd').val(),
            claveUnidad : $('#claveUnidad').val(),
            descripcion : $('#descripcion').val(),
            valorUnitario : $('#valorUnitario').val(),
            claveProductoServicio : $('#claveProductoServicio').val(),
            formaPago :$('#formaPago').val(),
            metodoPago :$('#metodoPago').val(),
            importe : $('#importe').val(),
        });
        facturaDatos.map((item)=>{
            subtotal = subtotal + parseFloat(item.importe);
            total = (subtotal * .16);
            total = total + subtotal;
            $('#cajaFacturas').append(`
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Clav Prod. Serv.</th>
                                    <th>Cantidad</th>
                                    <th>Clave Unidad</th>
                                    <th>Método de Pago</th>
                                    <th>Forma de Pago</th>
                                    <th>Descripcion</th>
                                    <th>Valor Unit</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>${item.claveProductoServicio}</td>
                                    <td>${item.cantidadProd}</td>
                                    <td>${item.claveUnidad}</td>
                                    <td>${item.metodoPago}</td>
                                    <td>${item.formaPago}</td>
                                    <td>${item.descripcion}</td>
                                    <td>${item.valorUnitario}</td>
                                    <td>${item.importe}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `)
            // $('#formFactura')[0].reset();
            $('#alertOtroConcepto').show();
            setTimeout(() => {
                $('#alertOtroConcepto').hide();
            }, 3000);
            $('#subTotal').val(subtotal);
            $('#total').val(total);
        });
    }
    function generarFactura(facturasDatos, subtotal, total) {
        let factura = JSON.stringify(facturasDatos);
        axios.post('/generarFactura', {
            datos : factura,
            subtotal: subtotal, 
            total : total
        })
        .then(resolve => resolve.status == 200 ? [
            window.location.href = '/home',
        ] : false);
    }
    $('#tablaFacturas').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });
    $('#alertOtroConcepto').hide();
    axios.get('/get_productosServicios').then(response => {
        response.data.map((item)=>{
            $('#claveProductoServicio').append(`<option value = "${item.clave}">${item.clave} - ${item.descripcion}</option>`)
        })
    });

    $('#cantidadProd').change(()=>{
        $('#importe').val($('#cantidadProd').val() * $('#valorUnitario').val());
    });
    $('#valorUnitario').change(()=>{
        $('#importe').val($('#cantidadProd').val() * $('#valorUnitario').val());
    });
    $('#btnAgregarConcepto').click(()=>{
        $('#btnVerFacturas').removeClass( "d-none" );
        cajafacturas();
    });
    $('#btnGenerarFactura').click(()=>{
        let subtotal = $('#subTotal').val();
        let total = $('#total').val();
        generarFactura(facturaDatos, subtotal, total);
    });
    
});