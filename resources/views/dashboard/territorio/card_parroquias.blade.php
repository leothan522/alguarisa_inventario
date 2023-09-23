<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if(/*$keyword*/ false)
                Resultados de la Busqueda { <b class="text-danger">{{ $keyword }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiar"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Parroquias
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right">
                <li class="page-item"><a class="page-link" href="#">«</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">»</a></li>
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" {{--style="height: 400px;"--}}>
        <table class="table {{--table-head-fixed--}} table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th class="text-center">#</th>
                <th>Nombre</th>
                <th class="text-center">Municipio</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Valle de La pascua</td>
                <td class="text-center">
                    Infante
                </td>
                <td class="justify-content-end">
                    <div class="btn-group">
                        <button {{--wire:click="destroy({{ $parametro->id }})"--}} class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button {{--wire:click="edit({{ $parametro->id }})"--}} class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-parroquias">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button {{--wire:click="destroy({{ $parametro->id }})"--}} class="btn btn-primary btn-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
