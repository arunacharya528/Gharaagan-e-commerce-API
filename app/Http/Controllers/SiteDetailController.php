<?php

namespace App\Http\Controllers;

use App\Models\SiteDetail;
use Illuminate\Http\Request;

class SiteDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = SiteDetail::get();
        return response()->json($details);
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
        $detail = SiteDetail::create($request->all());
        return response()->json($detail);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SiteDetail  $siteDetail
     * @return \Illuminate\Http\Response
     */
    public function show(SiteDetail $siteDetail)
    {
        $detail = SiteDetail::find($siteDetail->id);
        return response()->json($detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SiteDetail  $siteDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteDetail $siteDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteDetail  $siteDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteDetail $siteDetail)
    {
        $detail = SiteDetail::find($siteDetail->id);
        $detail->update($request->all());
        return response()->json($detail);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SiteDetail  $siteDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteDetail $siteDetail)
    {
        return SiteDetail::destroy($siteDetail->id);
    }
}
