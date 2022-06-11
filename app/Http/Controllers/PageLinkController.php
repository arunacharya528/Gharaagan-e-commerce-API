<?php

namespace App\Http\Controllers;

use App\Models\PageLink;
use Database\Seeders\PageSeeder;
use Illuminate\Http\Request;

class PageLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = PageLink::orderBy('name', 'asc')->get();
        return response()->json($links);
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
        $link = PageLink::create($request->all());
        return response()->json($link);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PageLink  $pageLink
     * @return \Illuminate\Http\Response
     */
    public function show(PageLink $pageLink)
    {
        $link = PageLink::find($pageLink->id);
        return response()->json($link);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PageLink  $pageLink
     * @return \Illuminate\Http\Response
     */
    public function edit(PageLink $pageLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PageLink  $pageLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PageLink $pageLink)
    {
        $link = PageLink::find($pageLink->id);
        $link->update($request->all());
        return response()->json($link);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PageLink  $pageLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageLink $pageLink)
    {
        return PageLink::destroy($pageLink->id);
    }
}
