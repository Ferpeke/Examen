@extends('layouts.main')
@section('titulo', 'CFDI')
@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Llena los siguientes datos CFDI
                        </h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <form class="row g-3" id="formFactura">
                                <div class="col-md-4">
                                    <label for="nombreReceptor" class="form-label">Nombre del Receptor</label>
                                    <input class="form-control" type="text" name="nombreReceptor" id="nombreReceptor"
                                        placeholder="Nombre del Receptor" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="rfcReceptor" class="form-label">RFC</label>
                                    <input type="text" class="form-control" name="rfcReceptor" id="rfcReceptor"
                                        placeholder="RFC del Receptor">
                                </div>
                                <div class="col-md-4">
                                    <label for="regimenFiscal" class="form-label">Régimen Fiscal</label>
                                    <select class="form-select" name="regimenFiscal" id="regimenFiscal"
                                        placeholder="Régimen Fiscal del Receptor" required>
                                        <option value="null">Seleccionar un regimen</option>
                                        @foreach ($regimenFiscales as $regimenFiscal)
                                            <option value="{{ $regimenFiscal->clave }}">{{ $regimenFiscal->clave }} - {{ $regimenFiscal->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="usoCFDI" class="form-label">Uso del CFDI</label>
                                    <select  class="form-select" name="usoCFDI" id="usoCFDI"
                                        placeholder="Uso del CFDI" required>
                                        <option value="null">Selecciona el uso CFDI</option>
                                        @foreach ($usosCFDI as $usoCFDI)
                                            <option value="{{ $usoCFDI->clave }}">{{ $usoCFDI->clave }} - {{ $usoCFDI->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="domicilioFiscalReceptor" class="form-label">Domicilio Fiscal del
                                        Receptor</label>
                                    <input type="number" class="form-control w-50" name="domicilioFiscalReceptor"
                                        id="domicilioFiscalReceptor" placeholder="Código Postal" required>
                                </div>

                                <hr>
                                <div class="alert alert-success alert-dismissible fade show" id="alertOtroConcepto" role="alert">
                                    <p>¡Agrega un nuevo concepto!</p>
                                </div>
                                <div>
                                    <h5><Strong>Datos del Producto o Servicio</Strong></h5>
                                </div>

                                <div class="col-md-4">
                                    <label for="claveProductoServicio" class="form-label">Clave del Producto o Servicio</label>
                                    <select class="form-select" name="claveProductoServicio" id="claveProductoServicio" required>
                                        <option value="null">Selecciona la Clave</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="cantidadProd" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" name="cantidadProd" id="cantidadProd" min="0" required value="0">
                                </div>
                                <div class="col-md-2">
                                    <label for="valorUnitario" class="form-label">Valor Unitario</label>
                                    <input type="number" class="form-control" name="valorUnitario" id="valorUnitario" value="0" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="claveUnidad" class="form-label">Clave unidad</label>
                                    <select class="form-select"  name="claveUnidad" id="claveUnidad"
                                        required> 
                                        <option value="null">Selecciona la Clave de Unidad</option>
                                        @foreach ($clavesUnidad as $claveUnidad)
                                            <option value="{{ $claveUnidad->clave }}">{{ $claveUnidad->clave }} - {{ $claveUnidad->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                </div>
                                <div class="col-md-5">
                                    <label for="metodoPago" class="form-label">Método de Pago</label>
                                    <select id="metodoPago" name="metodoPago" class="form-select" required>
                                        <option value="null">Selecciona el método de Pago</option>
                                        @foreach ($metodosPago as $metodoPago)
                                            <option value="{{ $metodoPago->clave }}">{{ $metodoPago->clave }} - {{ $metodoPago->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="formaPago" class="form-label">Forma de Pago</label>
                                    <select id="formaPago" name="formaPago" class="form-select" required>
                                        <option value="null">Selecciona el método de Pago</option>
                                        @foreach ($formasPago as $formaPago)
                                            <option value="{{ $formaPago->clave }}">{{ $formaPago->clave }} - {{ $formaPago->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="importe" class="form-label">Importe</label>
                                    <input type="number" class="form-control" name="importe" id="importe" value="0" disabled>
                                </div>

                                <div class="col-md-12 d-flex justify-content-end">
                                    <div class="mt-4">
                                        <span class="btn btn-info" id="btnAgregarConcepto">Agregar Concepto</span>
                                        <button type="button" class="btn btn-primary d-none" id="btnVerFacturas" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            Ver Concepto(s)
                                        </button>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                
                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1350px!important;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Conceptos Agregados</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div id="cajaFacturas">

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <hr>
                            </form>
                            <div class="row">
                                <div>
                                    <h5><Strong>Datos Financieros</Strong>
                                </div>
                                <div class="col-md-2">
                                    <label for="subTotal" class="form-label">Subtotal</label>
                                    <input type="text" class="form-control" name="subTotal" id="subTotal" disabled value="0">
                                </div>
                                <div class="col-md-2">
                                    <label for="total" class="form-label">Total</label>
                                    <input type="text" class="form-control" name="total" id="total" disabled value="0">
                                </div>                            
                                <div class="col-md-8 text-md-end text-center mt-1">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#tablaFactura"><i class="fa-solid fa-eye"></i> Tabla Facturas</button>
                                </div>
                                <div class="col-md-12 mt-2 text-center">
                                    <a href="./FacturaSAT.xml" download="./FacturaSAT.xml">
                                        <span  class="btn btn-info w-50" id="btnGenerarFactura">
                                             <i class="fa-solid fa-download"></i> Generar Factura
                                         </span>
                                    </a>
                                </div>
                                <!-- Button trigger modal -->
                                <button >
                                    
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="tablaFactura" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog" style="max-width: 1350px!important;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title text-center" id="staticBackdropLabel">Tabla de Facturas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table id="tablaFacturas" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>ID factura</th>
                                                            <th>Descripción</th>
                                                            <th>Subtotal</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($facturas as $item)
                                                        <tr>
                                                            <td>{{ $item['usuario_id'] }}</td>
                                                            <td>{{ $item['descripcion'] }}</td>
                                                            <td>{{ $item['subtotal'] }}</td>
                                                            <td>{{ $item['total'] }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
