<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ModelController extends Controller
{
    public function index(Request $request)
    {
   
        $slider = User::findOrFail($request->slider_id);
        $slider-> mode = $request->status;
        $slider->save();

        if ($slider->mode == 1) {
            $noties = array(
                'message' => 'Dark Mode Activated !',
                'atype' => 'success',
                'aicon' => 'success'
            );
           
          
        } else {
            $noties = array(
                'message' => 'Dark Mode Deactivated !',
                'atype' => 'success',
                'aicon' => 'info'
            );
        }
        return Response::json($noties);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $slider = User::findOrFail($request->slider_id);
        if($request->status == 1){
            $slider-> collapse = '0';
            $slider->save();
        }
        else{
            $slider-> collapse = '1';
            $slider->save();
        }
       

        if ($slider->collapse == 1) {
            $noties = array(
                'message' => 'Collapse Activated !',
                'atype' => 'success',
                'aicon' => 'success'
            );
                   
        } else {
            $noties = array(
                'message' => 'Collapse Deactivated !',
                'atype' => 'success',
                'aicon' => 'info'
            );
        }
        return Response::json($noties);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
