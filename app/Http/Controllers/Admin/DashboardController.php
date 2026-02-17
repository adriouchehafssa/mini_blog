<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    
     //Afficher la page principale du dashboard admin.
     
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard');
    }
}