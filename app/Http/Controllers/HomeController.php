<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Catalogo_Producto_Servicio;
use App\Models\Catalogo_Regimen_Fiscal;
use App\Models\Catalogo_Uso_CFDI;
use App\Models\Catalogo_Metodo_Pago;
use App\Models\Catalogo_Forma_Pago;
use App\Models\Catalogo_Unidad;
use App\Models\Facturas;
use App\Models\Conceptos;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $regimenFiscales = Catalogo_Regimen_Fiscal::all();
        $usoCFDI = Catalogo_Uso_CFDI::all();
        $metodosPago = Catalogo_Metodo_Pago::all();
        $formasPago = Catalogo_Forma_Pago::all();
        $clavesUnidad = Catalogo_Unidad::all()->take(200);
        $facturas = Facturas::all()->where('usuario_id', Auth::user()->id);
        return view('home', ['regimenFiscales' => $regimenFiscales, 'usosCFDI' => $usoCFDI, 'metodosPago' => $metodosPago, 'formasPago' => $formasPago
        , 'clavesUnidad' => $clavesUnidad, 'facturas' => $facturas]);
    }
    public function get_Productos_Servicios(){
        echo json_encode(Catalogo_Producto_Servicio::all()->take(100));
    }
    
    public function generar_Factura(Request $request)
    {
        $comprobanteAtributos = [
                'Serie' => '4.0',
            'Folio' => 'v1',
            'Certificado' => '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'
        ];
        $creator = new \CfdiUtils\CfdiCreator33($comprobanteAtributos);
        $comprobante = $creator->comprobante();
        $factura = new Facturas();
        $factura->usuario_id = Auth::user()->id;
        $factura->descripcion = 'Factura';
        $factura->subtotal = $request['subtotal'];
        $factura->total = $request['total'];
        if($factura->save()){
            $conceptos = new Conceptos();
            $facturas = json_decode($request['datos'], true);
            $comprobante->addReceptor([
                    'IDFactura' => Facturas::latest('id')->first()->id,
                    'Descripcion' => 'Factura',
                    'Subtotal' => $request['subtotal'],
                    'Total' => $request['total'],
                ]);
            foreach ($facturas as $items) {
                $conceptos->factura_id = Facturas::latest('id')->first()->id;
                $conceptos->clave_producto = $items['claveProductoServicio'];
                $conceptos->descripcion = $items['descripcion'];
                $conceptos->nombre_receptor = $items['nombreReceptor'];
                $conceptos->rfc_receptor = $items['rfcReceptor'];
                $conceptos->regimen_fiscal = $items['regimenFiscal'];
                $conceptos->domicilio_fiscal = $items['domicilioFiscalReceptor'];
                $conceptos->forma_pago = $items['formaPago'];
                $conceptos->uso_CFDI = $items['usoCFDI'];
                $conceptos->metodo_pago = $items['metodoPago'];
                $conceptos->clave_unidad = $items['claveUnidad'];
                $conceptos->cantidad = $items['cantidadProd'];
                $conceptos->valor_unitario = $items['valorUnitario'];
                $conceptos->importe = $items['importe'];
                $conceptos->save();
                $comprobante->addConcepto([
                    'ClaveProductoServicio' => $items['claveProductoServicio'],
                    'Descripcion' => $items['descripcion'],
                    'NombreReceptor' => $items['nombreReceptor'],
                    'RFCReceptor' => $items['nombreReceptor'],
                    'RegimenFiscalReceptor' => $items['regimenFiscal'],
                    'DomicilioFiscalReceptor' => $items['domicilioFiscalReceptor'],
                    'MetodoPago' => $items['metodoPago'],
                    'FormaPago' => $items['formaPago'],
                    'UsoCFDI' => $items['usoCFDI'],
                    'ClaveUnidad' => $items['claveUnidad'],
                    'Catidad' => $items['cantidadProd'],
                    'ValorUnitaro' => $items['valorUnitario'],
                    'Importe' => $items['importe'],
                ]);
            }
            $creator->saveXml('./FacturaSAT.xml');
            echo 'Ok datos Guardados';
        } else{
            echo 'NO se guardaron datos Guardados';
        };
    }
}
