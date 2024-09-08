<div class="card card-navy">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordParroquia || $idMunicipio)
                @if($keywordParroquia)
                    Parroquias { <b class="text-warning">{{ $keywordParroquia }}</b> } [ <b class="text-warning">{{ $totalParroquias }}</b> ]
                    <button class="btn btn-tool text-warning" wire:click="cerrarBusqueda('parroquia')">
                        <i class="fas fa-times-circle"></i>
                    </button>
                @else
                    Filtrando { <b class="text-warning">{{ $verMunicipio }}</b> } [ <b class="text-warning">{{ $totalParroquias }}</b> ]
                    <button class="btn btn-tool text-warning" wire:click="cerrarBusqueda('parroquia')">
                        <i class="fas fa-times-circle"></i>
                    </button>
                @endif
            @else
                Parroquias [ <b class="text-warning">{{ $rowsParroquias }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" wire:click="limpiarParroquias">
                <i class="fas fa-sync-alt"></i>
            </button>
            @if(comprobarPermisos('parroquias.create'))
                <button class="btn btn-tool" data-toggle="modal" data-target="#modal-parroquias" wire:click="limpiarParroquias">
                    <i class="fas fa-file"></i> Nuevo
                </button>
            @else
                <button class="btn btn-tool disabled">
                    <i class="fas fa-file"></i> Nuevo
                </button>
            @endif
            <button type="button" class="btn btn-tool" wire:click="setLimit('true')"
                    @if($rows >= $rowsParroquias) disabled @endif >
                <i class="fas fa-sort-amount-down-alt"></i> Ver más
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0" @if($totalParroquias >= $numero) style="height: 67vh;" @endif >
        <table class="table table-sm table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th class="text-center">#</th>
                <th>Nombre</th>
                <th class="d-none d-md-table-cell  text-right" style="width: 5%;">Asignación</th>
                <th class="d-none d-md-table-cell  text-center">Municipio</th>
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
                        <td class="text-uppercase text-truncate" style="max-width: 150px;">{{ $parroquia->nombre }}</td>
                        <td class="d-none d-md-table-cell  text-right" style="width: 5%;">{{ formatoMillares($parroquia->familias, 0) }}</td>
                        <td class="d-none d-md-table-cell  text-center text-uppercase">
                            {{ $parroquia->municipio->mini }}
                        </td>
                        <td class="justify-content-end">
                            <div class="d-none d-md-block">
                                <div class="btn-group">
                                    <button wire:click="estatusParroquia('{{ $parroquia->rowquid }}')" class="btn btn-primary btn-sm">
                                        @if($parroquia->estatus)
                                            <i class="fas fa-check"></i>
                                        @else
                                            <i class="fas fa-ban"></i>
                                        @endif
                                    </button>
                                    <button wire:click="editParroquia('{{ $parroquia->rowquid }}')"
                                            class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#modal-parroquias"
                                            @if(!comprobarPermisos('parroquias.edit')) disabled @endif >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="destroyParroquia('{{ $parroquia->rowquid }}')" class="btn btn-primary btn-sm"
                                            @if(!comprobarPermisos('parroquias.destroy')) disabled @endif >
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-md-none">
                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#modal-show-parroquias"
                                        wire:click="editParroquia('{{ $parroquia->rowquid }}')">
                                    <i class="fas fa-eye"></i>
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
