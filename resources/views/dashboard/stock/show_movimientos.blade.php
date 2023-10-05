<div class="col-md-12" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card">
        <div class="card-header border-0">
            <h3 class="card-title">Almacen Principal</h3>
            <div class="card-tools">
                <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                </a>
                {{--<a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                </a>--}}
                <button type="button" class="btn btn-tool" data-card-widget="remove" wire:click="limpiarStock">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body table-responsive p-0" style="height: 550px;">
            <table class="table table-head-fixed table-striped table-valign-middle table-sm">
                <thead>
                <tr>
                    <th class="d-none d-md-table-cell text-center">Tipo</th>
                    <th class="d-none d-md-table-cell text-center">Fecha</th>
                    <th>Articulo</th>
                    <th>Segmento</th>
                    <th class="d-none d-md-table-cell text-right">Unidad</th>
                    <th class="text-right">Cantidad</th>
                    <th class="d-none d-md-table-cell text-right">Saldo</th>
                    <th class="text-center" style="width: 2%">Más</th>
                </tr>
                </thead>
                <tbody>
                @if($getAjustes)
                    @foreach($getAjustes as $ajuste)
                        @if($ajuste->detalles->isNotEmpty())
                            @foreach($ajuste->detalles as $detalle)
                                <tr>
                            <td class="d-none d-md-table-cell text-center">{{ $detalle->tipo->codigo }}</td>
                            <td class="d-none d-md-table-cell text-center">{{ verFecha($ajuste->fecha) }}</td>
                            <td class="text-uppercase">{{ $detalle->articulo->descripcion }}</td>
                            <td class="text-uppercase">
                                @if($ajuste->segmentos->tipo)
                                    {{ $ajuste->municipios->mini }}
                                @else
                                    {{ $ajuste->segmentos->descripcion }}
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell text-right">{{ $detalle->unidad->codigo }}</td>
                            <td class="text-right">
                                <span class="d-inline-flex">
                                    @if($detalle->tipo->tipo == 1)
                                        <small class="text-success mr-1">
                                        <i class="fas fa-arrow-up"></i>
                                        {{--12%--}}
                                        </small>
                                    @else
                                        <small class="text-danger mr-1">
                                        <i class="fas fa-arrow-down"></i>
                                        {{--12%--}}
                                        </small>
                                    @endif
                                    &nbsp; {{ formatoMillares($detalle->cantidad, 0) }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell text-right">
                                <span class="d-inline-flex">
                                {{--<small class="text-success mr-1">
                                    <i class="fas fa-arrow-up"></i>
                                    12%
                                </small>--}}
                                --
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link text-muted" wire:click="irAjuste({{ $ajuste->id }})" onclick="irAjuste()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </td>
                        </tr>
                            @endforeach
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        {!! verSpinner() !!}
    </div>
</div>

