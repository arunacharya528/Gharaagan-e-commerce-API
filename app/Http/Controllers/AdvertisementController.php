<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        // $this->middleware("auth:api")->only(["store", "update", 'destroy']);
    }

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

        $advertisements = Advertisement::with('file')->get();
        return response()->json($advertisements);
    }

    public function activeAdvertisement(Request $request)
    {
        try {
            $advertisements = Advertisement::with('file');
            $advertisements = $advertisements->where('active', true);
            $advertisements = $advertisements->whereDate('active_from', '<=', (date('Y-m-d')));
            $advertisements = $advertisements->whereDate('active_to', '>=', (date('Y-m-d')));
            $advertisements =  $advertisements->get();
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return response()->json(['error' => 'There was a problem retreiving data'], 500);
        }

        return response()->json($advertisements);
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
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $advertisement = Advertisement::create($request->all());
        return response()->json($advertisement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisement $advertisement)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $advertisement = Advertisement::find($advertisement->id);
        return response()->json($advertisement);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $advertisement = Advertisement::find($advertisement->id);
        $advertisement->update($request->all());
        return response()->json($advertisement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $advertisement)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        return Advertisement::destroy($advertisement->id);
    }
}
