<?php

namespace App\Livewire\Dashboard;

use App\Models\AjusDetalle;
use App\Models\Ajuste;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Empresa;
use App\Models\Stock;
use App\Models\Unidad;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class StockComponent extends Component
{
    use LivewireAlert;

    public $rows = 0;
    public $empresas_id, $empresa, $viewMovimientos = false;
    public $modalEmpresa, $modalArticulo, $modalStock, $modalUnidad;
    public $getNombre, $getAjustes, $getAlmacen, $getLimit = 15, $getSaldo, $modulo = 'stock';
    public $limit = 100;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $this->empresa = Empresa::find($this->empresas_id);
        //stock
        $stockAlmacenes = Almacen::where('empresas_id', $this->empresas_id)->get();
        $stockAlmacenes->each(function ($almacen){
            $stock = Stock::where('empresas_id', $this->empresas_id)
                ->where('almacenes_id', $almacen->id)
                ->orderBy('actual', 'DESC')
                ->limit($this->rows)
                ->get();
            $almacen->stock = $stock;
        });

        return view('livewire.dashboard.stock-component')
            ->with('stockAlmacenes', $stockAlmacenes);
    }

    public function setLimit()
    {
        if (numRowsPaginate() < 10) { $rows = 10; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
    }

    #[On('getEmpresaStock')]
    public function getEmpresaStock($empresaID)
    {
        $this->empresas_id = $empresaID;
    }

    public function limpiarStock()
    {
        $this->reset([
            'getAjustes', 'getAjustes', 'getLimit', 'getNombre', 'getSaldo', 'viewMovimientos'
        ]);
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
        if ($this->getLimit > $this->limit){
            $this->limit = $this->limit + 100;
        }

        $this->getAlmacen = $id;
        $almacen = Almacen::find($this->getAlmacen);
        $this->getNombre = $almacen->nombre;
        $this->getAjustes = Ajuste::where('empresas_id', $this->empresas_id)
            ->orderBy('fecha', 'DESC')
            ->limit($this->limit)
            ->get();
        $this->getAjustes->each( function ($ajuste){
            $ajuste->detalles = AjusDetalle::where('ajustes_id', $ajuste->id)
                ->where('almacenes_id', $this->getAlmacen)->get();
            $ajuste->detalles->each(function ($detalle){
                $stock = Stock::where('empresas_id', $this->empresas_id)
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
        if (numRowsPaginate() < 10) { $rows = 10; } else { $rows = numRowsPaginate(); }
        $this->getLimit = $this->getLimit + $rows;
        $this->verMovimientos($this->getAlmacen);
    }

    public function irAjuste($id)
    {
        /*$this->verAjustes();
        $this->showAjustes($id);
        $this->dispatch('buscar', keyword: $this->ajuste_codigo);*/
        $this->alert('success', 'pendiente');
    }

    /*public function show()
    {
        if ($this->getAlmacen){
            $this->verMovimientos($this->getAlmacen);
        }
    }*/

}
