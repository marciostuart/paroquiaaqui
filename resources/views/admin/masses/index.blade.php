<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><title>Horários de missas</title></head><body><h1>Horários de missas</h1>
@if(session('status'))<p style="color:green">{{ session('status') }}</p>@endif
<form method="post" action="{{ route('admin.masses.store') }}">@csrf
<p>Comunidade: <input name="community_name" required> Endereço: <input name="address" size="35"></p><p>Dia e horário: <input name="schedule" placeholder="Domingos às 19h" size="35" required> Ordem: <input name="sort_order" type="number" value="0" min="0" size="3"></p><button>Adicionar horário</button></form>
<h2>Cadastrados</h2>@forelse($masses as $mass)<p><strong>{{ $mass->community_name }}</strong> — {{ $mass->schedule }} @if($mass->address)({{ $mass->address }})@endif <form style="display:inline" method="post" action="{{ route('admin.masses.destroy',$mass) }}">@csrf @method('DELETE')<button>Remover</button></form></p>@empty<p>Nenhum horário cadastrado.</p>@endforelse
<a href="{{ route('admin.dashboard') }}">Voltar ao painel</a></body></html>
