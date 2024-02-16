<?php

namespace App\Livewire\Dashboard;

use App\Models\Ajuste;
use App\Models\Cuota;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class CuotasComponent extends Component
{
    use LivewireAlert;

    public $rows = 0;
    public $cuotas_id, $mes, $codigo, $fecha, $keyword;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $cuotas = Cuota::buscar($this->keyword)
            ->orderBy('codigo', 'DESC')
            ->limit($this->rows)
            ->get()
        ;
        $rowsCuotas = Cuota::count();
        return view('livewire.dashboard.cuotas-component')
            ->with('listarCuotas', $cuotas)
            ->with('rowsCuotas', $rowsCuotas)
            ;
    }

    public function setLimit()
    {
        if (numRowsPaginate() < 10) { $rows = 10; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
    }

    #[On('limpiarCuota')]
    public function limpiarCuota()
    {
        $this->resetErrorBag();
        $this->reset([
            'cuotas_id', 'mes', 'codigo', 'fecha', 'keyword'
        ]);
        $ajustes = Ajuste::where('estatus', 1)->orderBy('codigo', 'DESC')->limit(1000)->get();
        $data = array();
        foreach ($ajustes as $row){
            $option = [
                'id' => $row->codigo,
                'text' => $row->codigo
            ];
            array_push($data, $option);
        }
        $this->dispatch('selectCuotasCodigo', codigos: $data);
    }

    public function save()
    {
        $rules = [
            'codigo' => ['required', 'min:2', 'max:8', 'alpha_dash:ascii', Rule::unique('cuotas', 'codigo')->ignore($this->cuotas_id)],
            'mes' => 'required',
            'fecha' => 'required',
        ];
        $messages = [
            'codigo.required' => 'El codigo es obligatorio.',
            'codigo.min' => 'El codigo debe contener al menos 2 caracteres.',
            'codigo.max' => 'El codigo no debe ser mayor que 6 caracteres.',
            'codigo.alpha_num' => 'El codigo sólo debe contener letras, números, guiones y guiones bajos.',
            'mes.required' => 'El mes es obligatorio.',
            'fecha.required' => 'La fecha es obligatoria.',
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->cuotas_id)) {
            //nuevo
            $cuota = new Cuota();
            $message = "Nueva Cuota Creada.";
        } else {
            //editar
            $cuota = Cuota::find($this->cuotas_id);
            $message = "Cuota Actualizada.";
        }
        $cuota->codigo = $this->codigo;
        $cuota->mes = $this->mes;
        $cuota->fecha = $this->fecha;
        $cuota->save();

        $this->edit($cuota->id);

        $this->alert(
            'success',
            $message
        );

    }

    public function edit($id)
    {
        $cuota = Cuota::find($id);
        $this->cuotas_id = $cuota->id;
        $this->mes = $cuota->mes;
        $this->codigo = $cuota->codigo;
        $this->fecha = $cuota->fecha;
        $this->dispatch('setCuotaSelect', codigo: $this->codigo);
    }

    public function destroy($id)
    {
        $this->cuotas_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => '¡Sí, bórralo!',
            'text' => '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedCuota',
        ]);

    }

    #[On('confirmedCuota')]
    public function confirmedCuota()
    {

        $cuota = Cuota::find($this->cuotas_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;

        if ($vinculado) {
            $this->reset('cuotas_id');
            $this->alert('warning', '¡No se puede Borrar!', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'text' => 'El registro que intenta borrar ya se encuentra vinculado con otros procesos.',
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'OK',
            ]);
        } else {
            $cuota->delete();
            $this->alert(
                'success',
                'Cuota Eliminada.'
            );
            $this->limpiarCuota();
        }
    }

    #[On('cuotaSeleccionada')]
    public function cuotaSeleccionada($codigo)
    {
        $this->codigo = $codigo;
    }

    public function buscar()
    {
        //
    }

    #[On('selectCuotasCodigo')]
    public function selectCuotasCodigo($codigos)
    {
        //JS
    }

    #[On('setCuotaSelect')]
    public function setCuotaSelect($codigo)
    {
        //JS
    }

}
