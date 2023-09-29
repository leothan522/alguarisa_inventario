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
        <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle">
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
                <tr>
                    <td class="d-none d-md-table-cell text-center">E01</td>
                    <td class="d-none d-md-table-cell text-center">28/09/2023</td>
                    <td class="text-uppercase">
                        Modulos CLAPS
                    </td>
                    <td class="text-uppercase">Recepcion</td>
                    <td class="d-none d-md-table-cell text-right">UND</td>
                    <td class="text-right">
                        <span class="d-inline-flex">
                        <small class="text-success mr-1">
                            <i class="fas fa-arrow-up"></i>
                            {{--12%--}}
                        </small>
                        999.999
                        </span>
                    </td>
                    <td class="d-none d-md-table-cell text-right">
                        <span class="d-inline-flex">
                        {{--<small class="text-success mr-1">
                            <i class="fas fa-arrow-up"></i>
                            12%
                        </small>--}}
                        9.999.999
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="#" class="text-muted">
                            <i class="fas fa-search"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="d-none d-md-table-cell text-center">E01</td>
                    <td class="d-none d-md-table-cell text-center">28/09/2023</td>
                    <td class="text-uppercase">
                        Modulos CLAPS
                    </td>
                    <td class="text-uppercase">Recepcion</td>
                    <td class="d-none d-md-table-cell text-right">UND</td>
                    <td class="text-right">
                        <span class="d-inline-flex">
                        <small class="text-primary mr-1">
                            <i class="fas fa-arrow-down"></i>
                            {{--12%--}}
                        </small>
                        999.999
                        </span>
                    </td>
                    <td class="d-none d-md-table-cell text-right">
                        <span class="d-inline-flex">
                        {{--<small class="text-success mr-1">
                            <i class="fas fa-arrow-up"></i>
                            12%
                        </small>--}}
                        9.999.999
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="#" class="text-muted">
                            <i class="fas fa-search"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        {!! verSpinner() !!}
    </div>
</div>

