<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Franchise extends BaseTenant implements TenantWithDatabase
{
    use HasFactory, HasDatabase, HasDomains, SoftDeletes;

    protected $table = 'tenants';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    /**
     * Os atributos que devem ser convertidos para tipos nativos
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'data' => 'array',
    ];

    /**
     * Gera um ID único para a franquia baseado no nome
     */
    public static function createTenantId(string $name): string
    {
        // Divide o nome em cidade e área
        $parts = explode(' - ', $name);

        if (count($parts) !== 2) {
            throw new \InvalidArgumentException(
                'O nome da franquia deve seguir o padrão "Cidade - Área"'
            );
        }

        $cidade = $parts[0];
        $area = $parts[1];

        // Remove acentos e caracteres especiais
        $cidade = iconv('UTF-8', 'ASCII//TRANSLIT', $cidade);
        $area = iconv('UTF-8', 'ASCII//TRANSLIT', $area);

        // Remove todos os caracteres especiais e espaços
        $cidade = preg_replace('/[^a-zA-Z0-9]/', '', $cidade);
        $area = preg_replace('/[^a-zA-Z0-9]/', '', $area);

        // Converte para minúsculas
        $cidade = strtolower($cidade);
        $area = strtolower($area);

        // Retorna no formato cidade-area
        return $cidade . '-' . $area;
    }

    /**
     * Valida um CNPJ
     */
    public static function validateCNPJ(string $cnpj): bool
    {
        // Remove caracteres não numéricos
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Verifica se tem 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($t = 12; $t < 14; $t++) {
            for ($d = 0, $p = $t - 7, $c = 0; $c < $t; $c++) {
                $d += $cnpj[$c] * $p;
                $p = ($p < 3) ? 9 : --$p;
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cnpj[$c] != $d) {
                return false;
            }
        }

        return true;
    }


    /**
     * Gera o domínio padrão para a franquia
     */
    public function generateDomain(): string
    {
        if (app()->environment('local')) {
            return $this->id . '.gc-sistema.test';
        }

        return $this->id . '.ginasticadocerebro.com.br';
    }

    protected static function booted()
    {
        static::creating(function ($franchise) {
            if (!$franchise->id) {
                $franchise->id = static::createTenantId($franchise->name);
            }
        });
    }
}
