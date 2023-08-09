<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Advance;
use App\Models\Payment;
use App\Models\Userdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Backupadvancetable;
use App\Models\User_haspaymenttype;
use App\Http\Controllers\Controller;

class Paymenthistory extends Controller
{

    public function index()
    {
    }


    public function create()
    {
    }


    public function store(Request $request)
    {

        $old_advance  = Advance::where('user_id', $request->user_id)->value('initial_advance');

        Payment::where('id', $request->data_id)->update(
            [
                'date' => $request->date,
                'amount' => $request->amount,
                'total_amount' => $request->amount,
                'advance' => $request->advance,
                'dues' => $request->dues,
            ]
        );
        if ($request->advance != 0) {
            Advance::where('user_id', $request->user_id)->update([
                'initial_advance' => $request->advance,
            ]);
        } else if ($request->dues != 0) {
            Advance::where('user_id', $request->user_id)->update([
                'initial_advance' => $request->dues,
            ]);
        } else if ($request->advance == 0 && $request->dues == 0) {
            Advance::where('user_id', $request->user_id)->update([
                'initial_advance' => $old_advance,
            ]);
        }
        toast('success', 'Payment Update Sucess');
        return redirect()->route('admin.gymer.index');
    }


    public function show(Request $request, $payment_history)
    {


        $payments_alert = Advance::with('getUserdetail')->join('users', 'users.id', '=', 'advances.user_id')
            ->where('users.status', 1)
            ->where('advances.initial_advance', '<', 0)
            ->get();

        $count_alert = Advance::with('getUserdetail')->join('users', 'users.id', '=', 'advances.user_id')
            ->where('users.status', 1)
            ->where('advances.initial_advance', '<', 0)
            ->count();
        $payments = Payment::where('user_id', $payment_history)->where('previous_amount',0)->latest()->get();
        $total_amount = Payment::where('user_id', $payment_history)->sum('amount');
        $details = Userdetail::with('users', 'shifts')->where('user_id', $payment_history)->get();
        $payment_type = User_haspaymenttype::With('anual_payment')->Where('user_id', $payment_history)->get();
        $user_id = Userdetail::where('user_id', $payment_history)->first();
        $data = Advance::where('user_id', $payment_history)
            ->orderBy('id', 'DESC')
            ->value('initial_advance');
        $count_currenttransaction = Payment::where('user_id', $payment_history)->where('previous_amount', 0)->count();


        $old_amount = Payment::where('user_id', $payment_history)->Where('previous_amount',1)->first();

        return view('backend.payment.history', compact('total_amount', 'details', 'payments', 'payments_alert', 'count_alert', 'payment_type', 'user_id', 'data', 'old_amount', 'count_currenttransaction'));
    }


    public function edit(Request $request, $payment_history)
    {

        $payments_alert = Advance::with('getUserdetail')->join('users', 'users.id', '=', 'advances.user_id')
            ->where('users.status', 1)
            ->where('advances.initial_advance', '<', 0)
            ->get();

        $count_alert = Advance::with('getUserdetail')->join('users', 'users.id', '=', 'advances.user_id')
            ->where('users.status', 1)
            ->where('advances.initial_advance', '<', 0)
            ->count();

        $edit_payment = Payment::where('id', $payment_history)->first();
        $check_advance = Advance::Where('user_id', $edit_payment->user_id)->value('initial_advance');

        $backup_advance = Backupadvancetable::Where('payment_id', $payment_history)->value('backup_advance');

        Advance::Where('user_id', $edit_payment->user_id)->update([
            'initial_advance' => $backup_advance,
        ]);
        $edit_payment = Payment::where('id', $payment_history)->delete();
        toast('Payment Undo Success', 'success');
        return redirect()->back();
    }


    public function update(Request $request, $payment_history)
    {
    }


    public function destroy($id)
    {
    }

    public function addoldpayment(Request $request)
    {
        $payment = Payment::updateOrcreate(
            [
                'id' =>$request->data_id,
            ],
            [
                'user_id' => $request->user_id,
                'date' => Carbon::now(),
                'amount' => $request->amount,
                'total_amount' => $request->amount,
                'advance' => $request->advance ?? 0,
                'dues' => $request->dues ?? 0,
                'description' => $request->description ?? null,
                'previous_amount'=>1,
            ]
        );

        if($request->dues === null && $request->advance === null)
        {
            Backupadvancetable::create(
                [
                    'user_id' => $request->user_id,
                    'payment_id' => $payment->id,
                    'backup_advance' => $request->backup_advance,
                    'slug' => rand(1, 9999),
                ]
            );
        }

        if($request->dues > 0)
        {

            Backupadvancetable::create(
                [
                    'user_id' => $request->user_id,
                    'payment_id' => $payment->id,
                    'backup_advance' => $request->backup_advance,
                    'slug' => rand(1, 9999),
                ]
            );
            Advance::where('user_id', $request->user_id)->update([
                'initial_advance' => -($request->dues),
            ]);
        }

        if ($request->advance > 0)
        {
            Backupadvancetable::create(
                [
                    'user_id' => $request->user_id,
                    'payment_id' => $payment->id,
                    'backup_advance' => $request->backup_advance,
                    'slug' => rand(1, 9999),
                ]
            );
            Advance::where('user_id', $request->user_id)->update([
                'initial_advance' => $request->advance,
            ]);
        }

        toast('Previous Amount Added Successfully','success');
        return redirect()->back();
    }
}
