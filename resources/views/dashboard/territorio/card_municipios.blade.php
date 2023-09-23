<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordMunicipios)
                Resultados de la Busqueda { <b class="text-danger">{{ $keywordMunicipios }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarMunicipio"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Municipios
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right m-1">
                {{ $listarMunicipios->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" {{--style="height: 400px;"--}}>
        <table class="table {{--table-head-fixed--}} table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th class="text-center">#</th>
                <th>Nombre</th>
                <th>Abreviatura</th>
                <th class="text-center">Parroquias</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarMunicipios->isNotEmpty())
                @foreach($listarMunicipios as $municipio)
                    @php($itemMunicipio++)
                    <tr>
                        <td class="text-center">{{ $itemMunicipio }}</td>
                        <td>{{ $municipio->nombre }}</td>
                        <td>{{ $municipio->mini }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm">
                                {{ $municipio->parroquias }}
                            </button>
                        </td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="estatusMunicipio({{ $municipio->id }})" class="btn btn-primary btn-sm">
                                    @if($municipio->estatus)
                                        <i class="fas fa-eye"></i>
                                    @else
                                        <i class="fas fa-eye-slash"></i>
                                    @endif

                                </button>
                                <button wire:click="editMunicipio({{ $municipio->id }})" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-municipios">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="destroyMunicipio({{ $municipio->id }})" class="btn btn-primary btn-sm">
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
    {!! verSpinner() !!}
</div>
