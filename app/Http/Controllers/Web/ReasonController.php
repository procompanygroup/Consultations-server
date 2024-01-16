<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Reason;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Web\Reason\StoreReasonRequest;
use App\Http\Requests\Web\Reason\UpdateReasonRequest;
use App\Http\Controllers\Controller;


class ReasonController extends Controller
{
    public $path = 'media/reasons';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = DB::table('reasons')->get();
        return view('admin.reason.show', ['reasons' => $list]);
        //return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reason.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formdata = $request->all();
        $validator = Validator::make(
            $formdata,
            $request->rules(),
            $request->messages()
        );

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)
                ->withInput();

        } else {

            $newObj = new Reason;
            $newObj->content = $formdata['content'];
            $newObj->type = $formdata['type'];
            $newObj->is_active = $formdata['is_active'];


            $newObj->save();


            return redirect()->back()->with('success_message', 'user has been Added!');
        }
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
        $object = DB::table('reasons')->find($id);

        //
        return view('admin.reason.edit', ['reason' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $formdata = $request->all();
        //validate      
        $validator = Validator::make(
            $formdata,
            $request->rules(),
            $request->messages()
        );
        if ($validator->fails()) {
            /*
              return redirect('/cpanel/users/add')
              ->withErrors($validator)
                          ->withInput();
                          */
            return redirect()->back()->withErrors($validator)
                ->withInput();

        } else {
            // $imagemodel = Reason::find($id);
            // $oldimage = $imagemodel->image;
            Reason::find($id)->update([
                'content' => $formdata['content'],
                'type' => $formdata['type'],
                'is_active' => $formdata['is_active'],
            ]);

        }
        return redirect()->back()->with('success_message', 'user has been Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $object = Reason::find($id);
        if (!($object === null)) {
            //delete object
            Reason::find($id)->delete();
        }
        return redirect()->route('admin.reason.show');
        // return  $this->index();
        //   return redirect()->route('users.index');

    }

}
