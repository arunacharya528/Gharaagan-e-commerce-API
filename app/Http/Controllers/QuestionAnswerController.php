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
        $rating = QuestionAnswer::with([
            'answers',
            'user',
            'product'
        ])
            ->where(['parent_id' => null])
            ->orderBy('updated_at', 'desc')->get();
        return response()->json($rating);
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
        $rating = QuestionAnswer::create($request->all());
        return response()->json($rating);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionAnswer  $questionAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionAnswer $questionAnswer)
    {
        $rating = QuestionAnswer::find($questionAnswer->id);
        return response()->json($rating);
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
        $rating = QuestionAnswer::find($questionAnswer->id);
        $rating->update($request->all());
        return response()->json($rating);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionAnswer  $questionAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionAnswer $questionAnswer)
    {
        // Delete with respective parentid
        QuestionAnswer::where(['parent_id' => $questionAnswer->id])->delete();
        return QuestionAnswer::destroy($questionAnswer->id);
    }
}
