<?php

namespace App\Http\Controllers\Admin\Franchises;

use App\Actions\Admin\Franchises\CreateFranchise;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\Log;

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
            // Log dos dados recebidos
            Log::info('Tentativa de criar franquia', $request->all());

            $franchise = $this->createFranchise->execute($request->all());

            return redirect()
                ->route('admin.franchises.index')
                ->with('success', 'Franquia criada com sucesso!');
        } catch (InvalidArgumentException $e) {
            Log::error('Erro de validação ao criar franquia: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error('Erro ao criar franquia: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()
                ->withInput()
                ->withErrors(['message' => 'Erro ao criar franquia: ' . $e->getMessage()]);
        }
    }
}