<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tenant->display_name }} | Paróquia Aqui</title>
    <style>
        :root { --primary: {{ $tenant->primary_color }}; --secondary: {{ $tenant->secondary_color }}; }
        body { margin: 0; font-family: system-ui, sans-serif; color: #172033; background: #f8fafc; }
        header { color: white; padding: 4rem 1.5rem; text-align: center; background: linear-gradient(135deg, var(--primary), var(--secondary)); }
        main { max-width: 880px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
        section { background: white; border-radius: 16px; padding: 1.5rem; margin-top: 1rem; box-shadow: 0 4px 18px #17203312; }
        .notice { color: #64748b; }
    </style>
</head>
<body>
    <header>
        <h1>{{ $tenant->display_name }}</h1>
        <p>Site institucional em preparação</p>
    </header>
    <main>
        <section>
            <h2>Bem-vindo</h2>
            <p>{{ $profile?->about ?: 'Esta paróquia está sendo preparada na nova plataforma Paróquia Aqui.' }}</p>
        </section>
        @if($masses->isNotEmpty())<section><h2>Horários das Missas</h2>@foreach($masses as $mass)<p><strong>{{ $mass->community_name }}</strong><br>{{ $mass->schedule }}@if($mass->address)<br>{{ $mass->address }}@endif</p>@endforeach</section>@endif
    </main>
</body>
</html>
