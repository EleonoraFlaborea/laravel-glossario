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
            <div class="@error('urls.*') is-invalid @elseif(old('urls.*', '')) is-valid @enderror"></div>            
            @error('urls.*')            
                <div class="invalid-feedback">{{$message}}</div>
            @enderror            
            <div id="input-link"></div>
            {{-- <div style="min-height: 120px;">
              <div class="collapse collapse-horizontal" id="collapseWidthExample">
                <div class="row" style="width: 600px;">
                  <div class="col-6">
                      <label class="form-check-label" for="nome-fonte">Inserisci il nome della fonte</label> 
                      <input id="nome-fonte" class="form-control my-2" type="text" name="name_links[]">
                  </div>
                  <div class="col-6">
                      <label class="form-check-label" for="url-fonte">Inserisci il link della fonte</label> 
                      <input id="url-fonte" class="form-control my-2" type="text" name="urls[]">
                  </div>
                </div>
              </div>
            </div> --}}
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
    let count = 0;
    newLinkButton.addEventListener('click', event =>{
        event.preventDefault()
        const newInput = document.createElement('div');
        count++;
        newInput.classList.add('row', 'my-3');
        newInput.innerHTML=`
            <div class="col-6">
                <label class="form-check-label " for="nome-fonte-${count}">Inserisci il nome della fonte</label> 
                <input id="nome-fonte-${count}"  class="form-control my-2" type="text" name="name_links[]">
            </div>
            <div class="col-6">
                <label class="form-check-label " for="url-fonte-${count}">Inserisci il link della fonte</label> 
                <input id="url-fonte-${count}" class="form-control my-2" type="text" name="urls[]">
            </div>`;
        inputLink.appendChild(newInput);
    });
</script>
@endsection

{{-- @dd($errors) --}}