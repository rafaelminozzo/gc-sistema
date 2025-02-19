@extends('layouts.admin')

@section('title', 'Franquias')

@section('header', 'Gestão de Franquias')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-medium text-gray-900">
            Lista de Franquias
        </h2>
        <a href="{{ route('admin.franchises.create') }}" 
           class="bg-gc-blue hover:bg-gc-blue-dark text-white font-bold py-2 px-4 rounded">
            Nova Franquia
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nome
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Razão Social
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        CNPJ
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Cidade/UF
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($franchises as $franchise)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $franchise->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $franchise->company_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $franchise->cnpj }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $franchise->city }}/{{ $franchise->state }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $franchise->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($franchise->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : 
                                    'bg-red-100 text-red-800') }}">
                                {{ $franchise->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-gc-blue hover:text-gc-blue-dark mr-3">Editar</a>
                            <a href="#" class="text-gc-blue hover:text-gc-blue-dark">Visualizar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            Nenhuma franquia encontrada
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $franchises->links() }}
    </div>
@endsection