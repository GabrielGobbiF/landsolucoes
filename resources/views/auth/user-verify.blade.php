@extends("auth.app")

@section('content')

    <div class="login row justify-content-center align-items-center d-flex vh-100">
        <div class="col-lg-5 mx-auto">
            <div class="card">
                <div class="card-body osahan-login p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.verify') }}">
                        @csrf
                        <div class="text-center mb-4">
                            <a href="/"><img src="{{ asset('panel/images/logo-sm.svg') }}" height="100" alt=""></a>
                        </div>

                        <div class="my-3">
                            <h6 class="text-center mb-3">Bem-Vindo</h6>
                            <span class="">Para continuar usando o sistema da BestPlay<br> <code>troque sua senha!</code></span>
                        </div>

                        <div class="form-group">
                            <label for="input--password">Senha</label>
                            <input type="password" name="password" class="form-control" id="input--password"
                                value="{{ old('password') }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">Confirme sua senha</label>
                            <div class="position-relative icon-form-control">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block text-uppercase" type="submit">
                            CONFIRMAR
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
