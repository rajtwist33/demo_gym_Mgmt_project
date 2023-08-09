<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymenteditController extends Controller
{
 
    public function index(Request $request)
    {
        //
    }

    
    public function create(Request $request)
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show(Request $request)
    {
      
         
    }

    public function edit(Request $request)
    {
        $user_info = Payment::join('userdetails','payments.user_id','=','userdetails.user_id')
        ->join('users','users.id','payments.user_id')
        ->where('payments.slug',$request->paymentedit)
        ->select(['users.name','payments.user_id as user_id','payments.id as id','userdetails.image as image','payments.amount as amount','payments.total as total','payments.force_discount as force_discount','payments.date as date'])
        ->first();
        return view('backend.payment.edit-payment',compact(['user_info']));
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        //
    }
}
