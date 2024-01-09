<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Municipio;
use App\Models\Parroquia;
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
        'limpiarMunicipios', 'confirmedMunicipio', 'confirmedParroquia',
        'selectMunicipios', 'limpiarParroquias', 'municipioSeleccionado', 'editSelectMunicipio'
        ];

    public $viewMunicipio = "create", $keywordMunicipios, $viewParroquia = 'create', $keywordParroquia, $idMunicipio;
    public $municipio_id, $municipioNombre, $municipioAbreviatura, $municipioFamilias;
    public $parroquia_id, $parroquiaNombre, $parroquiaAbreviatura, $parroquiaMunicipio, $parroquiaFamilias;

    public function render()
    {
        if (numRowsPaginate() < 15){ $paginate = 15; }else{ $paginate = numRowsPaginate(); }

        //$paginate = 2;

        $listarMunicipios = Municipio::buscar($this->keywordMunicipios)->orderBy('nombre', 'ASC')->paginate($paginate, ['*'], 'pageMun');
        if (isset($this->pageMun) && $this->pageMun > 1){
            $itemMunicipio = ($this->pageMun * $paginate) - $paginate;
        }else{
            $itemMunicipio = 0;
        }

        $listarParroquias = Parroquia::buscar($this->keywordParroquia, $this->idMunicipio)->orderBy('nombre', 'ASC')->paginate($paginate, ['*'], 'pagePar');
        if (isset($this->pagePar) && $this->pagePar > 1){
            $itemParroquia = ($this->pagePar * $paginate) - $paginate;
        }else{
            $itemParroquia = 0;
        }

        return view('livewire.dashboard.territorio-component')
            ->with('listarMunicipios', $listarMunicipios)
            ->with('itemMunicipio', $itemMunicipio)
            ->with('listarParroquias', $listarParroquias)
            ->with('itemParroquia', $itemParroquia)
            ;
    }

    /* ****************************** MUNICIPIOS ***************************************** */

    public function limpiarMunicipios()
    {
        $this->resetErrorBag();
        $this->reset([
            'viewMunicipio', 'municipio_id', 'municipioNombre', 'municipioAbreviatura', 'keywordMunicipios', 'municipioFamilias'
        ]);
    }

    public function saveMunicipio()
    {
        $rules = [
            'municipioNombre' => ['required', 'min:4', Rule::unique('municipios', 'nombre')->ignore($this->municipio_id)],
            'municipioAbreviatura' => ['required', 'min:4', Rule::unique('municipios', 'mini')->ignore($this->municipio_id)],
            'municipioFamilias' => 'required|integer'
        ];

        $messages = [
            'municipioNombre.required' => 'El nombre del municipio es obligatorio.',
            'municipioNombre.min' => 'El nombre debe contener al menos 4 caracteres.',
            'municipioNombre.alpha_num' => 'El nombre sólo debe contener letras y números. ',
            'municipioNombre.unique' => 'El nombre del municipio ya ha sido registrado.',
            'municipioAbreviatura.required' => 'La Abreviatura es obligatoria.',
            'municipioAbreviatura.min' => 'La Abreviatura debe contener al menos 4 caracteres.',
            'municipioAbreviatura.alpha_num' => 'La Abreviatura sólo debe contener letras y números.',
            'municipioAbreviatura.unique' => 'La Abreviatura ya ha sido registrada.',
            'municipioFamilias.required' => 'El campo familias es obligatorio.',
            'municipioFamilias.integer' => 'El campo familias debe ser un número entero.',
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
        $municipio->familias = $this->municipioFamilias;
        $municipio->save();

        $this->emit('cerrarModal', 'municipio_btn_cerrar');

        $this->alert('success', $message);

    }

    public function editMunicipio($id)
    {
        $this->limpiarMunicipios();
        $this->viewMunicipio = "edit";
        $municipio = Municipio::find($id);
        $this->municipio_id = $municipio->id;
        $this->municipioNombre = $municipio->nombre;
        $this->municipioAbreviatura = $municipio->mini;
        $this->municipioFamilias = $municipio->familias;
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
            $this->limpiarMunicipios();
            $this->alert('success',$nombre. ' Eliminado.');
        }
    }

    /* ****************************** PARROQUIAS ***************************************** */

    public function limpiarParroquias()
    {
        $this->resetErrorBag();
        $this->reset([
            'viewParroquia', 'parroquia_id', 'parroquiaNombre', 'parroquiaAbreviatura', 'parroquiaMunicipio',
            'keywordParroquia', 'idMunicipio', 'parroquiaFamilias'
        ]);
        $municipios = dataSelect2(Municipio::orderBy('nombre', 'ASC')->get());
        $this->emit('selectMunicipios', $municipios);
    }

    public function saveParroquia()
    {
        $rules = [
            'parroquiaMunicipio' => 'required',
            'parroquiaNombre' => ['required', 'min:4', Rule::unique('parroquias', 'nombre')->ignore($this->parroquia_id)],
            'parroquiaAbreviatura' => ['nullable', 'min:4', Rule::unique('parroquias', 'mini')->ignore($this->parroquia_id)],
            'parroquiaFamilias' => 'required|integer'
        ];

        $messages = [
            'parroquiaMunicipio.required' => 'El municipio es obligatorio.',
            'parroquiaNombre.required' => 'El nombre de la parroquia es obligatorio.',
            'parroquiaNombre.min' => 'El nombre debe contener al menos 4 caracteres.',
            'parroquiaNombre.alpha_num' => 'El nombre sólo debe contener letras y números. ',
            'parroquiaNombre.unique' => 'El nombre de la parroquia ya ha sido registrado.',
            'parroquiaAbreviatura.required' => 'La Abreviatura es obligatoria.',
            'parroquiaAbreviatura.min' => 'La Abreviatura debe contener al menos 4 caracteres.',
            'parroquiaAbreviatura.alpha_num' => 'La Abreviatura sólo debe contener letras y números.',
            'parroquiaAbreviatura.unique' => 'La Abreviatura ya ha sido registrada.',
            'parroquiaFamilias.required' => 'El campo familias es obligatorio.',
            'parroquiaFamilias.integer' => 'El campo familias debe ser un número entero.',
        ];

        $this->validate($rules, $messages);

        if (is_null($this->parroquia_id)){
            //nuevo
            $parroquia = new Parroquia();
            $message = "Parroquia Creada.";
        }else{
            //editar
            $parroquia = Parroquia::find($this->parroquia_id);
            $anterior = $parroquia->municipios_id;
            $message = "Parroquia Actualizada." ;
        }

        $parroquia->nombre = ucfirst($this->parroquiaNombre);
        if (!empty($this->parroquiaAbreviatura)){
            $parroquia->mini = ucfirst($this->parroquiaAbreviatura);
        }
        $parroquia->familias = $this->parroquiaFamilias;
        $parroquia->municipios_id = $this->parroquiaMunicipio;
        $parroquia->save();

        if (is_null($this->parroquia_id)){
            //nuevo
            $municipio = Municipio::find($this->parroquiaMunicipio);
            $cantidad = $municipio->parroquias + 1;
            $municipio->parroquias = $cantidad;
            $municipio->save();
        }else{
            //editar
            if ($anterior != $this->parroquiaMunicipio){
                //resto anterior
                $municipio = Municipio::find($anterior);
                $cantidad = $municipio->parroquias - 1;
                $municipio->parroquias = $cantidad;
                $municipio->save();
                //sumo nuevo
                $municipio = Municipio::find($this->parroquiaMunicipio);
                $cantidad = $municipio->parroquias + 1;
                $municipio->parroquias = $cantidad;
                $municipio->save();
            }

        }

        $this->emit('cerrarModal', 'parroquia_btn_cerrar');
        $this->alert('success', $message);
    }

    public function estatusParroquia($id)
    {
        $parroquia = Parroquia::find($id);
        if ($parroquia->estatus){
            $parroquia->estatus = 0;
            $type = 'info';
            $message = $parroquia->nombre." Inactivo.";
        }else{
            $parroquia->estatus = 1;
            $type = 'success';
            $message = $parroquia->nombre." Activo.";

        }
        $parroquia->save();
        $this->alert($type, $message);
    }

    public function editParroquia($id)
    {
        $this->limpiarParroquias();
        $this->viewParroquia = "edit";
        $parroquia = Parroquia::find($id);
        $this->parroquia_id = $parroquia->id;
        $this->parroquiaNombre = $parroquia->nombre;
        $this->parroquiaAbreviatura = $parroquia->mini;
        $this->parroquiaFamilias = $parroquia->familias;
        $this->parroquiaMunicipio = $parroquia->municipios_id;
        $this->emit('editSelectMunicipio', $this->parroquiaMunicipio);
    }

    public function destroyParroquia($id)
    {
        $this->parroquia_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => '¡Sí, bórralo!',
            'text' => '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedParroquia',
        ]);
    }

    public function confirmedParroquia()
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
            $parroquia = Parroquia::find($this->parroquia_id);
            $anterior = $parroquia->municipios_id;
            $nombre = $parroquia->nombre;
            $parroquia->delete();
            $municipio = Municipio::find($anterior);
            $cantidad = $municipio->parroquias - 1;
            $municipio->parroquias = $cantidad;
            $municipio->save();
            $this->limpiarParroquias();
            $this->alert('success',$nombre. ' Eliminado.');
        }
    }

    public function filtrarParroquias($id)
    {
        $this->reset(['keywordParroquia']);
        $this->idMunicipio = $id;
    }

    // *********************************** Complementos ***************************************

    public function buscar($keyword)
    {
        $this->keywordMunicipios = $keyword;
        $this->keywordParroquia = $keyword;
    }

    public function municipioSeleccionado($municipio){
        $this->parroquiaMunicipio = $municipio;
    }

    public function cerrarModal($selector)
    {
        //JS
    }

    public function selectMunicipios($municipios)
    {
        //JS
    }

    public function editSelectMunicipio($municipio)
    {
        //JS
    }

}
