<?php
//Funciones Personalizadas para el Proyecto
use Illuminate\Support\Facades\Auth;

function comprobarPermisos($routeName = null)
{

    if (leerJson(Auth::user()->permisos, $routeName) || Auth::user()->role == 1 || Auth::user()->role == 100) {
        return true;
    } else {
        return false;
    }

}

function comprobarAccesoEmpresa($permisos, $user_id)
{
    if (leerJson($permisos, $user_id) || Auth::user()->roler == 1 || Auth::user()->role == 100){
        return true;
    }else{
        return false;
    }
}

function allPermisos()
{
    $permisos = [
        'Stock' => [
            'route' => 'stock.index',
            'submenu' => [
                'Cambiar Estatus' => 'stock.estatus',
                'Ver Ajustes' => 'ajustes.index',
                'Imprimir Ajustes' => 'ajustes.print',
                'Crear Ajustes' => 'ajustes.create',
                'Editar Ajustes' => 'ajustes.edit',
                'Anular Ajustes' => 'ajustes.anular',

            ]
        ],
        'Articulos' => [
            'route' => 'articulos.index',
            'submenu' => [
                'Crear Articulos' => 'articulos.create',
                'Editar Articulos' => 'articulos.edit',
                'Cambiar Estatus' => 'articulos.estatus',
                'Cambiar Unidades' => 'articulos.unidades',
                'Cambiar Precios' => 'articulos.precios',
                'Cambiar Identificadores' => 'articulos.identificadores',
                'Cambiar Imagenes' => 'articulos.imagenes'
            ]
        ],
        'Categorias' => [
            'route' => 'categorias.index',
            'submenu' => [
                'Crear categorias' => 'categorias.create',
                'Editar categorias' => 'categorias.edit',
                'Borrar categorias' => 'categorias.destroy'

            ]
        ],
        'Unidades' => [
            'route' => 'unidades.index',
            'submenu' => [
                'Crear unidades' => 'unidades.create',
                'Editar unidades' => 'unidades.edit',
                'Borrar unidades' => 'unidades.destroy'

            ]
        ],
        'Usuarios' => [
            'route' => 'usuarios.index',
            'submenu' => [
                'Crear Usuarios' => 'usuarios.create',
                'Editar Usuarios' => 'usuarios.edit',
                'Suspender Usuarios' => 'usuarios.estatus',
                'Reestablecer Contraseña' => 'usuarios.password',
                'Descargar Excel' => 'usuarios.excel',
                'Eliminar Usuarios' => 'usuarios.destroy',
            ]
        ],
        'Empresas' => [
            'route' => 'empresas.index',
            'submenu' => [
                'Crear Empresas' => 'empresas.create',
                '[Abrir][Cerrar] Empresas' => 'empresas.estatus',
                'Definir Horarios' => 'empresas.horario',
                'Editar Empresas' => 'empresas.edit',
                'Borrar Empresas' => 'empresas.destroy'

            ]
        ],
        'Territorio' => [
            'route' => 'municipios.index',
            'submenu' => [
                'Crear Municipios' => 'municipios.create',
                'Editar Municipios' => 'municipios.edit',
                'Borrar Municipios' => 'municipios.destroy',
                'Crear Parroquias' => 'parroquias.create',
                'Editar Parroquias' => 'parroquias.edit',
                'Borrar Parroquias' => 'parroquias.destroy'
            ]
        ],
        /*'Procedencias' => [
            'route' => 'procedencias.index',
            'submenu' => [
                'Crear procedencias' => 'procedencias.create',
                'Editar procedencias' => 'procedencias.edit',
                'Borrar procedencias' => 'procedencias.destroy'

            ]
        ],
        'Tributarios' => [
            'route' => 'tributarios.index',
            'submenu' => [
                'Crear tributarios' => 'tributarios.create',
                'Editar tributarios' => 'tributarios.edit',
                'Borrar tributarios' => 'tributarios.destroy'

            ]
        ]*/
    ];
    return $permisos;
}
