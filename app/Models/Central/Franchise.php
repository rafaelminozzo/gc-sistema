<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Franchise extends BaseTenant implements TenantWithDatabase
{
    use HasFactory, HasDatabase, HasDomains;

    protected $table = 'franchises';

    protected $fillable = [
        'id',
        'name',
        'company_name',
        'cnpj',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'data' => 'array',
    ];

    /**
     * Gera um ID único para a franquia baseado no nome
     */
    public static function createTenantId(string $name): string
    {
        return str()->slug($name);
    }

    /**
     * Gera o domínio padrão para a franquia
     */
    public function generateDomain(): string
    {
        return $this->id . '.ginasticadocerebro.com.br';
    }

    /**
     * Valida CNPJ
     */
    public static function validateCNPJ(string $cnpj): bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Elimina CNPJs inválidos conhecidos
        if (preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }

        // Valida dígitos verificadores
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
}