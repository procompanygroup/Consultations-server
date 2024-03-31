<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pointtransfer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\StorageController;
class PointTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $firstLetters = 'DCL-';
        $code = $this->GenerateCode($firstLetters);
        return response()->json($code);

    }
    public function GenerateCode($firstLetters)
    {     
        $firstsubLen = strlen($firstLetters) + 1;
        $numlist = Pointtransfer::where('num', 'like', $firstLetters . '%')->select(DB::raw((string) 'SUBSTR(num,' . $firstsubLen . ') as num'))->get();
        $numzro = 0;
        if ($numlist->isEmpty()) {

            $numzro = StorageController::addZeros(1);
        } else {
            $num = $numlist->max('num');
            $numzro = StorageController::addZeros((int) $num + 1);
        }
        //   $numlist = Pointtransfer::where('num', 'like', $firstLetters.'%')->select('num')->get();
        //select(DB::raw('SUBSTR(num, LOCATE("-", num) +  1) as num'))   
        //DB::raw('substr(num, 1, 4) as num')
        //    $firstLetters=   Str::upper("d");
        //   $firstLetters=  $firstLetters."CL-";
        //   Str::upper("d");
        // 
        $finalcode = Str::upper($firstLetters) . $numzro;
        return $finalcode;
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
