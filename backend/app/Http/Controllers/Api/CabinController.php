<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabin;
use Illuminate\Http\Request;

class CabinController extends Controller
{
    public function index()
    {
        return Cabin::orderBy('name')->get();
    }
}

