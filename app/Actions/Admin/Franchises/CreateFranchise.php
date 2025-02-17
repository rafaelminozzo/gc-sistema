<?php

namespace App\Actions\Admin\Franchises;

use App\Models\Central\Franchise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class CreateFranchise
{
    public function execute(array $data): Franchise
    {
        $this->validate($data);

        return DB::transaction(function () use ($data) {
            // Cria o ID do tenant baseado no nome da franquia
            $data['id'] = Franchise::createTenantId($data['name']);

            // Limpa o CNPJ antes de salvar
            $data['cnpj'] = preg_replace('/[^0-9]/', '', $data['cnpj']);

            // Cria a franquia
            $franchise = Franchise::create($data);

            // Cria o domínio padrão para a franquia
            $franchise->domains()->create([
                'domain' => $franchise->generateDomain(),
            ]);

            return $franchise;
        });
    }

    private function validate(array $data): void
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'size:14', 'unique:franchises,cnpj'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'size:2'],
            'zip_code' => ['required', 'string', 'size:8'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException(
                'Dados inválidos: ' . implode(', ', $validator->errors()->all())
            );
        }

        // Valida CNPJ
        if (!Franchise::validateCNPJ($data['cnpj'])) {
            throw new InvalidArgumentException('CNPJ inválido');
        }
    }
}