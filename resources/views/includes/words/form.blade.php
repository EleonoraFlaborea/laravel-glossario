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
                @error('word_name')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
        </div>

        {{-- Input description --}}
        <div class="col-12">
            <div class="form-group">
                <label for="description">Descrizione parola</label>
                <textarea name="description" id="description" class="form-control my-2 @error('description') is-invalid @elseif(old('description', '')) is-valid @enderror" rows="10">{{old('description', $word->description)}}</textarea>
                @error('description')
                <div class="invalid-feedback">{{$message}}</div>
                @else
                <div class="form-text">Inserisci la descrizione della parola</div>
                @enderror
            </div>
        </div>
        
        <div class="col-12">       
            <button id="new-link-button" class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse">
                Inserisci link 
            </button>
            <div class="@error('links.*') is-invalid @elseif(old('links.*', '')) is-valid @enderror"></div>            
            @error('links.*')            
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
            {{-- Div per raccogliere gli input che verranno creati per i link --}}
            @if($word->exists)
            <div id="old-input">
            @foreach ($word->links as $i => $link)
            <div class="row old my-3">
                <div class="col-6">
                    <label class="form-check-label" for="nome-fonte-{{$i}}">Inserisci il nome della fonte</label> 
                    <input id="nome-fonte-{{$i}}"  class="form-control my-2 " type="text" value="{{$link['name']}}" name="links[link-{{$i}}][name]">
                </div>
                <div class="col-6">
                    <label class="form-check-label" for="url-fonte-{{$i}}">Inserisci il link della fonte</label> 
                    <input id="url-fonte-{{$i}}" class="form-control my-2" type="text" value="{{$link['url']}}" name="links[link-{{$i}}][url]">
                </div>
            </div> 
            @endforeach
            </div>
            @endif
            <div id="input-link"></div>
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

{{-- Script --}}
@section('scripts')    
<script>
    const newLinkButton = document.getElementById('new-link-button');
    const inputLink = document.getElementById('input-link');
    let count = document.querySelectorAll('.old').length;
    newLinkButton.addEventListener('click', event =>{
        event.preventDefault()
        const newInput = document.createElement('div');
        newInput.classList.add('row', 'my-3');
        newInput.innerHTML=`
            <div class="col-6">
                <label class="form-check-label " for="nome-fonte-${count}">Inserisci il nome della fonte</label> 
                <input id="nome-fonte-${count}"  class="form-control my-2" type="text" name="links[link-${count}][name]">
            </div>
            <div class="col-6">
                <label class="form-check-label " for="url-fonte-${count}">Inserisci il link della fonte</label> 
                <input id="url-fonte-${count}" class="form-control my-2" type="text" name="links[link-${count}][url]">
            </div>`;
        inputLink.appendChild(newInput);
        count++;
    });
</script>
@endsection

{{-- @dd($errors) --}}