<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $links=$this->getlinks();
        return view('site.home',['linksarr'=>$links]);
    }
    public function getpage($slug)
    {
      $page= $this->findbyname($slug);
      if($page && $page->dept=='pages'){
        return view('site.page',compact('page'));
      }else{
        abort(404, '');
      }
       
      
    }

    
    public function getlinks()
    { 
        $gplay_linkval="#";
        $appstor_linkval="#";
        $gplay_link=$this->findbyname('gplay_link');
        if($gplay_link){
            $gplay_linkval=   $gplay_link->value;
        }
        $appstor_link=$this->findbyname('appstor_link');
        if( $appstor_link){
            $appstor_linkval=  $appstor_link->value;
        }
        $appstor_link=$this->findbyname('appstor_link');
    
        return 
            [   'gplay_link' => $gplay_linkval,
                'appstor_link' => $appstor_linkval,
                ]  ;
    }
    public function findbyname(string $name)
    {
      $object=Setting::where('name',$name)->first();
      
      return $object;
    }
}
