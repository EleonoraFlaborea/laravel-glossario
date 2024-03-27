@if ($word->exists)
    <form action="{{route('admin.words.update', $word)}}" enctype="multipart/form-data" method="POST">
        @method('PUT')
    @else
    <form action="{{route('admin.words.store')}}" enctype="multipart/form-data" method="POST"> 
@endif

    @csrf
    <div class="row g-4">
        {{-- Input word_name --}}
        <div class="col-6">
            <div class="form-group">
                <label for="word_name">Inserisci parola</label>
                <input id="word_name" class="form-control my-2 @error('word_name') is-invalid @elseif(old('word_name', '')) is-valid @enderror" type="text" name="word_name" value="{{old('word_name', $word->word_name)}}" >
            </div>
        </div>
        {{-- Slug
        <div class="col-6">
            <label for="slug">Slug</label>
            <input type="text" id="slug" class="form-control my-2" value="{{Str::slug(old('word_name', $word->word_name))}}" disabled >
        </div> --}}
        {{-- Input tipologia --}}
        {{-- <div class="col-5">
            <div class="form-group">
                <label for="type_id">Decidi la tipologia</label>
                <select class="form-select my-2 @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror" id="type_id" name="type_id">
                    <option value="">Seleziona</option>
                    @foreach ($types as $type)
                    <option value="{{$type->id}}" @if (old('type_id', $word->type?->id) == $type->id) selected @endif>
                        {{$type->label ? : 'Nessuna'}}
                    </option>                        
                    @endforeach
                  </select>
                @error('type_id')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <label for="technologies">Seleziona le tecnologie usate:</label>
            @foreach ($techs as $tech)
            <div class="form-check form-check-inline" id="technologies">
                <input class="form-check-input" type="checkbox" id="{{"tech-$tech->id"}}" value="{{$tech->id}}" name="techs[]" @if (in_array($tech->id, old('techs', $old_techs ?? []))) checked @endif>
                <label class="form-check-label" for="{{"tech-$tech->id"}}">{{$tech->label}}</label>                    
            </div>
            @endforeach
        </div> --}}
        {{-- Input description --}}
        <div class="col-12">
            <div class="form-group">
                <label for="description">Descrizione parola</label>
                <textarea name="description" id="description" class="form-control my-2 @error('description') is-invalid @elseif(old('description', '')) is-valid @enderror" rows="10">{{old('description', $word->description)}}</textarea>
                {{-- @error('description')
                <div class="invalid-feedback">{{$message}}</div>
                @else
                <div class="form-text">Inserisci la descrizione della parola</div>
                @enderror --}}
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between my-4">
        <a href="{{route('admin.words.index')}}" class="btn btn-outline-secondary"><i class="far fa-hand-point-left me-2"></i>Torna indietro</a>
        <div>
            <button type="reset" class="btn btn-info"><i class="fas fa-eraser me-2"></i>Svuota i campi</button>
            <button type="submit" class="btn btn-success"><i class="far fa-floppy-disk me-2"></i>Salva</button>
        </div>
    </div>
</form>