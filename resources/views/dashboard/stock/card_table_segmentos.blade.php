<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordSegmento)
                Resultados de la Busqueda { <b class="text-danger">{{ $keywordSegmento }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarSegmentos"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Segmentos Registrados [ <b class="text-navy">{{ $rowsSegmento }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right m-1">
                {{ $listarSegmentos->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 610px;">
        <table class="table table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th>Descripción</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarSegmentos->isNotEmpty())
                @foreach($listarSegmentos as $tipo)
                    <tr>
                        <td>{{ $tipo->descripcion }}</td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="editSegmento({{ $tipo->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos()) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroySegmento({{ $tipo->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos() || $tipo->tipo) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="2">
                        <span>Aún no se ha creado un Segmento.</span>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
</div>
