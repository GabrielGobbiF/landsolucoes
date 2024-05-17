@extends('auth.app')

@section('content')
    <div class="login row justify-content-center align-items-center d-flex vh-100">
        <div class="col-lg-5 mx-auto">
            <div class="card">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-body osahan-login p-5">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="text-center mb-4">
                            <a href="/"><img src="{{ asset('panel/images/logo-sm.svg') }}" height="100" alt=""></a>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-submit" data-btn-text="Enviando...">
                                    Enviar Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
