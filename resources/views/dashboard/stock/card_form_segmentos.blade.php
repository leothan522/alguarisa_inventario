<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;"
     xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="card-header">
        @if($segmento_id)
            <h3 class="card-title">Editar Segmento</h3>
            <div class="card-tools">
                <button class="btn btn-tool" wire:click="limpiarSegmentos">
                    <i class="fas fa-ban"></i> Cancelar
                </button>
            </div>
            @else
            <h3 class="card-title">Crear Segmento</h3>
            <div class="card-tools">
                <span class="btn btn-tool"><i class="fas fa-file"></i></span>
            </div>
        @endif
    </div>

    <div class="card-body">


        <form wire:submit.prevent="saveSegmento">

            <div class="form-group">
                <label for="name">Descripción</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model.defer="segmento_nombre" placeholder="Descripción">
                    @error('segmento_nombre')
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
                @if(!comprobarPermisos() || ($segmento_id && !comprobarPermisos())) disabled @endif >
                    <i class="fas fa-save"></i> Guardar @if($segmento_id) Cambios @endif
                </button>
            </div>

        </form>




    </div>

</div>
