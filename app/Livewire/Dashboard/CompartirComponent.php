<?php

namespace App\Livewire\Dashboard;

use App\Models\AjusDetalle;
use App\Models\Ajuste;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Cuota;
use App\Models\Empresa;
use App\Models\Municipio;
use App\Models\Stock;
use App\Models\Unidad;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class CompartirComponent extends Component
{
    use LivewireAlert;

    public $empresa_id, $empresa;
    public $view = "stock", $viewMovimientos = false;
    public $modalEmpresa, $modalArticulo, $modalStock, $modalUnidad;
    public $getNombre, $getAjustes, $getAlmacen, $getLimit = 15, $getSaldo, $modulo = 'compartir';
    public $getDetalles;
    public $viewCuota = false, $municipios, $cuotaMes, $cuotaCodigo, $cuotaFecha, $cuotaAnterior;
    public $modalMunicipio, $modalCenso, $modalDeudaAnterior, $modalDespacho, $modalDeudaTotal, $modalDuedaAcumulada;

    public function mount($empresa_id)
    {
        $this->empresa_id = $empresa_id;
    }

    public function render()
    {
        $this->empresa = Empresa::find($this->empresa_id);
        //stock
        $stockAlmacenes = Almacen::where('empresas_id', $this->empresa_id)->get();
        $stockAlmacenes->each(function ($almacen){
            $stock = Stock::where('empresas_id', $this->empresa_id)
                ->where('almacenes_id', $almacen->id)->orderBy('actual', 'DESC')->limit(100)->get();
            $almacen->stock = $stock;
        });

        return view('livewire.dashboard.compartir-component')
            ->with('stockAlmacenes', $stockAlmacenes);
    }

    public function limpiarStock()
    {
        $this->reset([
            'view', 'viewMovimientos', 'getAjustes', 'getAlmacen', 'getLimit', 'getNombre', 'getDetalles',
            'viewCuota', 'municipios', 'cuotaMes', 'cuotaCodigo', 'cuotaFecha', 'cuotaAnterior',
            'modalMunicipio', 'modalCenso', 'modalDeudaAnterior', 'modalDespacho', 'modalDeudaTotal', 'modalDuedaAcumulada'
        ]);
    }

    public function actualizar()
    {
        //$this->alert('success', 'Stock Actualizado.');
        if ($this->getAlmacen){
            $this->verMovimientos($this->getAlmacen);
        }
        if ($this->viewCuota){
            $this->verCuota();
        }
    }

    public function verArticulo($id, $unidad)
    {
        $this->modalEmpresa = $this->empresa;
        $this->modalArticulo = Articulo::find($id);
        $this->modalUnidad = Unidad::find($unidad);
        $this->modalStock = Stock::where('empresas_id', $this->empresa_id)
            ->where('articulos_id', $id)
            ->where('unidades_id', $unidad)
            ->get();
    }

    public function verMovimientos($id)
    {
        $this->getAlmacen = $id;
        $almacen = Almacen::find($this->getAlmacen);
        $this->getNombre = $almacen->nombre;
        $this->getAjustes = Ajuste::where('empresas_id', $this->empresa_id)->orderBy('fecha', 'DESC')->get();
        $this->getAjustes->each( function ($ajuste){
            $ajuste->detalles = AjusDetalle::where('ajustes_id', $ajuste->id)
                ->where('almacenes_id', $this->getAlmacen)->get();
            $ajuste->detalles->each(function ($detalle){
                $stock = Stock::where('empresas_id', $this->empresa_id)
                    ->where('articulos_id', $detalle->articulos_id)
                    ->where('almacenes_id', $detalle->almacenes_id)
                    ->where('unidades_id', $detalle->unidades_id)
                    ->first();
                if ($stock){
                    $this->getSaldo = $stock->actual;
                }else{
                    $this->getSaldo = 0;
                }
            });
        });
        $this->viewMovimientos = true;
    }

    public function aumetarLimit()
    {
        $this->getLimit = $this->getLimit * 2;
        $this->verMovimientos($this->getAlmacen);
    }

    #[On('verAjuste')]
    public function verAjuste($detalles_id)
    {
        $this->modalEmpresa = $this->empresa;
        $this->getDetalles = AjusDetalle::find($detalles_id);
    }

    public function verCuota()
    {
        $this->limpiarStock();
        $this->viewCuota = true;
        $cuotas = Cuota::orderBy('fecha', 'DESC')->first();
        if ($cuotas){
            $this->cuotaMes = mesEspanol($cuotas->mes);
            $this->cuotaCodigo = $cuotas->codigo;
            $this->cuotaFecha = verFecha($cuotas->fecha);
            $year = date('Y');
            $anterior = Cuota::where('codigo', '<', $this->cuotaCodigo)
                ->where('fecha', 'LIKE', '%'.$year.'%')
                ->orderBy('fecha', 'DESC')
                ->first();
            if ($anterior){
                $this->cuotaAnterior = $anterior->codigo;
            }
        }
        $this->municipios = Municipio::orderBy('familias', 'DESC')->get();
        $this->municipios->each(function ($municipio){
            $censo = $municipio->familias;
            $total = 0;
            $despachoAnterior = 0;
            $deudaAnterior = 0;
            $despachoActual = 0;
            $deudaActual = 0;

            $contador = 0;
            if ($this->cuotaAnterior){

                //cuota Anterior
                $ajustes = Ajuste::where('empresas_id', $this->empresa_id)
                    ->where('codigo', '>=', $this->cuotaAnterior)
                    ->where('codigo', '<', $this->cuotaCodigo)
                    ->where('segmentos_id', 1)
                    ->where('municipios_id', $municipio->id)
                    ->get();
                foreach ($ajustes as $ajuste){
                    $detalles = AjusDetalle::where('ajustes_id', $ajuste->id)
                        ->where('articulos_id', 1)
                        ->where('unidades_id', 1)
                        ->get();
                    if ($detalles){
                        foreach ($detalles as $detalle){
                            if ($detalle->tipo->tipo == 2){
                                //salida
                                $contador = $contador + $detalle->cantidad;
                            }else{
                                //entrada
                                $contador = $contador - $detalle->cantidad;
                            }
                        }
                    }
                }

                //deuda cuota anterior
                $despachoAnterior = $contador;
                $deudaAnterior = $censo - $despachoAnterior;

            }

            $contador = 0;
            if ($this->cuotaCodigo){

                //cuota Actual
                $ajustes = Ajuste::where('empresas_id', $this->empresa_id)
                    ->where('codigo', '>=', $this->cuotaCodigo)
                    ->where('segmentos_id', 1)
                    ->where('municipios_id', $municipio->id)
                    ->get();
                foreach ($ajustes as $ajuste){
                    $detalles = AjusDetalle::where('ajustes_id', $ajuste->id)
                        ->where('articulos_id', 1)
                        ->where('unidades_id', 1)
                        ->get();
                    if ($detalles){
                        foreach ($detalles as $detalle){
                            if ($detalle->tipo->tipo == 2){
                                //salida
                                $contador = $contador + $detalle->cantidad;
                            }else{
                                //entrada
                                $contador = $contador - $detalle->cantidad;
                            }
                        }
                    }
                }
                //deuda cuota Actual
                $despachoActual = $contador;
                $deudaActual = $censo - $despachoActual;

            }



            $municipio->despachoAnterior = $despachoAnterior;
            $municipio->deudaAnterior = $deudaAnterior;
            $municipio->despachoActual = $despachoActual;
            $municipio->deudaActual = $deudaActual;
            $municipio->deuda = $deudaAnterior + $deudaActual;
        });
    }

    #[On('detalleCuota')]
    public function detalleCuota($municipio, $censo, $deudaAnterior, $despacho, $deudaTotal)
    {
        $this->verCuota();
        $this->modalMunicipio = $municipio;
        $this->modalCenso = formatoMillares($censo, 0);
        $this->modalDeudaAnterior = formatoMillares($deudaAnterior, 0);
        $this->modalDuedaAcumulada = formatoMillares($censo + $deudaAnterior, 0);
        $this->modalDespacho = formatoMillares($despacho, 0);
        $this->modalDeudaTotal = formatoMillares($deudaTotal, 0);
    }

}
