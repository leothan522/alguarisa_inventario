<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Almacen;
use App\Models\Empresa;
use App\Models\Stock;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CompartirComponent extends Component
{
    use LivewireAlert;

    public $empresa_id, $empresa;

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

    public function actualizar()
    {
        //$this->alert('success', 'Stock Actualizado.');
    }
}
