<?php

namespace App\Http\Controllers\Admin\Franchises;

use App\Actions\Admin\Franchises\UpdateFranchise;
use App\Http\Controllers\Controller;
use App\Models\Central\Franchise;
use Illuminate\Http\Request;
use InvalidArgumentException;

class UpdateController extends Controller
{
    public function __construct(
        private readonly UpdateFranchise $updateFranchise
    ) {}

    public function __invoke(Request $request, Franchise $franchise)
    {
        try {
            $this->updateFranchise->execute($franchise, $request->all());

            return redirect()
                ->route('admin.franchises.index')
                ->with('success', 'Franquia atualizada com sucesso!');
        } catch (InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->withErrors(['message' => $e->getMessage()]);
        }
    }
}