@extends("auth.app")

@section('content')

    <div class="login row justify-content-center align-items-center d-flex vh-100">
        <div class="col-lg-5 mx-auto">
            <div class="card">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                            <li>{{ session('error') }}</li>
                    </div>
                @endif
                <div class="card-body osahan-login p-5">
                    <form method="POST" action="{{ route('login') }}" class="needs-validation">
                        @csrf
                        <div class="text-center mb-5">
                            <a href="/"><img src="{{ asset('panel/images/logo-sm.png') }}" height="100" alt=""></a>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="text" class="form-control" name="email_or_username" value="{{ old('email') }}" required autocomplete="email"
                                autofocus>
                        </div>

                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        </div>

                        <div class="d-flex justify-content-between my-4">
                            <div class="align-self-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" checked="">

                                    <label class="form-check-label" for="remember">
                                        Lembrar
                                    </label>
                                </div>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-white-50 btn-type btn btn-link" href="{{ route('password.request') }}">
                                    <span class="ml-auto">{{ __('Esqueceu sua senha?') }}</span>
                                </a>
                            @endif
                        </div>

                        <button class="btn btn-primary btn-block text-uppercase btn-submit" type="submit" data-btn-text="Entrando...">
                            {{ __('Login') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
