<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shift;
use App\Models\Advance;
use App\Models\AnualPayment;
use App\Models\Package;
use App\Models\Payment;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function adminHome()
    {
        $payments_alert = Advance::with('getUserdetail')->join('users','users.id','=','advances.user_id')
            ->where('users.status' ,1)
            ->where('advances.initial_advance','<' , 0)
            ->get();

        $count_alert = Advance::with('getUserdetail')->join('users','users.id','=','advances.user_id')
            ->where('users.status' ,1)
            ->where('advances.initial_advance','<' , 0)
            ->count();
        $active_gymer =User::Where('role','5')->Where('status',1)->count();
        $inactive_gymer =User::Where('role','5')->Where('status',0)->count();
        $admin = User::Where('role','2')->count();
        $trainer = User::Where('role','4')->count();
        $total_amount = Payment::sum('amount');
        $offer = Package::count();
        $anual_payment = AnualPayment::count();
        return view('backend.adminhome',compact('payments_alert','count_alert','active_gymer','inactive_gymer','trainer','total_amount','offer','admin','anual_payment'));
    }

    public function superadminHome()
    {
        $active_gymer =User::Where('role','5')->Where('status',1)->count();
        $inactive_gymer =User::Where('role','5')->Where('status',0)->count();
        $admin = User::Where('role','2')->count();
        $trainer = User::Where('role','4')->count();
        $total_amount = Payment::sum('amount');
        $offer = Package::count();
        $shift = Shift::count();
        return view('superadminbackend.superadminhome',compact(['active_gymer','inactive_gymer','trainer','total_amount','offer','admin','shift']));
    }
   
}
