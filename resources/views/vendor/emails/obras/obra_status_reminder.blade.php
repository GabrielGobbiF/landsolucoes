@component('mail::message')
# Lembrete de Serviço

Prezado **{{ $responsavel }}**
A proposta **{{ $routeObra }}** esta a 4 dias no status de Elaboração, se a mesma já foi encaminhada ao cliente atualizar no sistema para o status Enviada.

@component('mail::button', ['url' => $routeObra])
Ver Serviço
@endcomponent

Obrigado,<br>Sistema Land<br>
@endcomponent
