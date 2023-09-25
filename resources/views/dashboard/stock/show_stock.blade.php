@if($stockAlmacenes->isNotEmpty())
    @foreach($stockAlmacenes as $almacen)
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-navy card-outline direct-chat">
                <div class="card-body box-profile">
                    <div class="text-center mt-3">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/warehouse_702455.png') }}" alt="Almacen">
                    </div>
                    <h3 class="profile-username text-center text-uppercase">{{ $almacen->nombre }}</h3>
                    <p class="text-muted text-center text-uppercase">{{ $almacen->codigo }}</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="dropdown-divider ml-3 mr-3"></li>
                        <!-- Conversations are loaded here -->
                        <div class="direct-chat-messages">
                            @if($almacen->stock->isNotEmpty())
                                @foreach($almacen->stock as $stock)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b class="text-uppercase">{{ $stock->articulo->descripcion }}</b>
                                        <a class="">{{ formatoMillares($stock->actual, 0) }}</a>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item d-flex justify-content-center align-items-center text-muted">
                                    Sin Stock
                                </li>
                            @endif
                        </div>
                        <!--/.direct-chat-messages-->
                    </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer pb-0">
                    <div class="small-box bg-primary">
                        <a class="small-box-footer" style="cursor:pointer;">
                            Más información
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                {!! verSpinner() !!}
            </div>
            <!-- /.card -->
        </div>
    @endforeach
@endif
