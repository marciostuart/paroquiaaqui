<form method="post" action="{{ route('login.store') }}"><h1>Paróquia Aqui</h1>@csrf
<input name="email" type="email" placeholder="E-mail" required value="{{ old('email') }}"><input name="password" type="password" placeholder="Senha" required><label><input type="checkbox" name="remember"> Manter acesso</label><button>Entrar</button>@error('email')<p>{{ $message }}</p>@enderror</form>
