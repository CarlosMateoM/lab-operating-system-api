<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catalogs =  Catalog::with('processes')->get();
        return response()->json(['catalogs' => $catalogs], 200);
    }

}
