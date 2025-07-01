<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pantai;

class PantaiController extends Controller
{
    public function show($id)
    {
        $pantai = Pantai::findOrFail($id);
        return view('show', compact('pantai'));
    }
}
