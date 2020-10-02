@if ($errors->any())
    @foreach ($errors->all() as $error)
        toastr.error('{{ $error }}')
    @endforeach
@endif

@if (session('message'))
    toastr.success('{{ session('message') }}')
@endif

@if (session('error'))
    toastr.error('{{ session('error') }}')
@endif
