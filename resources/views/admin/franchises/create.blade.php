<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Franquia - Ginástica do Cérebro</title>
</head>
<body>
    <h1>Nova Franquia</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.franchises.store') }}" method="POST">
        @csrf
        
        <div>
            <label for="name">Nome da Franquia</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="company_name">Razão Social</label>
            <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" required>
        </div>

        <div>
            <label for="cnpj">CNPJ</label>
            <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" required>
        </div>

        <div>
            <label for="address">Endereço</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}" required>
        </div>

        <div>
            <label for="city">Cidade</label>
            <input type="text" id="city" name="city" value="{{ old('city') }}" required>
        </div>

        <div>
            <label for="state">Estado</label>
            <input type="text" id="state" name="state" value="{{ old('state') }}" required maxlength="2">
        </div>

        <div>
            <label for="zip_code">CEP</label>
            <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
        </div>

        <div>
            <label for="phone">Telefone</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
        </div>

        <div>
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <button type="submit">Criar Franquia</button>
            <a href="{{ route('admin.franchises.index') }}">Cancelar</a>
        </div>
    </form>
</body>
</html>