<?php

namespace App\Actions\Admin\Franchises;

use App\Models\Central\Franchise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Illuminate\Support\Facades\Log;

class CreateFranchise
{
    public function execute(array $data): Franchise
    {
        $this->validate($data);

        try {
            return DB::transaction(function () use ($data) {
                // Limpa os dados antes de salvar
                $data['cnpj'] = preg_replace('/[^0-9]/', '', $data['cnpj']);
                $data['zip_code'] = preg_replace('/[^0-9]/', '', $data['zip_code']);
                $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']);

                // Gera o ID baseado no nome
                $tenantId = Franchise::createTenantId($data['name']);

                // Cria a franquia com o ID gerado
                $franchise = Franchise::create([
                    'id' => $tenantId,
                    'name' => $data['name'],
                    'company_name' => $data['company_name'],
                    'cnpj' => $data['cnpj'],
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'zip_code' => $data['zip_code'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                ]);

                // Cria o domínio para a franquia
                $franchise->domains()->create([
                    'domain' => $franchise->generateDomain(),
                ]);

                return $franchise;
            });
        } catch (\Exception $e) {
            Log::error('Erro na transação de criação de franquia: ' . $e->getMessage());
            throw $e;
        }
    }

    private function validate(array $data): void
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'min:14', 'max:14'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'size:2'],
            'zip_code' => ['required', 'string', 'min:8', 'max:8'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            Log::warning('Validação falhou', ['errors' => $validator->errors()->all()]);
            throw new InvalidArgumentException(
                implode(', ', $validator->errors()->all())
            );
        }

        // Valida CNPJ
        if (!Franchise::validateCNPJ($data['cnpj'])) {
            throw new InvalidArgumentException('CNPJ inválido');
        }

        // Valida formato do nome (Cidade - Área)
        if (!str_contains($data['name'], ' - ')) {
            throw new InvalidArgumentException('O nome deve seguir o formato "Cidade - Área"');
        }
    }
}