<div class="card text-start">
    <div class="card-body">
        @include('pages.painel.rdse.rdse.atividade.divAtividade')
    </div>
</div>

@section('scripts')
    {{--
    <script>
        document.querySelectorAll('.removeRowBtn').forEach(button => {
            addRemoveEvent(button);
        });

        function adicionarLinha() {

            const tableBody = document.querySelector('#itemsTable tbody');
            const rowCount = tableBody.rows.length + 1;

            const newRow = document.createElement('tr');
            newRow.setAttribute('data-id', rowCount);

            newRow.innerHTML = `
            <tr>
                <td>
                    <input type="text" name="itens[${rowCount}][id]" class="form-control" placeholder="Nome da Atividade">
                </td>
                <td style="text-align: end">
                    <button type="button" class="btn btn-danger removeRowBtn">&times;</button>
                </td>
            </tr>`;

            tableBody.appendChild(newRow);

            // Adiciona o evento de remoção ao novo botão
            const newButton = newRow.querySelector('.removeRowBtn');
            addRemoveEvent(newButton);

            newSelect(document.getElementById(`select--itens-${rowCount}`));
        }

        function addRemoveEvent(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const tr = this.closest('tr');
                if (tr) {
                    tr.remove();
                    calculateSubTotal(); // Recalcula o subtotal após remover a linha
                }
            });
        }
    </script>
    --}}
@append
