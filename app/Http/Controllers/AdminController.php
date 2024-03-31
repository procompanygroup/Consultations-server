<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Expert;
use App\Models\Service;
use App\Models\Selectedservice;
use App\Models\User;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return 'Illuminate\View\View'
     */
    public function index()
    {
        $experts_count = Expert::where('is_active',1)->select('id','is_active')->count();
        $clients_count = Client::where('is_active',1)->select('id','is_active')->count();
        $services_count = Service::where('is_active',1)->whereNot('is_callservice',1)->select('id','is_active')->count();
        $calls_count = Selectedservice::where('status','call')->select('id')->count();
        // return response (view('admin.home')); 
        return  view('admin.home',[
            'experts_count' =>  $experts_count,
            'clients_count' =>  $clients_count,
            'services_count' => $services_count,
            'calls_count' =>   $calls_count,
            ]) ; 
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
