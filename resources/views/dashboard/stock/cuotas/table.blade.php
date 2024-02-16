<div class="card card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keyword)
                Resultados de la Busqueda { <b class="text-warning">{{ $keyword }}</b> }
                <button class="btn btn-tool text-warning" wire:click="limpiarCuota"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Cuotas Registradas [ <b class="text-warning">{{ $rowsCuotas }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" wire:click="setLimit">
                <i class="fas fa-sort-amount-down-alt"></i> Ver más
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 60vh;">
        <table class="table table-sm table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th>Mes</th>
                <th style="width: 20%">Código</th>
                <th>Fecha Inicio</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarCuotas->isNotEmpty())
                @foreach($listarCuotas as $cuota)
                    <tr>
                        <td>{{ mesEspanol($cuota->mes) }}</td>
                        <td>{{ $cuota->codigo }}</td>
                        <td>{{ verFecha($cuota->fecha) }}</td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="edit({{ $cuota->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos()) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroy({{ $cuota->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos()) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="4">
                        <span>Aún no se ha establecido una Cuota.</span>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
</div>
