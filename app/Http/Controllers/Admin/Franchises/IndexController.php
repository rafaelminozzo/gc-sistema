<?php

namespace App\Http\Controllers\Admin\Franchises;

use App\Http\Controllers\Controller;
use App\Models\Central\Franchise;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $franchises = Franchise::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('cnpj', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        return view('admin.franchises.index', compact('franchises'));
    }
}