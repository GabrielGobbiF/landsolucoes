@extends('app')

@section('title', 'Celular - ' . ucfirst($celular->linha))

@section('content')
    <style>
        .signature-pad {
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>

    <div class="box">
        <div class="box-body">
            <div class="container">
                <h2>Formulário de Assinatura</h2>
                <form id="signature-form" class="row" action="{{ route('celulares.signature.update', $celular->id) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input id="name" type="text" class="form-control" name="name_signature" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>Assinatura:</label>
                            <canvas id="signature-pad" class="signature-pad" width="500"></canvas>
                            <input id="signature" type="hidden" name="signature">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Assinatura</button>
                </form>
            </div>
        </div>
    </div>

@append

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script>
        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas);

        function updateSignature() {
            var data = signaturePad.toDataURL('image/png');
            document.getElementById('signature').value = data;
        }

        signaturePad.onEnd = function() {
            updateSignature();
        };

        document.getElementById('save').addEventListener('click', function() {
            var data = signaturePad.toDataURL('image/png');
        });

    </script>
@append
