<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Municipio;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class TerritorioComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'cerrarModal', 'buscar',
        'limpiarMunicipio', 'confirmedMunicipio'
        ];

    public $viewMunicipio = "create", $keywordMunicipios;
    public $municipio_id, $municipioNombre, $municipioAbreviatura;

    public function render()
    {
        if (numRowsPaginate() < 15){ $paginate = 15; }else{ $paginate = numRowsPaginate(); }

        //$paginate = 3;

        $listarMunicpios = Municipio::buscar($this->keywordMunicipios)->orderBy('nombre', 'ASC')->paginate($paginate, ['*'], 'pageMun');

        if (isset($this->pageMun) && $this->pageMun > 1){
            $numero = $this->pageMun * $paginate;
            $numero = $numero - $paginate;
            $itemMunicipio = $numero;
        }else{
            $itemMunicipio = 0;
        }

        return view('livewire.dashboard.territorio-component')
            ->with('listarMunicipios', $listarMunicpios)
            ->with('itemMunicipio', $itemMunicipio);
    }

    public function limpiarMunicipio()
    {
        $this->resetErrorBag();
        $this->reset([
            'viewMunicipio', 'municipio_id', 'municipioNombre', 'municipioAbreviatura', 'keywordMunicipios'
        ]);
    }

    public function saveMunicipio()
    {
        $rules = [
            'municipioNombre' => ['required', 'min:6', Rule::unique('municipios', 'nombre')->ignore($this->municipio_id)],
            'municipioAbreviatura' => ['required', 'min:4', Rule::unique('municipios', 'mini')->ignore($this->municipio_id)],
        ];

        $messages = [
            'municipioNombre.required' => 'El nombre del municipio es obligatorio.',
            'municipioNombre.min' => 'El nombre debe contener al menos 6 caracteres.',
            'municipioNombre.alpha_num' => 'El nombre sólo debe contener letras y números. ',
            'municipioNombre.unique' => 'El nombre del municipio ya ha sido registrado.',
            'municipioAbreviatura.required' => 'La Abreviatura es obligatoria.',
            'municipioAbreviatura.min' => 'La Abreviatura debe contener al menos 4 caracteres.',
            'municipioAbreviatura.alpha_num' => 'La Abreviatura sólo debe contener letras y números.',
            'municipioAbreviatura.unique' => 'La Abreviatura ya ha sido registrada.'
        ];

        $this->validate($rules, $messages);


        if (is_null($this->municipio_id)){
            //nuevo
            $municipio = new Municipio();
            $message = "Municipio Creado.";
        }else{
            //editar
            $municipio = Municipio::find($this->municipio_id);
            $message = "Municipio Actualizado.";
        }

        $municipio->nombre = ucwords($this->municipioNombre);
        $municipio->mini = ucfirst($this->municipioAbreviatura);
        $municipio->save();

        $this->emit('cerrarModal', 'municipio_btn_cerrar');

        $this->alert('success', $message);

    }

    public function editMunicipio($id)
    {
        $this->limpiarMunicipio();
        $this->viewMunicipio = "edit";
        $municipio = Municipio::find($id);
        $this->municipio_id = $municipio->id;
        $this->municipioNombre = $municipio->nombre;
        $this->municipioAbreviatura = $municipio->mini;
    }

    public function estatusMunicipio($id)
    {
        $municipio = Municipio::find($id);
        if ($municipio->estatus){
            $municipio->estatus = 0;
            $type = 'info';
            $message = $municipio->mini." Inactivo.";
        }else{
            $municipio->estatus = 1;
            $type = 'success';
            $message = $municipio->mini." Activo.";

        }
        $municipio->save();
        $this->alert($type, $message);
    }

    public function destroyMunicipio($id)
    {
        $this->municipio_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => '¡Sí, bórralo!',
            'text' => '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedMunicipio',
        ]);
    }

    public function confirmedMunicipio()
    {
        // Example code inside confirmed callback
        $validar = false;

        if ($validar) {

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

            $municipio = Municipio::find($this->municipio_id);
            $nombre = $municipio->mini;
            $municipio->delete();
            $this->limpiarMunicipio();
            $this->alert('success',$nombre. ' Eliminado.');
        }
    }

    public function buscar($keyword)
    {
        $this->keywordMunicipios = $keyword;
    }

    public function cerrarModal($selector)
    {
        //JS
    }

}
