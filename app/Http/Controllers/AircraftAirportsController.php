<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class AircraftAirportsController extends Controller
{

    public function index()
    {

        # параметры
        #
        $validated  =   request()->validate([
            'tail'      => 'required|string',
            'date_from' => 'required|date',
            'date_to'   => 'required|date',
        ]);
        #
        #
        # не валидные данные
        #
        if (
            $validated['tail'] === null
            ||  $validated['date_from'] === null
            ||  $validated['date_to'] === null
        ) {
            // dd($validated);
            // return response()->json(['error'=>'invalid_params']);
        }



        # получить данные из базы
        #
        $select     =   DB::select(
            "
            SELECT
                -- прибыл из точки
                -- airfrom.code_iata    as  airfrom_iata
                
                -- текущее местонахождение судна
                  aircrafts.tail            as  tail
                , airto.id                  as  airport_id
                , airto.code_iata           as  code_iata
                , airto.code_icao           as  code_icao
                
                , flights.cargo_offload         -- разгрузка
                , flights.cargo_load            -- погрузка
                
                , flights.landing               -- когда прилетел в airto
                , flights.takeoff               -- когда утетел из airto
                
            FROM
                flights
                    JOIN  aircrafts               ON  flights.aircraft_id = aircrafts.id
                --  JOIN  airports as airfrom     ON  flights.airport_id1 = airfrom.id
                    JOIN  airports as airto       ON  flights.airport_id2 = airto.id

                    
            WHERE
                aircrafts.tail  =   :tail
                -- судно находилось в заданное время в аэропорте назначения (airto)
                AND flights.landing  BETWEEN  :date_from   AND  :date_to
            ",
            $validated
        );



        # отдать данные
        #
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
