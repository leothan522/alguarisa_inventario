<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordParroquia || $idMunicipio)
                @if($keywordParroquia)
                    Busqueda { <b class="text-danger">{{ $keywordParroquia }}</b> }
                    <button class="btn btn-tool text-danger" wire:click="limpiarParroquias"><i class="fas fa-times-circle"></i>
                    </button>
                @else
                    Filtrando por municipio { <b class="text-danger">{{ $verMunicipio }}</b> }
                    <button class="btn btn-tool text-danger" wire:click="limpiarParroquias"><i class="fas fa-times-circle"></i>
                    </button>
                @endif
            @else
                <small>Registradas</small> [ <b class="text-warning">{{ $rowsParroquias }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" wire:click="limpiarParroquias">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button type="button" class="btn btn-tool" wire:click="setLimit" @if($rows >= $rowsParroquias) disabled @endif >
                <i class="fas fa-sort-amount-down-alt"></i> Ver más
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0" @if($listarParroquias->count() > $numero) style="height: 72vh;" @endif >
        <table class="table table-sm table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th class="text-center">#</th>
                <th>Nombre</th>
                <th class="text-right" style="width: 5%;">Asignación</th>
                <th class="text-center">Municipio</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>

            @if($listarParroquias->isNotEmpty())
                @php($itemParroquia = 0)
                @foreach($listarParroquias as $parroquia)
                    @php($itemParroquia++)
                    <tr>
                        <td class="text-center">{{ $itemParroquia }}</td>
                        <td class="text-uppercase">{{ $parroquia->nombre }}</td>
                        <td class="text-right" style="width: 5%;">{{ formatoMillares($parroquia->familias, 0) }}</td>
                        <td class="text-center text-uppercase">
                            {{ $parroquia->municipio->mini }}
                        </td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="estatusParroquia({{ $parroquia->id }})" class="btn btn-primary btn-sm">
                                    @if($parroquia->estatus)
                                        <i class="fas fa-check"></i>
                                    @else
                                        <i class="fas fa-ban"></i>
                                    @endif
                                </button>
                                <button wire:click="editParroquia({{ $parroquia->id }})" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-parroquias"
                                        @if(!comprobarPermisos('parroquias.edit')) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="destroyParroquia({{ $parroquia->id }})" class="btn btn-primary btn-sm"
                                        @if(!comprobarPermisos('parroquias.destroy')) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="5">
                        @if($keywordMunicipios)
                            <span>Sin resultados</span>
                        @else
                            <span>Sin registros guardados</span>
                        @endif
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <small>Mostrando {{ $listarParroquias->count() }}</small>
    </div>
    {!! verSpinner() !!}
</div>
