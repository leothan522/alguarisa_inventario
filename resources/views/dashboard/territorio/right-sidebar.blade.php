<div class="p-3">
    <ul class="nav nav-pills flex-column">
        {{--@livewire('dashboard.dolar-component')
        <li class="dropdown-divider"></li>--}}
        <li class="nav-item mb-2">
            <span class="text-small text-muted float-right">Nuevo</span>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                    data-toggle="modal" data-target="#modal-municipios" onclick="nuevoMunicipio()"
                    @if(!comprobarPermisos('municipios.create')) disabled @endif >
                Municipio
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                    data-toggle="modal" data-target="#modal-parroquias" onclick="nuevaParroquia()"
                    @if(!comprobarPermisos('parroquias.create')) disabled @endif >
                Parroquia
            </button>
        </li>
    </ul>
</div>
