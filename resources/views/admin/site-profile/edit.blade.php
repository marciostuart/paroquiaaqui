<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><title>Editar site</title></head><body>
<h1>Editar site — {{ $tenant->display_name }}</h1>
@if(session('status'))<p style="color:green">{{ session('status') }}</p>@endif
<form method="post" action="{{ route('admin.site.update') }}">@csrf @method('PUT')
<p>Sobre:<br><textarea name="about" rows="5" cols="70">{{ old('about',$profile->about) }}</textarea></p>
<p>Endereço:<br><input name="address" size="60" value="{{ old('address',$profile->address) }}"></p>
<p>Cidade: <input name="city" value="{{ old('city',$profile->city) }}"> UF: <input name="state" maxlength="2" size="3" value="{{ old('state',$profile->state) }}"></p>
<p>E-mail: <input type="email" name="contact_email" size="40" value="{{ old('contact_email',$profile->contact_email) }}"></p>
<p>Telefone: <input name="contact_phone" value="{{ old('contact_phone',$profile->contact_phone) }}"></p>
<p>Instagram: <input type="url" name="instagram_url" size="60" value="{{ old('instagram_url',$profile->instagram_url) }}"></p>
<button>Salvar alterações</button> <a href="{{ route('admin.dashboard') }}">Voltar</a></form></body></html>
