<h1>Painel {{ $user->tenant?->display_name ?? 'Master' }}</h1>
<p>Nova plataforma em homologação.</p>
<a href="{{ route('admin.domains.index') }}">Domínios do site</a><br>
<a href="{{ route('admin.site.edit') }}">Editar conteúdo do site</a>
<br><a href="{{ route('admin.masses.index') }}">Horários de missas</a>
<form method="post" action="{{ route('logout') }}">@csrf<button>Sair</button></form>
