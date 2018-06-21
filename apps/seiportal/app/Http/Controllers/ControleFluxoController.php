<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ControleFluxo;
use App\Http\Controllers\Controller;

class ControleFluxoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controlefluxo = new ControleFluxo();
        $controleFluxos =  $controlefluxo->all();
        $jobs = $controlefluxo->groupby('cof_dsc_job')->get(['cof_dsc_job']);
        $transfomacoes = $controlefluxo->groupby('cof_dsc_transformacao' , 'cof_tipo_carga' , 'cof_flg_ativo')->get(['cof_dsc_transformacao' , 'cof_tipo_carga' , 'cof_flg_ativo']);
        return response()->json(compact('controleFluxos' , 'jobs' , 'transfomacoes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
