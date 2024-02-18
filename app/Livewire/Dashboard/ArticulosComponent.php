<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Procedencia;
use App\Models\Stock;
use App\Models\TipoArticulo;
use App\Models\Tributario;
use App\Models\Unidad;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ArticulosComponent extends Component
{
    use LivewireAlert;

    public $rows = 0;

    public $view, $btn_nuevo = true, $btn_cancelar = false, $footer = false, $btn_editar = false,
        $btn_und_editar = false, $btn_und_form = false, $new_articulo = false, $keyword;

    public $articulo_id, $articulo_codigo, $articulo_descripcion, $articulo_tipo, $articulo_categoria,
        $articulo_procedencia, $articulo_tributario, $articulo_unidad, $articulo_marca, $articulo_modelo,
        $articulo_referencia, $articulo_adicional, $articulo_decimales, $articulo_estatus, $articulo_fecha,
        $articulo_tipos_id, $articulo_categorias_id, $articulo_procedencias_id, $articulo_tributarios_id,
        $articulo_unidades_id, $articulo_categoria_code, $articulo_procedencia_code,
        $articulo_unidad_code;

    public function mount()
    {
        $this->setLimit();
        $ultimo = Articulo::orderBy('codigo', 'ASC')->first();
        if ($ultimo){
            $this->view = "show";
            $this->showArticulos($ultimo->id);
        }
    }

    public function render()
    {
        $articulos = Articulo::buscar($this->keyword)
            ->orderBy('codigo', 'ASC')
            ->limit($this->rows)
            ->get()
        ;
        $rowsArticulos = Articulo::count();
        $listarCategorias = Categoria::orderBy('codigo', 'ASC')->get();
        $listarUnidades = Unidad::orderBy('codigo', 'ASC')->get();
        $listarProcedencia = Procedencia::orderBy('codigo', 'ASC')->get();
        $listarTributatio = Tributario::orderBy('codigo', 'ASC')->get();
        $listarTipo = TipoArticulo::get();
        return view('livewire.dashboard.articulos-component')
            ->with('listarArticulos', $articulos)
            ->with('rowsArticulos', $rowsArticulos)
            ->with('selectCategorias', $listarCategorias)
            ->with('selectUnidades', $listarUnidades)
            ->with('selectProcedencia', $listarProcedencia)
            ->with('selectTributario', $listarTributatio)
            ->with('selectTipo', $listarTipo)
            ;
    }

    public function setLimit()
    {
        if (numRowsPaginate() < 14) { $rows = 14; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
    }

    public function limpiarArticulos()
    {
        $this->resetErrorBag();
        $this->reset([
            'view', 'articulo_codigo', 'articulo_descripcion', 'articulo_tipo', 'articulo_categoria',
            'articulo_procedencia', 'articulo_tributario', 'articulo_unidad', 'articulo_marca', 'articulo_modelo',
            'articulo_referencia', 'articulo_adicional', 'articulo_decimales', 'articulo_estatus', 'articulo_fecha',
            'articulo_tipos_id', 'articulo_categorias_id', 'articulo_procedencias_id', 'articulo_tributarios_id',
            'articulo_unidades_id', 'articulo_categoria_code', 'articulo_procedencia_code',
            'articulo_unidad_code', 'btn_nuevo', 'btn_cancelar', 'footer', 'new_articulo',
        ]);
    }

    public function create()
    {
        $this->limpiarArticulos();
        $this->new_articulo = true;
        $this->view = "form";
        $this->btn_nuevo = false;
        $this->btn_cancelar = true;
        $this->btn_editar = false;
        $this->footer = false;
        //$this->selectFormArticulos();
    }

    public function saveArticulos()
    {
        $tipo = 'success';
        $message = null;

        $rules = [
            'articulo_codigo'           =>  ['required', 'min:4', 'max:8', 'alpha_num:ascii', Rule::unique('articulos', 'codigo')->ignore($this->articulo_id)],
            'articulo_descripcion'      =>  'required|min:4|max:40',
            'articulo_tipos_id'         => 'required',
            'articulo_categorias_id'    => 'required',
            'articulo_procedencias_id'  => 'required',
            'articulo_tributarios_id'   => 'required',
            'articulo_marca'            => 'nullable|max:40',
            'articulo_modelo'           => 'nullable|max:40',
        ];
        $messages = [
            'articulo_codigo.required'          => 'El campo nombre es obligatorio.',
            'articulo_codigo.min'               => 'El campo nombre debe contener al menos 4 caracteres.',
            'articulo_codigo.max'               => 'El campo codigo no debe ser mayor que 10 caracteres.',
            'articulo_codigo.alpha_num'         => 'El campo nombre sólo debe contener letras y números.',
            'articulo_codigo.unique'            => 'El campo codigo ya ha sido registrado. ',
            'articulo_descripcion.required'     => 'El campo descripción es obligatorio.',
            'articulo_descripcion.min'          => 'El campo descripción debe contener al menos 4 caracteres.',
            'articulo_descripcion.max'          => 'El campo descripción no debe ser mayor que 40 caracteres.',
            'articulo_tipos_id.required'        => 'El campo tipo es obligatorio.',
            'articulo_categorias_id.required'   => 'El campo categoria es obligatorio.',
            'articulo_procedencias_id.required' => 'El campo procedencia es obligatorio.',
            'articulo_tributarios_id.required'  => 'El campo I.V.A. es obligatorio.',
            'articulo_marca.max'                => 'El campo marca no debe ser mayor que 40 caracteres.',
            'articulo_modelo.max'               => 'El campo modelo no debe ser mayor que 40 caracteres.',
        ];
        $this->validate($rules, $messages);

        if ($this->articulo_id && !$this->new_articulo){
            //editar
            $articulo = Articulo::find($this->articulo_id);
            $unidad = false;
            $categ = $articulo->categorias_id;
            $message = "Articulo Actualizado.";
        }else{
            //nuevo
            $articulo = new Articulo();
            $unidad = true;
            $categ = false;
            $message = "Articulo Creado.";
        }

        $articulo->codigo = $this->articulo_codigo;
        $articulo->descripcion = $this->articulo_descripcion;
        $articulo->tipos_id = $this->articulo_tipos_id;
        $articulo->categorias_id = $this->articulo_categorias_id;
        $articulo->procedencias_id = $this->articulo_procedencias_id;
        $articulo->tributarios_id = $this->articulo_tributarios_id;
        $articulo->marca = $this->articulo_marca;
        $articulo->modelo = $this->articulo_modelo;
        $articulo->referencia = $this->articulo_referencia;
        $articulo->adicional = $this->articulo_adicional;

        $articulo->save();
        $this->reset('keyword');
        $this->showArticulos($articulo->id);
        if ($unidad){
            $this->btnUnidad();
        }

        if ($categ){
            $categoria = Categoria::find($categ);
            $categoria->cantidad = $categoria->cantidad - 1;
            $categoria->update();
        }

        $categoria = Categoria::find($articulo->categorias_id);
        $categoria->cantidad = $categoria->cantidad + 1;
        $categoria->update();

        $this->alert(
            $tipo,
            $message
        );
    }

    public function showArticulos($id)
    {
        $this->limpiarArticulos();
        $articulo = Articulo::find($id);
        $this->btn_editar = true;
        $this->view = "show";
        $this->footer = true;
        $this->articulo_id = $articulo->id;
        $this->articulo_codigo = $articulo->codigo;
        $this->articulo_descripcion = $articulo->descripcion;

        $this->articulo_tipos_id = $articulo->tipos_id;
        if ($this->articulo_tipos_id){
            $this->articulo_tipo = $articulo->tipo->nombre;
        }

        $this->articulo_categorias_id = $articulo->categorias_id;
        if ($this->articulo_categorias_id){
            $this->articulo_categoria_code = $articulo->categoria->codigo;
            $this->articulo_categoria = $articulo->categoria->nombre;
        }

        $this->articulo_procedencias_id = $articulo->procedencias_id;
        if ($this->articulo_procedencias_id){
            $this->articulo_procedencia_code = $articulo->procedencia->codigo;
            $this->articulo_procedencia = $articulo->procedencia->nombre;
        }

        $this->articulo_tributarios_id = $articulo->tributarios_id;
        if ($this->articulo_tributarios_id){
            $this->articulo_tributario = $articulo->tributario->codigo;
        }

        $this->articulo_unidades_id = $articulo->unidades_id;
        if ($this->articulo_unidades_id){
            $this->articulo_unidad_code = $articulo->unidad->codigo;
            $this->articulo_unidad = $articulo->unidad->nombre;
        }

        $this->articulo_marca = $articulo->marca;
        $this->articulo_modelo = $articulo->modelo;
        $this->articulo_referencia = $articulo->referencia;
        $this->articulo_adicional = $articulo->adicional;
        $this->articulo_decimales = $articulo->decimales;
        $this->articulo_estatus = $articulo->estatus;
        $this->articulo_fecha = $articulo->created_at;
    }

    public function destroy()
    {
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmed',
        ]);
    }

    #[On('confirmed')]
    public function confirmed()
    {
        $articulo = Articulo::find($this->articulo_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $stock = Stock::where('articulos_id', $articulo->id)->first();
        if ($stock){
            $vinculado = true;
        }

        if ($vinculado) {
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
            $articulo->delete();
            $this->alert(
                'success',
                'Articulo Eliminado.'
            );
            $this->limpiarArticulos();
            $this->btn_editar = false;
        }
    }

    public function btnCancelar()
    {
        if ($this->articulo_id){
            $this->showArticulos($this->articulo_id);
        }else{
            $this->limpiarArticulos();
        }
    }

    public function btnEditar()
    {
        $this->view = 'form';
        $this->btn_editar = false;
        $this->btn_cancelar = true;
        $this->footer = false;
        //$this->selectFormArticulos(true);
    }

}
