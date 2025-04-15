@extends('app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row  gap-2" style="gap: 1rem">
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-js="btn-confirm-submit" data-action="PUT"
                                        data-route="{{ route('clear.cache') }}" data-btnText="Limpar">
                                    Limpar Cache
                                </button>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
