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
        
        <div class="col-12">
            {{-- <label for="links">Seleziona i link usati:</label> --}}
            <div class="form-group row">
                {{-- <label for="fonte">Inserisci parola</label> --}}
                <div class="col-6">
                    <label class="form-check-label" for="nome-fonte">Inserisci il nome della fonte</label> 
                    <input id="nome-fonte" class="form-control my-2" type="text" name="name_links[]">
                </div>
                <div class="col-6">
                    <label class="form-check-label" for="url-fonte">Inserisci il link della fonte</label> 
                    <input id="url-fonte" class="form-control my-2" type="text" name="urls[]">
                </div>
                <div class="col-6">
                    <label class="form-check-label" for="nome-fonte">Inserisci il nome della fonte</label> 
                    <input id="nome-fonte" class="form-control my-2" type="text" name="name_links[]">
                </div>
                <div class="col-6">
                    <label class="form-check-label" for="url-fonte">Inserisci il link della fonte</label> 
                    <input id="url-fonte" class="form-control my-2" type="text" name="urls[]">
                </div>
            </div>
            {{-- @foreach ($links as $link)
            <div class="form-check form-check-inline" id="links">
                <input class="form-check-input" type="checkbox" id="{{"link-$link->id"}}" value="{{$link->id}}" name="links[]" @if (in_array($link->id, old('links', $old_links ?? []))) checked @endif>
                <label class="form-check-label" for="{{"link-$link->id"}}">{{$link->name}}</label>                    
            </div>
            @endforeach --}}
        </div>
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