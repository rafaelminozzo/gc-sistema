<?php

namespace App\Http\Controllers\Admin\Franchises;

use App\Http\Controllers\Controller;
use App\Models\Central\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Franchise::query();

        // Filtro por busca geral
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('cnpj', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Filtro por status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filtro por estado
        if ($state = $request->input('state')) {
            $query->where('state', $state);
        }

        // Ordenação
        $sortField = $request->input('sort', 'name');
        $sortDirection = $request->input('direction', 'asc');
        
        if (in_array($sortField, ['name', 'company_name', 'city', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        // Executa a query com paginação
        $franchises = $query->paginate(10);

        // Busca sugestões apenas se houver busca e não houver resultados
        $suggestions = collect();
        if ($search && $franchises->isEmpty()) {
            $suggestions = Franchise::where('name', 'like', "%{$search}%")
                ->orWhere(function($query) use ($search) {
                    // Busca por similaridade
                    $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                          ->orWhereRaw('LOWER(company_name) LIKE ?', ['%' . strtolower($search) . '%']);
                })
                ->take(3)
                ->get();
        }

        // Lista de estados para o filtro
        $states = Franchise::select('state')
            ->distinct()
            ->whereNotNull('state')
            ->orderBy('state')
            ->pluck('state');

        // Passa os dados para a view
        return view('admin.franchises.index', [
            'franchises' => $franchises,
            'states' => $states,
            'suggestions' => $suggestions,
            'search' => $search
        ]);
    }
}