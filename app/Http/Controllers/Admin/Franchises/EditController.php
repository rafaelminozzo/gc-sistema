<?php

namespace App\Http\Controllers\Admin\Franchises;

use App\Http\Controllers\Controller;
use App\Models\Central\Franchise;

class EditController extends Controller
{
    public function __invoke(Franchise $franchise)
    {
        return view('admin.franchises.edit', compact('franchise'));
    }
}
