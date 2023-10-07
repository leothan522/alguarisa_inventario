<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Parametro;
use Illuminate\Http\Request;

class CompartirController extends Controller
{
    public function index($token)
    {
        $parametro = Parametro::where('nombre', 'compartir_stock_qr')->first();
        if ($parametro){
            if ($parametro->valor == $token){
                return view('dashboard.compartir.index')
                    ->with('empresa_id', $parametro->tabla_id);
            }
        }
        return redirect()->route('cerrar');
    }
}
