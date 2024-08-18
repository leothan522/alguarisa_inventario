<div class="row justify-content-center" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="col-lg-10">

        <ul class="nav nav-tabs d-none" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ $tabMunicipio }}" id="custom-tabs-one-home-tab" data-toggle="pill"
                   href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">
                    Municipios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tabParroquia }}" id="custom-tabs-one-profile-tab" data-toggle="pill"
                   href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                   aria-selected="false">
                    Parroquias
                </a>
            </li>
        </ul>

        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade @if($tabMunicipio) active show @endif" id="custom-tabs-one-home" role="tabpanel"
                 aria-labelledby="custom-tabs-one-home-tab">

                @include('dashboard.territorio.table_municipios')

            </div>
            <div class="tab-pane fade @if($tabParroquia) active show @endif" id="custom-tabs-one-profile"
                 role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

                @include('dashboard.territorio.table_parroquias')

            </div>
        </div>

        @include('dashboard.territorio.form_municipios')
        @include('dashboard.territorio.form_parroquias')
        @include('dashboard.territorio.show_municipio')
        @include('dashboard.territorio.show_parroquia')
    </div>
</div>
