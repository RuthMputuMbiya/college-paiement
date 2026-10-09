<?php
// app/Http/Controllers/Gestionnaire/LogController.php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    /**
     * Afficher la liste des logs
     */
    public function index()
    {
        // Récupérer les logs depuis la table sessions ou une collection vide
        $logs = collect([]);
        
        // Alternative: récupérer les logs depuis la table sessions si elle existe
        if (DB::table('information_schema.tables')->where('table_name', 'sessions')->exists()) {
            $logs = DB::table('sessions')->orderBy('last_activity', 'desc')->paginate(30);
        }
        
        return view('gestionnaire.logs.index', compact('logs'));
    }
}