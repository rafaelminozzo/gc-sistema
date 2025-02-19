<?php

namespace App\Actions\Admin\Franchises;

use App\Models\Central\Franchise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UpdateFranchise
{
    public function execute(Franchise $franchise, array $data): Franchise
    {
        // Limpa os dados antes da validação
        $data['cnpj'] = preg_replace('/[^0-9]/', '', $data['cnpj']);
        $data['zip_code'] = preg_replace('/[^0-9]/', '', $data['zip_code']);
        $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']);

        $this->validate($franchise, $data);

        try {
            return DB::transaction(function () use ($franchise, $data) {
                // Atualiza a franquia
                $franchise->update([
                    'name' => $data['name'],
                    'company_name' => $data['company_name'],
                    'cnpj' => $data['cnpj'],
                    'zip_code' => $data['zip_code'],
                    'address' => $data['address'],
                    'number' => $data['number'],
                    'complement' => $data['complement'],
                    'neighborhood' => $data['neighborhood'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'status' => $data['status']
                ]);

                return $franchise;
            });
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Erro ao atualizar franquia: ' . $e->getMessage());
        }
    }

    private function validate(Franchise $franchise, array $data): void
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'size:14', 'unique:tenants,cnpj,' . $franchise->id . ',id'],
            'zip_code' => ['required', 'string', 'size:8'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:20'],
            'complement' => ['nullable', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'size:2'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'status' => ['required', 'in:active,inactive,suspended'],
        ]);

        if ($validator->fails()) {
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