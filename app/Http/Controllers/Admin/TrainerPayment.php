<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainerspayment;
use App\Models\Trainer_shift;
use App\Models\Userdetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use App\Models\Advance;




use Illuminate\Http\Request;


class TrainerPayment extends Controller
{

    public function index(Request $request)
    {
    }


    public function create(Request $request)
    {
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Trainerspayment::create([
                'user_id' => $request->data_id,
                'no_shift' => $request->no_shift,
                'present' => $request->presentday,
                'amount' => $request->amount,
                'month' => $request->month,
                'rate' => $request->rate,
                'advance' => $request->advance,
                'net_amount' => $request->net_amount,
                'description' => $request->description,
                'slug' => rand(1, 9999),
            ]);
            DB::commit();
            $noties = array(
                'message' => 'Trainer Payment Added Successfully!',
                'atype' => 'success',
                'aicon' => 'success'
            );
        } catch (\Exception $e) {
            DB::rollback();
            $noties = array(
                'message' => 'Your data could not store.',
                'atype' => 'error',
                'aicon' => 'error'
            );
        }
        return Response::json($noties);
    }


    public function show($trainerpayment, Request $request)
    {

        $payments_alert = Advance::with('getUserdetail')->join('users', 'users.id', '=', 'advances.user_id')
            ->where('users.status', 1)
            ->where('advances.initial_advance', '<', 0)
            ->get();

        $count_alert = Advance::with('getUserdetail')->join('users', 'users.id', '=', 'advances.user_id')
            ->where('users.status', 1)
            ->where('advances.initial_advance', '<', 0)
            ->count();
        $datas = Trainerspayment::with('users')->Where('user_id', $trainerpayment)->Where('previous_amount',0)->latest()->paginate(5);

        $old_amount = Trainerspayment::Where('user_id', $trainerpayment)->Where('previous_amount',1)->first();

        $demo = Userdetail::with('users', 'shifts')->Where('user_id', $trainerpayment)->first();
        $trainershifts = Trainer_shift::with('shifts')->Where('user_id', $trainerpayment)->get();
        $user_id = $trainerpayment;

        $total_amount = Trainerspayment::Where('user_id', $trainerpayment)->sum('net_amount');

        $count_payment = Trainerspayment::with('users')->Where('user_id', $trainerpayment)->Where('previous_amount', 0)->count();

        return view('backend.trainer.paymentlist', compact('payments_alert', 'count_alert', 'datas', 'demo', 'trainershifts', 'user_id', 'old_amount', 'total_amount', 'count_payment'));
    }


    public function edit($trainerpayment, Request $request)
    {

        $data_list = User::where('id', $trainerpayment)->with('getUserDetail')->first();
        $trainershifts = Trainer_shift::with('shifts')->Where('user_id', $trainerpayment)->get();
        return view('backend.trainer.trainerpayment', compact('data_list', 'trainershifts'));
    }


    public function update(Request $request, $trainerpayment)
    {
    }

    public function addtraineroldamount(Request $request)
    {
        Trainerspayment::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'net_amount' => $request->amount,
            'description' => $request->description,
            'previous_amount'=> 1,
            'slug' => rand(1, 9999),
        ]);
        toast('Previous Trainer Amout Added', 'success');
        return redirect()->back();
    }
    public function destroy($trainerpayment, Request $request)
    {

        Trainerspayment::Where('id', $trainerpayment)->delete();
        toast(' Payment History successfully Deleted', 'success');
        return redirect()->back();
    }
}
