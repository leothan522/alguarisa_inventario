<div class="row justify-content-center" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="col-lg-10">
        <div class="card card-navy card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ $tabMunicipio }}" wire:click="tabActive('municipio')" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">
                            Municipios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tabParroquia }}" wire:click="tabActive('parroquia')" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                            Parroquias
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade @if($tabMunicipio) active show @endif" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                        @include('dashboard.territorio.card_municipios')

                    </div>
                    <div class="tab-pane fade @if($tabParroquia) active show @endif" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

                        @include('dashboard.territorio.card_parroquias')

                    </div>
                </div>
                @include('dashboard.territorio.modal_municipios')
                @include('dashboard.territorio.modal_parroquias')
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
