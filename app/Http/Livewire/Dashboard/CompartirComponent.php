<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Empresa;
use App\Models\Stock;
use App\Models\Unidad;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CompartirComponent extends Component
{
    use LivewireAlert;

    public $empresa_id, $empresa;
    public $view = "stock", $viewMovimientos = false;
    public $modalEmpresa, $modalArticulo, $modalStock, $modalUnidad;

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
            'view', 'viewMovimientos'
        ]);
    }

    public function actualizar()
    {
        //$this->alert('success', 'Stock Actualizado.');
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

    public function verMovimientos()
    {
        $this->viewMovimientos = true;
    }

}
