<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;"
     xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="card-header">
        @if($cuota_id)
            <h3 class="card-title">Editar Cuota</h3>
            <div class="card-tools">
                <button class="btn btn-tool" wire:click="limpiarCuota">
                    <i class="fas fa-ban"></i> Cancelar
                </button>
            </div>
            @else
            <h3 class="card-title">Crear Cuota</h3>
            <div class="card-tools">
                <span class="btn btn-tool"><i class="fas fa-file"></i></span>
            </div>
        @endif
    </div>

    <div class="card-body">


        <form wire:submit.prevent="saveCuota">


            <div class="form-group">
                <label for="name">Mes</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar"></i></span>
                    </div>
                    <select class="custom-select" wire:model.defer="cuota_mes">
                        <option value="">Seleccione</option>
                        @php($iMes = 0)
                        @foreach(mesEspanol() as $mes)
                            @php($iMes++)
                            <option value="{{ $iMes }}">{{ $mes }}</option>
                        @endforeach
                    </select>
                    @error('cuota_mes')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="name">Código</label>
                <div wire:ignore>
                    <div class="input-group mb-3" id="div_select_cuotas_codigo"></div>
                </div>
                @error('cuota_codigo')
                <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Fecha Inicio</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" class="form-control" wire:model.defer="cuota_fecha" placeholder="Fecha Inicio">
                    @error('cuota_fecha')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group mt-3">
                {{--<input type="submit" class="btn btn-block btn-success" value="Guardar">--}}
                <button type="submit" class="btn btn-block btn-success"
                @if(!comprobarPermisos() || ($cuota_id && !comprobarPermisos())) disabled @endif >
                    <i class="fas fa-save"></i> Guardar @if($cuota_id) Cambios @endif
                </button>
            </div>

        </form>




    </div>

</div>
