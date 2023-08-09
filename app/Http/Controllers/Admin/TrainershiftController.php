<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shift;
use App\Models\Advance;
use App\Models\Trainer_shift;

class TrainershiftController extends Controller
{
    
    public function index()
    {
        //
    }

  
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
     
            $check = Trainer_shift::where('user_id',$request->trainer_id)->Where('shift_id',$request->shift)->exists();
            
            if($check == false ){
            Trainer_shift::create([
                'user_id' => $request->trainer_id,
                'role_id' => 4,
                'shift_id' => $request->shift,
            ]);
            toast('Shift Added' ,'success');
        }
        else{
            toast('Shift has already Taken' ,'warning');
        }
        return redirect()->back();

    }

    
    public function show($trainershift)
    {
      Trainer_shift::find($trainershift)->delete();
      toast(' Trainer Shift has been Removed Successfully !' ,'success');
      return redirect()->back();
    }

    
    public function edit($trainershift)
    {
      
       $payments_alert = Advance::with('getUserdetail')->join('users','users.id','=','advances.user_id')
       ->where('users.status' ,1)
       ->where('advances.initial_advance','<' , 0)
       ->get();

       $count_alert = Advance::with('getUserdetail')->join('users','users.id','=','advances.user_id')
               ->where('users.status' ,1)
               ->where('advances.initial_advance','<' , 0)
               ->count();
        $datas = User::with('getUserDetail')->Where('id',$trainershift)->first();
        $trainershifts = Trainer_shift::with(['users','shifts'])->Where('user_id',$trainershift)->get();
     
        $shifts = Shift::get();
       
       return view('backend.trainerprofile.trainerprofile',compact('payments_alert','count_alert','datas','shifts','trainershifts'));
    }

  
    public function update(Request $request, $trainershift)
    {
      
    }

   
    public function destroy($trainershift)
    {
        //
    }
}
