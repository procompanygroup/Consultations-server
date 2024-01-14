<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return 'Illuminate\View\View'
     */
    public function index()
    {
       // return response (view('admin.home')); 
        return  view('admin.home') ; 
    }

  
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }

     
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
