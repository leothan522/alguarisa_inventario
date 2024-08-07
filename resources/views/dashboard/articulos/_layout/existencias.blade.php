<div>

    <div class="col-12">
        <div class="card card-navy card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                           href="#tabs_datos_basicos" role="tab" aria-controls="custom-tabs-three-home"
                           aria-selected="true">Existencias</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show" id="tabs_datos_basicos" role="tabpanel"
                         aria-labelledby="custom-tabs-three-home-tab">


                        <div class="row table-responsive p-0" @if($listarStock->isEmpty()) style="height: 20vh;" @endif>
                            <table class="table table-sm">
                                <thead>
                                <tr class="text-navy">
                                    <th style="width: 5%">#</th>
                                    <th>Almacen</th>
                                    <th style="width: 10%">Unidad</th>
                                    <th style="width: 10%" class="text-right">Stock</th>
                                    <th style="width: 10%" class="text-right d-none">Comprometido</th>
                                    <th style="width: 10%" class="text-right d-none">Disponible</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i = 0)
                                @if($listarStock->isNotEmpty())
                                    @foreach($listarStock as $stock)
                                        @php($i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td class="text-uppercase">{{ $stock->almacen->nombre }}</td>
                                            <td class="text-uppercase">{{ $stock->unidad->codigo }}</td>
                                            <td class="text-right">{{ formatoMillares($stock->actual, 0) }}</td>
                                            <td class="text-right d-none">{{ formatoMillares($stock->comprometido, 0) }}</td>
                                            <td class="text-right d-none">{{ formatoMillares($stock->disponible, 0) }}</td>
                                        </tr>
                                    @endforeach
                                    @if($listarStock->count() >=2)
                                        <tr class="text-navy">
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>TOTALES</th>
                                            <th class="text-right">{{ formatoMillares($listarStock->sum('actual'), 0) }}</th>
                                            <th class="text-right d-none">{{ formatoMillares($listarStock->sum('comprometido'), 0) }}</th>
                                            <th class="text-right d-none">{{ formatoMillares($listarStock->sum('disponible'), 0) }}</th>
                                        </tr>
                                    @endif
                                @else
                                    @foreach($listarAlmacenes as $almacen)
                                        @php($i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td class="text-uppercase">{{ $almacen->nombre }}</td>
                                            <td class="text-uppercase">{{ $principal_code }}</td>
                                            <td class="text-right">{{ formatoMillares(0, 0) }}</td>
                                            <td class="text-right d-none">{{ formatoMillares(0, 0) }}</td>
                                            <td class="text-right d-none">{{ formatoMillares(0, 0) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            {!! verSpinner() !!}
        </div>
    </div>

</div>
