<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ModeController extends Controller
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
