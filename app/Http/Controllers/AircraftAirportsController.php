<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AircraftAirportsController extends Controller
{
    /**
     * ручка    /api/aircraft_airports
     */
    public function index()
    {

        # параметры
        #
        $tail       =   'TEST-001' ;    // - бортовой номер воздушного судна
        $date_from  =   '';             // - начало периода (формат: yyyy-mm-dd hh:mm )     flights.takeoff
        $date_to    =   '';             // - конец периода (формат: yyyy-mm-dd hh:mm )      flights.landing



        # получить данные из базы
        #
        $select     = DB::select("
            SELECT
                 flights.*
                , airfrom.code_iata     as  airfrom_code_iata
                , airto.code_iata       as  airto_code_iata
            FROM
                flights
                    INNER JOIN  aircrafts               ON  flights.aircraft_id = aircrafts.id
                    INNER JOIN  airports as airfrom     ON  flights.airport_id1 = airfrom.id
                    INNER JOIN  airports as airto       ON  flights.airport_id2 = airto.id
            WHERE
                aircrafts.tail = '$tail'
            LIMIT
                1
        ");

        // dd($select);
        
        return response()->json($select);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
