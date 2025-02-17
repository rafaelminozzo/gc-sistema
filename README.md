# Sistema Ginástica do Cérebro

Sistema integrado para gestão de franquias da Ginástica do Cérebro.

## Requisitos

- PHP 8.3+
- MySQL 5.7+
- Composer 2.7+
- Node.js 22+
- NPM 10+

## Instalação

1. Clone o repositório
2. Copie o arquivo `.env.example` para `.env`
3. Configure as variáveis de ambiente no `.env`
4. Execute:
```bash
composer install
php artisan key:generate
php artisan migrate
```

## Estrutura do Projeto

- Multi-tenancy para gestão isolada de franquias
- Banco de dados central para gestão da rede
- Banco de dados individual por franquia
- Sistema de autenticação e permissões por nível

## Desenvolvimento

### Padrões de Commit

Utilizamos o padrão Conventional Commits:

- `feat`: Nova funcionalidade
- `fix`: Correção de bug
- `docs`: Documentação
- `style`: Formatação
- `refactor`: Refatoração de código
- `test`: Testes
- `chore`: Tarefas de manutenção

### Branches

- `main`: Produção
- `develop`: Desenvolvimento
- `feature/*`: Novas funcionalidades
- `hotfix/*`: Correções urgentes

## Licença

Proprietário - Ginástica do Cérebro © 2024