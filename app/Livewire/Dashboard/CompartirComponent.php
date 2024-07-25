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
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class CompartirComponent extends Component
{
    use LivewireAlert;

    public $rows = 0, $numero = 14, $empresas_id, $tableStyle = false;
    public $empresa;
    public $view = "stock", $viewMovimientos = false;
    public $modalEmpresa, $modalArticulo, $modalStock, $modalUnidad;
    public $getNombre, $getAjustes, $getAlmacen, $getLimit = 15, $getSaldo, $modulo = 'compartir';
    public $getDetalles;
    public $viewCuota = false, $municipios, $cuotaMes, $cuotaCodigo, $cuotaFecha, $cuotaAnterior;
    public $modalMunicipio, $modalCenso, $modalDeudaAnterior, $modalDespacho, $modalDeudaTotal, $modalDuedaAcumulada;

    public $rowsMovimientos = 0, $listarMovimientos;
    public $almacenes_id, $almacen;

    public function mount($empresas_id)
    {
        $this->empresas_id = $empresas_id;
        $this->setLimit();
    }

    public function render()
    {
        $this->empresa = Empresa::find($this->empresas_id);
        //stock
        $stockAlmacenes = Almacen::where('empresas_id', $this->empresas_id)->get();
        $stockAlmacenes->each(function ($almacen){
            $stock = Stock::where('empresas_id', $this->empresas_id)
                ->where('almacenes_id', $almacen->id)->orderBy('actual', 'DESC')->limit(100)->get();
            $almacen->stock = $stock;
        });

        return view('livewire.dashboard.compartir-component')
            ->with('stockAlmacenes', $stockAlmacenes);
    }

    public function setLimit()
    {
        if (numRowsPaginate() < $this->numero) {
            $rows = $this->numero;
        } else {
            $rows = numRowsPaginate();
        }
        $this->rows = $this->rows + $rows;
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
        $this->modalStock = Stock::where('empresas_id', $this->empresas_id)
            ->where('articulos_id', $id)
            ->where('unidades_id', $unidad)
            ->get();
    }

    public function verMovimientos($id)
    {
        $this->almacenes_id = $id;
        $this->almacen = Almacen::find($this->almacenes_id);

        $ajustes = Ajuste::where('empresas_id', $this->empresas_id)
            ->where('estatus', 1)
            ->orderBy('created_at', 'DESC')
            ->limit($this->rows)
            ->get();
        $i = 0;
        $listarMovimientos = [];
        foreach ($ajustes as $ajuste){

            $ajustes_id = $ajuste->id;
            $code = $ajuste->codigo;
            $fecha = Carbon::parse($ajuste->created_at)->format('Y-m-d H:i:s');;
            $segmento = null;
            if ($ajuste->segmentos_id){
                $segmento = $ajuste->segmentos->descripcion;
            }

            $detalles = AjusDetalle::where('ajustes_id', $ajuste->id)->where('almacenes_id', $this->almacenes_id)->get();
            $y = 0;
            $listarDetalles = [];
            foreach ($detalles as $detalle){
                $tipo = $detalle->tipo->codigo;
                $articulos_id = $detalle->articulos_id;
                $codigo = $detalle->articulo->codigo;
                $articulo = $detalle->articulo->descripcion;
                $unidades_id = $detalle->unidades_id;
                $unidad = $detalle->unidad->codigo;
                $cantidad = $detalle->cantidad;
                if ($detalle->tipo->tipo == 1){
                    $entrada = true;
                }else{
                    $entrada = false;
                }
                $listarDetalles[$y] = [
                    'tipo' => $tipo,
                    'codigo' => $codigo,
                    'articulo' => $articulo,
                    'unidad' => $unidad,
                    'cantidad' => $cantidad,
                    'entrada' => $entrada,
                    'articulos_id' => $articulos_id,
                    'almacenes_id' => $this->almacenes_id,
                    'unidades_id' => $unidades_id
                ];
                $y++;
                $this->rowsMovimientos++;
            }

            $listarMovimientos[$i] = [
                'tabla' => 'ajustes',
                'id' => $ajustes_id,
                'codigo' => $code,
                'fecha' => $fecha,
                'segmento' => $segmento,
                'detalles' => $listarDetalles
            ];
            $i++;
        }

        $arrayAjustes = $listarMovimientos;

        /*$despachos = Despacho::where('empresas_id', $this->empresas_id)
            ->where('estatus', 1)
            ->orderBy('created_at', 'DESC')
            ->limit($this->rows)
            ->get();

        $i = 0;*/
        $listarMovimientos = [];
        /*foreach ($despachos as $despacho){

            $despachos_id = $despacho->id;
            $code = $despacho->codigo;
            $fecha = Carbon::parse($despacho->created_at)->format('Y-m-d H:i:s');
            $segmento = null;
            if ($despacho->segmentos_id){
                $segmento = $despacho->segmentos->descripcion;
            }

            $detalles = DespDetalle::where('despachos_id', $despacho->id)->where('almacenes_id', $this->almacenes_id)->get();

            foreach ($detalles as $detalle){
                $getTipo = AjusTipo::where('tipo', 2)->first();
                if ($getTipo){
                    $tipo = $getTipo->codigo;
                }else{
                    $tipo = 'S01';
                }

                $recetas = ReceDetalle::where('recetas_id', $detalle->recetas_id)->get();
                $y = 0;
                $listarDetalles = [];
                foreach ($recetas as $receta){
                    $articulos_id = $receta->articulos_id;
                    $codigo = $receta->articulo->codigo;
                    $articulo = $receta->articulo->descripcion;
                    $unidades_id = $receta->unidades_id;
                    $unidad = $receta->unidad->codigo;
                    $cantidad = $detalle->cantidad * $receta->cantidad;
                    $listarDetalles[$y] = [
                        'tipo' => $tipo,
                        'codigo' => $codigo,
                        'articulo' => $articulo,
                        'unidad' => $unidad,
                        'cantidad' => $cantidad,
                        'entrada' => false,
                        'articulos_id' => $articulos_id,
                        'almacenes_id' => $this->almacenes_id,
                        'unidades_id' => $unidades_id
                    ];
                    $y++;
                    $this->rowsMovimientos++;
                }
            }

            $listarMovimientos[$i] = [
                'tabla' => 'despachos',
                'id' => $despachos_id,
                'codigo' => $code,
                'fecha' => $fecha,
                'segmento' => $segmento,
                'detalles' => $listarDetalles
            ];
            $i++;
        }*/

        $arrayDespachos = $listarMovimientos;

        $arrayCombinados = array_merge($arrayAjustes, $arrayDespachos);

        $this->listarMovimientos = collect($arrayCombinados)->sortByDesc('fecha');

        //dd($listarMovimientos);

        /*$stock = Stock::where('empresas_id', $this->empresas_id)
                    ->where('articulos_id', $detalle->articulos_id)
                    ->where('almacenes_id', $detalle->almacenes_id)
                    ->where('unidades_id', $detalle->unidades_id)
                    ->first();
                if ($stock){
                    $this->getSaldo = $stock->actual;
                }else{
                    $this->getSaldo = 0;
                }*/

        //dd($this->rowsMovimientos);

        if ($this->rowsMovimientos > $this->numero) {
            $this->tableStyle = true;
        }
        $this->viewMovimientos = true;
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
                $ajustes = Ajuste::where('empresas_id', $this->empresas_id)
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
                $ajustes = Ajuste::where('empresas_id', $this->empresas_id)
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
