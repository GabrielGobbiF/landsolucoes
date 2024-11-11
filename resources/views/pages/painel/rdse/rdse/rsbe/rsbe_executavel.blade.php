@extends('app')

@section('title', 'Editar - ' . ucfirst($rdse->n_order) . ' - ' . ucfirst($rdse->description))

@section('content-max-fluid')

    <style class="">
        #handsontable-container {
            width: 100%;
            height: 400px;
            /* Ajuste conforme necessário */
            overflow: auto;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.css">


    <div class="card text-start">
        <div class="card-body">
            <h4 class="card-title"></h4>
            <p class="card-text">
            <h1>Resb Enel
            </h1>
            <div id="handsontable-container"></div>
            </p>
        </div>
    </div>


@endsection

@section('scripts')


    <script src="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById('handsontable-container');

            // Dados de exemplo, baseado nos dados fornecidos
            const data = [{
                    cod_mat: "321638",
                    und: "PC",
                    descricao: "SELA,PORC,TIPO1,PM-BR500.65",
                    quant_plan: "0",
                },
                {
                    cod_mat: "325071",
                    und: "M",
                    descricao: "CABO,ACO-CU,ATERR,35MM²,ISOL,PM-BR805.02",
                    quant_plan: "0",

                },
                {
                    cod_mat: "325071",
                    und: "M",
                    descricao: "CABO,ACO-CU,ATERR,35MM²,ISOL,PM-BR805.02",
                    quant_plan: "0",

                },
                {
                    cod_mat: "329304",
                    und: "PC",
                    descricao: "CONECT,PARAF FEND,35/35,PM-BR710.35",
                    quant_plan: "0",

                },
                {
                    cod_mat: "329304",
                    und: "PC",
                    descricao: "CONECT,PARAF FEND,35/35,PM-BR710.35",
                    quant_plan: "0",

                },
                {
                    cod_mat: "336821",
                    und: "PC",
                    descricao: "CONEC,TERM,TORQ,BIM,35-95MM2,1F,D71063",
                    quant_plan: "0",

                },
                {
                    cod_mat: "337308",
                    und: "PC",
                    descricao: "TACO FIB,150X50X54,1F,45,D230.05/9",
                    quant_plan: "0",


                },
                {
                    cod_mat: "337331",
                    und: "PC",
                    descricao: "CAPUZ TERM,TIPO B,D=48MM L=95MM,D551.02",
                    quant_plan: "0",

                },
                {
                    cod_mat: "337332",
                    und: "PC",
                    descricao: "CAPUZ TERM,TIPO C,D=75MM L=133MM,D551.02",
                    quant_plan: "0",

                },
                {
                    cod_mat: "337382",
                    und: "JG",
                    descricao: "TERM CABO 8,7/15KV INT UNIP 500MM2 TORQ",
                    quant_plan: "0",

                },
                {
                    cod_mat: "337640",
                    und: "ROL",
                    descricao: "FITA,ISOL,AUTOFUS,25MMX10M,PM-BR220.02",
                    quant_plan: "0",


                },
                {
                    cod_mat: "337804",
                    und: "JG",
                    descricao: "EMENDA CAB-EXT 15KV RET 500 TORQ EPDM",
                    quant_plan: "0",


                },
                {
                    cod_mat: "337904",
                    und: "PC",
                    descricao: "SUPORTE,VERTICAL,AÇO,7FUROS,PM-BR480.18",
                    quant_plan: "0",


                },
                {
                    cod_mat: "348121",
                    und: "ROL",
                    descricao: "FITA,ISOL,AMARELA,50MMX33M,PM-BR220.06",
                    quant_plan: "0",


                },
                {
                    cod_mat: "348140",
                    und: "ROL",
                    descricao: "FITA,ISOL,ADE,PRETA,19MMX20M,PM-BR220.01",
                    quant_plan: "0",


                },
                {
                    cod_mat: "348165",
                    und: "PC",
                    descricao: "ABRAC,PLAST,1.8X7.6X390MM,PM-BR761.01",
                    quant_plan: "0",

                }
            ];

            // Configuração do Handsontable
            const hot = new Handsontable(container, {
                data: data, // Carrega os dados fornecidos
                colHeaders: ['Cód. Mat', 'UND', 'Descrição', 'Quant. Plan'], // Cabeçalhos
                columns: [{
                        data: 'cod_mat',

                    },
                    {
                        data: 'und',

                    },
                    {
                        data: 'descricao',

                    },
                    {
                        data: 'quant_plan',

                    },

                ],
                rowHeaders: true,
                filters: true,
                dropdownMenu: true,
                licenseKey: 'non-commercial-and-evaluation'
            });

            // Função para carregar dados da API
            //function loadUsers() {
            //    fetch(`{{ route('api.handswork.all') }}`)
            //        .then(response => response.json())
            //        .then(data => {
            //            console.log(data.data);
            //            hot.loadData(data.data);
            //        })
            //        .catch(error => console.error('Erro ao carregar dados:', error));
            //}

            // Chama a função para carregar os dados
            //loadUsers();
        });
    </script>

@append
