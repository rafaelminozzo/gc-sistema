@extends('layouts.admin')

@section('title', 'Franquias')

@section('header', 'Gestão de Franquias')

@section('content')
    <!-- Filtros -->
    <div class="mb-6">
        <form action="{{ route('admin.franchises.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Busca -->
                <div class="col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                    <input type="text" 
                           name="search" 
                           id="search" 
                           value="{{ request('search') }}"
                           placeholder="Nome, Razão Social, CNPJ ou Cidade"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gc-blue focus:ring-gc-blue sm:text-sm">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" 
                            id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gc-blue focus:ring-gc-blue sm:text-sm">
                        <option value="">Todos</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspenso</option>
                    </select>
                </div>

                <!-- Estado -->
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="state" 
                            id="state"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gc-blue focus:ring-gc-blue sm:text-sm">
                        <option value="">Todos</option>
                        @foreach($states as $stateOption)
                            <option value="{{ $stateOption }}" {{ request('state') == $stateOption ? 'selected' : '' }}>
                                {{ $stateOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gc-blue hover:bg-gc-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gc-blue">
                        Filtrar
                    </button>

                    @if(request()->anyFilled(['search', 'status', 'state']))
                        <a href="{{ route('admin.franchises.index') }}"
                           class="text-sm text-gray-500 hover:text-gray-700">
                            Limpar filtros
                        </a>
                    @endif
                </div>

                <a href="{{ route('admin.franchises.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gc-blue hover:bg-gc-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gc-blue">
                    Nova Franquia
                </a>
            </div>
        </form>

        <!-- Sugestões "Você quis dizer" -->
        @if($search && $franchises->isEmpty() && $suggestions->isNotEmpty())
            <div class="mt-4 p-4 bg-yellow-50 rounded-md">
                <p class="text-yellow-700">
                    Nenhum resultado encontrado para "<strong>{{ $search }}</strong>".
                    <br>
                    Você quis dizer:
                </p>
                <ul class="mt-2 space-y-1">
                    @foreach($suggestions as $suggestion)
                        <li>
                            <a href="{{ route('admin.franchises.index', ['search' => $suggestion->name]) }}"
                               class="text-gc-blue hover:underline">
                                {{ $suggestion->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Tabela -->
    @if($franchises->isNotEmpty())
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
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
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Ações</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($franchises as $franchise)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $franchise->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $franchise->company_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $franchise->cnpj }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $franchise->city }}/{{ $franchise->state }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $franchise->status === 'active' ? 'bg-green-100 text-green-800' : 
                                       ($franchise->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-red-100 text-red-800') }}">
                                    {{ $franchise->status === 'active' ? 'Ativo' : 
                                       ($franchise->status === 'inactive' ? 'Inativo' : 'Suspenso') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.franchises.edit', $franchise) }}" class="text-gc-blue hover:text-gc-blue-dark">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $franchises->links() }}
        </div>
    @endif
@endsection