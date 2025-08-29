<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FontController extends Controller {

    public function index() {
        return Inertia::render('Home');
    }

    public function identify(Request $request) {
        // Lógica para identificar la fuente
    }

}
