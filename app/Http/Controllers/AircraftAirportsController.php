<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class AircraftAirportsController extends Controller
{
    /**
     * ручка:
     * /api/aircraft_airports
     * 
     * Параметры:
     * tail - бортовой номер воздушного судна
     * date_from - начало периода (формат: yyyy-mm-dd hh:mm )
     * date_to - конец периода (формат: yyyy-mm-dd hh:mm )
     * 
     * 
     * Поля ответа
     *  airport_id              - id аэропорта
     *  code_iata               - код IATA аэропорта
     *  code_icao               - код ICAO аэропорта
     * 
     *  flights.takeoff         - времени вылета из этого аэропорта     / вылет
     *  flights.landing         - времени посадки в этот аэропорт       / прилет
     * 
     *  flights.cargo_offload   - объёма разгрузки в этом аэропорту
     *  flights.cargo_load      - объёма загрузки в этом аэропорту
     */
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
        $select     =   DB::select("
            SELECT
                  aircrafts.tail
                , airto.id            as  airport_id
                , airto.code_iata     as  code_iata
                , airto.code_icao     as  code_icao
                
                , flights.takeoff
                , flights.landing
                , flights.cargo_offload
                , flights.cargo_load
                
            FROM
                flights
                    JOIN  aircrafts               ON  flights.aircraft_id = aircrafts.id
                    JOIN  airports as airto       ON  flights.airport_id2 = airto.id

                    -- не понял нейминг flights.airport_id1 , flights.airport_id2
                    -- но добавить в выдачу результыты из другой таблицы - не проблема
                    -- JOIN  airports as airfrom     ON  flights.airport_id1 = airfrom.id
            WHERE
                aircrafts.tail          =    :tail
                AND flights.takeoff     >=   :date_from
                AND flights.landing     <=   :date_to
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
