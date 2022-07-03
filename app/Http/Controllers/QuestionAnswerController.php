<?php

namespace App\Http\Controllers;

use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $qas = QuestionAnswer::with([
            'user',
            'product'
        ])
            ->orderBy('updated_at', 'desc')->get();
        return response()->json($qas);
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
        // if ($request->user_id !== Auth::user()->id) {
        //     return redirect()->route("unauthorized");
        // }
        // $qa = QuestionAnswer::create($request->all());
        // return response()->json($qa);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionAnswer  $questionAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionAnswer $questionAnswer)
    {
        // $qa = QuestionAnswer::find($questionAnswer->id);
        // return response()->json($qa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionAnswer  $questionAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionAnswer $questionAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionAnswer  $questionAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionAnswer $questionAnswer)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $qa = QuestionAnswer::find($questionAnswer->id);
        $qa->update($request->all());
        return response()->json($qa);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionAnswer  $questionAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionAnswer $questionAnswer)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        return QuestionAnswer::destroy($questionAnswer->id);
    }
}
