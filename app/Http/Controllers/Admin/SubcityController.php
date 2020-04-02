<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subcity;
use Illuminate\Http\Request;
use Larapen\Admin\app\Http\Controllers\PanelController;

class SubcityController extends PanelController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "hello";
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
     * @param  \App\Models\Subcity  $subcity
     * @return \Illuminate\Http\Response
     */
    public function show($id,$childId = NULL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcity  $subcity
     * @return \Illuminate\Http\Response
     */
    
    public function edit($id,$childId = NULL)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcity  $subcity
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcity  $subcity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$childId = NULL)
    {
        //
    }
}
