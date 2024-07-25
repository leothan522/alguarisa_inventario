<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordMunicipios)
                Busqueda { <b class="text-danger">{{ $keywordMunicipios }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarMunicipios"><i class="fas fa-times-circle"></i>
                </button>
            @else
                <small>Registrados</small> [ <b class="text-warning">{{ $rowsMunicipios }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" wire:click="limpiarMunicipios">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button type="button" class="btn btn-tool" wire:click="setLimit" @if($rows >= $rowsMunicipios) disabled @endif >
                <i class="fas fa-sort-amount-down-alt"></i> Ver más
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0" @if($listarMunicipios->count() > $numero) style="height: 72vh;" @endif >
        <table class="table table-sm table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th class="text-center">#</th>
                <th>Nombre</th>
                <th>Abreviatura</th>
                <th class="text-right" style="width: 5%;">Asignación</th>
                <th class="text-center" style="width: 5%;">Parroquias</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarMunicipios->isNotEmpty())
                @php($itemMunicipio = 0)
                @foreach($listarMunicipios as $municipio)
                    @php($itemMunicipio++)
                    <tr>
                        <td class="text-center">{{ $itemMunicipio }}</td>
                        <td class="text-uppercase">{{ $municipio->nombre }}</td>
                        <td class="text-uppercase">{{ $municipio->mini }}</td>
                        <td class="text-right">{{ formatoMillares($municipio->familias, 0) }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm" wire:click="filtrarParroquias({{ $municipio->id }})">
                                {{ $municipio->parroquias }}
                            </button>
                        </td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="estatusMunicipio({{ $municipio->id }})" class="btn btn-primary btn-sm">
                                    @if($municipio->estatus)
                                        <i class="fas fa-check"></i>
                                    @else
                                        <i class="fas fa-ban"></i>
                                    @endif
                                </button>
                                <button wire:click="editMunicipio({{ $municipio->id }})" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-municipios"
                                        @if(!comprobarPermisos('municipios.edit')) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="destroyMunicipio({{ $municipio->id }})" class="btn btn-primary btn-sm"
                                        @if(!comprobarPermisos('municipios.destroy')) disabled @endif >
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
        <small>Mostrando {{ $listarMunicipios->count() }}</small>
    </div>
    {!! verSpinner() !!}
</div>
