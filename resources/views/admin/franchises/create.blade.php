@extends('layouts.admin')

@section('title', 'Nova Franquia')

@section('header', 'Criar Nova Franquia')

@section('content')
    <form action="{{ route('admin.franchises.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nome da Franquia -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Nome da Franquia
                </label>
                <div class="mt-1">
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="Ex: Foz do Iguaçu - Centro" required>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Use o formato: Cidade - Área
                </p>
            </div>

            <!-- Razão Social -->
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700">
                    Razão Social
                </label>
                <div class="mt-1">
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
            </div>

            <!-- CNPJ -->
            <div>
                <label for="cnpj" class="block text-sm font-medium text-gray-700">
                    CNPJ
                </label>
                <div class="mt-1">
                    <input type="text" name="cnpj" id="cnpj" value="{{ old('cnpj') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="00.000.000/0000-00" required>
                </div>
            </div>

             <!-- CEP -->
             <div class="col-span-2 md:col-span-1">
                <label for="zip_code" class="block text-sm font-medium text-gray-700">
                    CEP
                </label>
                <div class="mt-1 relative">
                    <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="00000-000" maxlength="9" required>
                    <div id="cep-loading" class="hidden absolute right-2 top-2">
                        <svg class="animate-spin h-5 w-5 text-gc-blue" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cidade -->
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">
                    Cidade
                </label>
                <div class="mt-1">
                    <input type="text" name="city" id="city" value="{{ old('city') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
            </div>

            <!-- Estado -->
            <div>
                <label for="state" class="block text-sm font-medium text-gray-700">
                    Estado
                </label>
                <div class="mt-1">
                    <select name="state" id="state"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        required>
                        <option value="">Selecione...</option>
                        @foreach (['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                            <option value="{{ $uf }}" {{ old('state') == $uf ? 'selected' : '' }}>
                                {{ $uf }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Endereço (Logradouro) -->
            <div class="col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">
                    Logradouro
                </label>
                <div class="mt-1">
                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
            </div>

            <!-- Número -->
            <div>
                <label for="number" class="block text-sm font-medium text-gray-700">
                    Número
                </label>
                <div class="mt-1">
                    <input type="text" name="number" id="number" value="{{ old('number') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
            </div>

            <!-- Complemento -->
            <div>
                <label for="complement" class="block text-sm font-medium text-gray-700">
                    Complemento
                </label>
                <div class="mt-1">
                    <input type="text" name="complement" id="complement" value="{{ old('complement') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>

            <!-- Bairro -->
            <div>
                <label for="neighborhood" class="block text-sm font-medium text-gray-700">
                    Bairro
                </label>
                <div class="mt-1">
                    <input type="text" name="neighborhood" id="neighborhood" value="{{ old('neighborhood') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
            </div>

            <!-- Telefone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">
                    Telefone
                </label>
                <div class="mt-1">
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="(00) 00000-0000" required>
                </div>
            </div>

            <!-- E-mail -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    E-mail
                </label>
                <div class="mt-1">
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="shadow-sm focus:ring-gc-blue focus:border-gc-blue block w-full sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
            </div>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-3 pt-6 border-t">
            <a href="{{ route('admin.franchises.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gc-blue">
                Cancelar
            </a>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gc-blue hover:bg-gc-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gc-blue">
                Criar Franquia
            </button>
        </div>
    </form>
@endsection
