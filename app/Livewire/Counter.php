<?php

namespace App\Livewire;

use App\Models\Municipio;
use App\Models\Parroquia;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Counter extends Component
{
    use LivewireAlert;

    protected $listeners = ['increment', 'prueba'];

    public $count = 0, $select = "hola";

    public $arrayMunicipios, $arrayParroquias, $hola;

    public function render()
    {
        return view('livewire.counter');
    }

    public function increment($texto)

    {
        $this->alert('success', 'Basic Alert');
        $this->count = $texto;

    }

    public function prueba($array)
    {
        $json = crearJson($array);
        $this->select = $json;
        if (leerJson($json, 1))
        {
            $this->select = "ya tengo el poder";
        }

    }

    public function generarArray()
    {
        /*

            $table->id();
            $table->string('nombre');
            $table->string('mini')->nullable();
            $table->integer('parroquias')->nullable()->default(0);
            $table->integer('estatus')->default(1);
            $table->timestamps();

           DB::table("municipios")
            ->insert([
                "id" => 1,
                "nombre" => "nombre municipio",
                "mini" => "abreviatura",
                "parroquias" => 10,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
         */

        $municipios = Municipio::all();
        $array = array();
        foreach ($municipios as $municipio){
            $array[] = [
                'id' => $municipio->id,
                'nombre' => $municipio->nombre,
                'mini' => $municipio->mini,
                'parroquias' => $municipio->parroquias,
                'familias' => $municipio->familias,
            ];
        }

        $this->arrayMunicipios = json_encode($array);


        $parroquias = Parroquia::all();
        $array = array();
        foreach ($parroquias as $parroquia){
            $array[] = [
                "id" => $parroquia->id,
                "nombre" => $parroquia->nombre,
                "mini" => $parroquia->mini,
                "municipios_id" => $parroquia->municipios_id,
            ];
        }

        $this->arrayParroquias = json_encode($array);

        $this->alert('info', 'Generando...');
    }

}
