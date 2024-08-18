<?php

namespace App\Livewire\Dashboard;

use App\Models\Municipio;
use App\Models\Parroquia;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TerritorioComponent extends Component
{
    use LivewireAlert;

    public $rows = 0, $numero = 15, $tableStyle = false;
    public $viewMunicipio = "create", $keywordMunicipios, $viewParroquia = 'create', $keywordParroquia, $idMunicipio;
    public $municipio_id, $municipioNombre, $municipioAbreviatura, $municipioFamilias, $municipioParroquias, $municipioEstatus;
    public $parroquia_id, $parroquiaNombre, $parroquiaAbreviatura, $parroquiaMunicipio, $parroquiaFamilias, $parroquiaMax, $parroquiaEstatus;
    public $tabMunicipio = 'active', $tabParroquia, $verMunicipio;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $listarMunicipios = Municipio::buscar($this->keywordMunicipios)
            ->orderBy('nombre', 'ASC')
            ->limit($this->rows)
            ->get();
        $rowsMunicipios = Municipio::count();

        $listarParroquias = Parroquia::buscar($this->keywordParroquia, $this->idMunicipio)
            ->orderBy('nombre', 'ASC')
            ->limit($this->rows)
            ->get();
        $rowsParroquias = Parroquia::count();

        return view('livewire.dashboard.territorio-component')
            ->with('listarMunicipios', $listarMunicipios)
            ->with('rowsMunicipios', $rowsMunicipios)
            ->with('listarParroquias', $listarParroquias)
            ->with('rowsParroquias', $rowsParroquias)
            ;
    }

    public function setLimit($parroquia = false)
    {
        if ($parroquia){
            $this->tabActive('parroquia');
        }

        if (numRowsPaginate() < $this->numero) {
            $rows = $this->numero;
        } else {
            $rows = numRowsPaginate();
        }
        $this->rows = $this->rows + $rows;
    }

    /* ****************************** MUNICIPIOS ***************************************** */

    #[On('limpiarMunicipios')]
    public function limpiarMunicipios()
    {
        $this->resetErrorBag();
        $this->reset([
            'viewMunicipio', 'municipio_id', 'municipioNombre', 'municipioAbreviatura', 'keywordMunicipios',
            'municipioFamilias', 'municipioParroquias', 'municipioEstatus'
        ]);
        $this->tabActive('municipio');
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

        if ($municipio){
            $municipio->nombre = ucwords($this->municipioNombre);
            $municipio->mini = ucfirst($this->municipioAbreviatura);
            $municipio->familias = $this->municipioFamilias;
            $municipio->save();
            $this->alert('success', $message);
        }

        $this->dispatch('cerrarModal', selector: 'municipio_btn_cerrar');
    }

    public function editMunicipio($id)
    {
        $keyword = $this->keywordMunicipios;
        $this->limpiarMunicipios();

        $municipio = Municipio::find($id);
        if ($municipio){
            $this->viewMunicipio = "edit";
            $this->municipio_id = $municipio->id;
            $this->municipioNombre = $municipio->nombre;
            $this->municipioAbreviatura = $municipio->mini;
            $this->municipioFamilias = $municipio->familias;
            $this->municipioParroquias = $municipio->parroquias;
            if ($municipio->estatus){
                $this->municipioEstatus = "Activo";
            }else{
                $this->municipioEstatus = "Inactivo";
            }
        }else{
            $this->dispatch('cerrarModal', selector: 'municipio_btn_cerrar');
            $this->dispatch('cerrarModal', selector: 'btn_modal_show_minicipio');
        }
        if ($keyword){
            $this->keywordMunicipios = $keyword;
        }
    }

    public function estatusMunicipio($id)
    {
        $municipio = Municipio::find($id);
        if ($municipio){
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

    #[On('confirmedMunicipio')]
    public function confirmedMunicipio()
    {
        $municipio = Municipio::find($this->municipio_id);

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
            if ($municipio){
                $nombre = $municipio->mini;
                $municipio->delete();
                $this->dispatch('cerrarModal', selector: 'btn_modal_show_minicipio');
                $this->alert('success',$nombre. ' ELIMINADO.');
            }
            $this->limpiarMunicipios();
        }
    }

    /* ****************************** PARROQUIAS ***************************************** */

    #[On('limpiarParroquias')]
    public function limpiarParroquias()
    {
        $this->resetErrorBag();
        $this->reset([
            'viewParroquia', 'parroquia_id', 'parroquiaNombre', 'parroquiaAbreviatura', 'parroquiaMunicipio',
            'keywordParroquia', 'idMunicipio', 'parroquiaFamilias', 'parroquiaMax', 'verMunicipio', 'parroquiaEstatus'
        ]);
        $municipios = dataSelect2(Municipio::orderBy('nombre', 'ASC')->get());
        $this->dispatch('selectMunicipios', municipios: $municipios);
        $this->tabActive('parroquia');
    }

    public function saveParroquia()
    {
        $max = 0;
        $municipio = Municipio::find($this->parroquiaMunicipio);
        if ($municipio && !is_null($municipio->familias)){
            $max = $municipio->familias;
        }

        $this->parroquiaMax = Parroquia::where('municipios_id', $this->parroquiaMunicipio)
            ->where('id', '!=', $this->parroquia_id)
            ->sum('familias');
        if (is_numeric($this->parroquiaFamilias)){
            $this->parroquiaMax = $this->parroquiaMax + (int)$this->parroquiaFamilias;
        }

        $rules = [
            'parroquiaMunicipio' => 'required',
            'parroquiaNombre' => ['required', 'min:4', Rule::unique('parroquias', 'nombre')->ignore($this->parroquia_id)],
            'parroquiaAbreviatura' => ['nullable', 'min:4', Rule::unique('parroquias', 'mini')->ignore($this->parroquia_id)],
            'parroquiaFamilias' => 'required|integer',
            'parroquiaMax' => 'integer|max:'.$max,
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
            'parroquiaFamilias.required' => 'El campo asignación es obligatorio.',
            'parroquiaFamilias.integer' => 'El campo asignación debe ser un número entero.',
            'parroquiaMax.max' => 'La Asignación de las parroquias no debe ser mayor a la del municipio.',
        ];

        $this->validate($rules, $messages);

        $anterior = null;

        if (is_null($this->parroquia_id)){
            //nuevo
            $parroquia = new Parroquia();
            $message = "Parroquia Creada.";
        }else{
            //editar
            $parroquia = Parroquia::find($this->parroquia_id);
            $message = "Parroquia Actualizada." ;
            if ($parroquia){
                $anterior = $parroquia->municipios_id;
            }
        }

        if ($parroquia){
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
                if ($municipio){
                    $cantidad = $municipio->parroquias + 1;
                    $municipio->parroquias = $cantidad;
                    $municipio->save();
                }
            }else{
                //editar
                if ($anterior != $this->parroquiaMunicipio){
                    //resto anterior
                    $municipio = Municipio::find($anterior);
                    if ($municipio){
                        $cantidad = $municipio->parroquias - 1;
                        $municipio->parroquias = $cantidad;
                        $municipio->save();
                    }
                    //sumo nuevo
                    $municipio = Municipio::find($this->parroquiaMunicipio);
                    if ($municipio){
                        $cantidad = $municipio->parroquias + 1;
                        $municipio->parroquias = $cantidad;
                        $municipio->save();
                    }
                }

            }
            $this->alert('success', $message);
        }

        $this->dispatch('cerrarModal', selector: 'parroquia_btn_cerrar');
    }

    public function estatusParroquia($id)
    {
        $parroquia = Parroquia::find($id);
        if ($parroquia){
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
    }

    public function editParroquia($id)
    {
        $keyword = $this->keywordParroquia;
        $idMunicipio = $this->idMunicipio;
        $this->limpiarParroquias();

        $parroquia = Parroquia::find($id);
        if ($parroquia){
            $this->viewParroquia = "edit";
            $this->parroquia_id = $parroquia->id;
            $this->parroquiaNombre = $parroquia->nombre;
            $this->parroquiaAbreviatura = $parroquia->mini;
            $this->parroquiaFamilias = $parroquia->familias;
            $this->parroquiaMunicipio = $parroquia->municipios_id;
            $this->verMunicipio = $parroquia->municipio->nombre;

            if ($parroquia->estatus){
                $this->parroquiaEstatus = "Activo";
            }else{
                $this->parroquiaEstatus = "Inactivo";
            }

            if ($idMunicipio){
                $this->filtrarParroquias($idMunicipio);
            }

            $this->dispatch('editSelectMunicipio', municipio: $this->parroquiaMunicipio);

        }else{
            $this->dispatch('cerrarModal', selector: 'parroquia_btn_cerrar');
            $this->dispatch('cerrarModal', selector: 'btn_modal_show_parroquia');
        }

        if ($keyword){
            $this->keywordParroquia = $keyword;
        }

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

    #[On('confirmedParroquia')]
    public function confirmedParroquia()
    {
        $idMunicipio = $this->idMunicipio;
        $keyword = $this->keywordParroquia;
        $parroquia = Parroquia::find($this->parroquia_id);

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
            if ($parroquia){
                $anterior = $parroquia->municipios_id;
                $nombre = $parroquia->nombre;
                $parroquia->delete();
                $municipio = Municipio::find($anterior);
                if ($municipio){
                    $cantidad = $municipio->parroquias - 1;
                    $municipio->parroquias = $cantidad;
                    $municipio->save();
                }
                $this->dispatch('cerrarModal', selector: 'btn_modal_show_parroquia');
                $this->alert('success',$nombre. ' ELIMINADA.');
            }
            $this->limpiarParroquias();
            if ($idMunicipio){
                $this->filtrarParroquias($idMunicipio);
            }
            if ($keyword){
                $this->keywordParroquia = $keyword;
            }
        }
    }

    public function filtrarParroquias($id)
    {
        $this->reset(['keywordParroquia']);
        $municipio = Municipio::find($id);
        if ($municipio){
            $this->idMunicipio = $id;
            $this->verMunicipio = $municipio->nombre;
            $this->tabMunicipio = null;
            $this->tabParroquia = 'active';
            $this->dispatch('setBreadcrumb');
        }
    }

    // *********************************** Complementos ***************************************

    #[On('buscar')]
    public function buscar($keyword)
    {
        $this->keywordMunicipios = $keyword;
        $this->keywordParroquia = $keyword;
        $this->reset(['idMunicipio']);
    }

    public function tabActive($opcion)
    {
        if ($opcion == 'municipio'){
            $this->reset(['tabMunicipio', 'tabParroquia']);
        }else{
            $this->tabMunicipio = null;
            $this->tabParroquia = 'active';
        }
    }

    #[On('municipioSeleccionado')]
    public function municipioSeleccionado($municipio){
        $this->parroquiaMunicipio = $municipio;
    }

    #[On('cerrarModal')]
    public function cerrarModal($selector)
    {
        //JS
    }

    #[On('selectMunicipios')]
    public function selectMunicipios($municipios)
    {
        //JS
    }

    #[On('editSelectMunicipio')]
    public function editSelectMunicipio($municipio)
    {
        //JS
    }

    #[On('setBreadcrumb')]
    public function setBreadcrumb()
    {
        //JS
    }

}
