<?php

namespace App\Http\Controllers\Administrador\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Models\Cats\CatAttentionClassification;
use Illuminate\Http\Request;
use App\Http\Resources\Catalogs\AttentionClassificationCollection as AtteClasResource;

class AttentionClassificationController extends Controller
{

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            if (isset($request->id)){
                $id = (int)$request->id;
                return AtteClasResource::collection(CatAttentionClassification::whereIsactive(1)
                                                    ->whereLevelAttentionsId($id)
                                                    ->get());
            }
        }
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
