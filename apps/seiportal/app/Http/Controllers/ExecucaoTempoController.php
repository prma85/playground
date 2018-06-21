<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ExecucaoTempo;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ExecucaoTempoController extends Controller
{
   public function index()
    {
        $execucoesTempos = ExecucaoTempo::all();
        return response()->json(compact('execucoesTempos'));
    }
}
