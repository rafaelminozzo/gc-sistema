<?php

namespace App\Http\Controllers\Admin\Franchises;

use App\Actions\Admin\Franchises\CreateFranchise;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use InvalidArgumentException;

class CreateController extends Controller
{
    public function __construct(
        private readonly CreateFranchise $createFranchise
    ) {}

    public function create()
    {
        return view('admin.franchises.create');
    }

    public function __invoke(Request $request)
    {
        try {
            $franchise = $this->createFranchise->execute($request->all());

            return redirect()
                ->route('admin.franchises.index')
                ->with('success', 'Franquia criada com sucesso!');
        } catch (InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->withErrors(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['message' => 'Erro ao criar franquia. Tente novamente.']);
        }
    }
}