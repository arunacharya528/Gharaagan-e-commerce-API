<?php

namespace App\Http\Controllers;

use App\Models\Advertisemnet;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware("auth:api")->only(["store", "update", 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisement = Advertisemnet::get();
        return response()->json($advertisement);
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
        $advertisement = Advertisemnet::create($request->all());
        return response()->json($advertisement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advertisemnet  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisemnet $advertisement)
    {
        $advertisement = Advertisemnet::find($advertisement->id);
        return response()->json($advertisement);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advertisemnet  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisemnet $advertisement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertisemnet  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertisemnet $advertisement)
    {
        $advertisement = Advertisemnet::find($advertisement->id);
        $advertisement->update($request->all());
        return response()->json($advertisement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisemnet $advertisement)
    {
        return Advertisemnet::destroy($advertisement->id);
    }
}
