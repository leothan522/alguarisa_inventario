<!-- Main content -->
<div class="invoice p-3 mb-3" xmlns:wire="http://www.w3.org/1999/xhtml">

    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h3>
                <i class="fas fa-store-alt"></i> <span class="text-uppercase">{{ $empresa->nombre }}</span>
                <small class="float-right">
                    <select class="custom-select" wire:model.live="empresaID">
                       @foreach($listarEmpresas as $empresa)
                            <option value="{{ $empresa['id'] }}">{{ $empresa['text'] }}</option>
                        @endforeach
                    </select>
                </small>
            </h3>
        </div>
    </div>

    {!! verSpinner() !!}
</div>
