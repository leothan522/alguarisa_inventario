<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class MountEmpresasComponent extends Component
{

    public $empresaID, $empresa, $listarEmpresas;

    public function mount()
    {
        $this->getEmpresaDefault();
    }

    public function render()
    {
        $this->empresa = Empresa::find($this->empresaID);
        $this->getEmpresas();
        return view('livewire.dashboard.mount-empresas-component');
    }

    public function getEmpresaDefault()
    {
        if (comprobarPermisos(null)) {
            $empresa = Empresa::where('default', 1)->first();
            if ($empresa) {
                $this->empresaID = $empresa->id;
            }
        } else {
            $empresas = Empresa::get();
            foreach ($empresas as $empresa) {
                $acceso = comprobarAccesoEmpresa($empresa->permisos, Auth::id());
                if ($acceso) {
                    $this->empresaID = $empresa->id;
                    break;
                }
            }
        }
    }

    public function getEmpresas()
    {
        $empresas = Empresa::get();
        $array = array();
        foreach ($empresas as $empresa) {
            $acceso = comprobarAccesoEmpresa($empresa->permisos, auth()->id());
            if ($acceso) {
                array_push($array, $empresa);
            }
        }
        $this->listarEmpresas = dataSelect2($array);
    }

    public function updatedEmpresaID()
    {
        $this->js("alert('hola mundo' + $this->empresaID);");
    }


}
