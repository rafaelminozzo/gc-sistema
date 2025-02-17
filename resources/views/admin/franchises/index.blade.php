<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franquias - Ginástica do Cérebro</title>
</head>

<body>
    <h1>Franquias</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.franchises.create') }}">Nova Franquia</a>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Razão Social</th>
                <th>CNPJ</th>
                <th>Cidade/UF</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($franchises as $franchise)
                <tr>
                    <td>{{ $franchise->name }}</td>
                    <td>{{ $franchise->company_name }}</td>
                    <td>{{ $franchise->cnpj }}</td>
                    <td>{{ $franchise->city }}/{{ $franchise->state }}</td>
                    <td>{{ $franchise->status }}</td>
                    <td>
                        <a href="#">Editar</a>
                        <a href="#">Visualizar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nenhuma franquia encontrada</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $franchises->links() }}
</body>

</html>
