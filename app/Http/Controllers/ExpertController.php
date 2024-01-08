<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 
use Illuminate\Routing\Router;
use App\Models\Expert;
use Illuminate\Support\Facades\DB;
 
use File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Redirector;
//use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Requests\Api\Client\StoreClientRequest;
class ExpertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index()
    {
        $users = DB::table('experts')->get();
        // return view('admin.user.showusers',['users' => $users]); 
        return response()->json($users);
    }
    public function addUser(Expert $newExpert)
    {
        $newExpert->save();
        return $newExpert;
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
