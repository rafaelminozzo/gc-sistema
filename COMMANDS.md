# Comandos Úteis

## Ambiente de Desenvolvimento

### Banco de Dados
```bash
# Executar migrações do banco central
php artisan migrate --path=database/migrations/central

# Executar migrações de uma franquia específica
php artisan tenants:migrate --tenant=nome-franquia
```

### Cache
```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Desenvolvimento
```bash
# Criar nova migração
php artisan make:migration create_nome_table

# Criar novo controller
php artisan make:controller NomeController

# Criar novo modelo
php artisan make:model Nome
```