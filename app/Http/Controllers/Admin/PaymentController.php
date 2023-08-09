<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Advance;
use App\Models\Payment;
use App\Models\Gdiscount;
use App\Models\Userdetail;
use Illuminate\Http\Request;
use App\Models\User_hasgroup;
use App\Models\User_hasoffer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User_haspaymenttype;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Backupadvancetable;


class PaymentController extends Controller
{

    public function index()
    {

        $payments_alert = Advance::with('getUserdetail')->join('users','users.id','=','advances.user_id')
                                ->where('users.status' ,1)
                                ->where('advances.initial_advance','<' , 0)
                                 ->get();

        $count_alert = Advance::with('getUserdetail')->join('users','users.id','=','advances.user_id')
                            ->where('users.status' ,1)
                            ->where('advances.initial_advance','<' , 0)
                            ->count();
        return view('backend.payment.index',compact('payments_alert','count_alert'));
    }

    public function create(Request $request)
    {

    }

    public function show(Request $request)
    {

        $columns = array(
                        0 => 'id',
                        1 => 'name',
                        2 => 'total_amount',
                        3 => 'amount',
                        4 => 'months',
                        5 =>'dues',
                        6 =>'advance',
                        7 => 'paid_date',
                        8=>  'action',
                    );

        $totalData = Payment::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {
            $posts = Payment::join('users','users.id' ,'=' ,'payments.user_id')
                    ->Where('users.status',1)
                    ->orderBy('payments.created_at', 'desc')
                    ->offset($start);

        }
        else
        {
            $search = $request->input('search.value');
            $posts = Payment::join('users','users.id' ,'=' ,'payments.user_id')
                    ->where('users.name', 'LIKE', '%'.$search.'%')
                    ->Where('users.status',1)
                    ->orderBy('payments.created_at', 'desc')
                    ->offset($start);

            $totalFiltered = Payment::join('users','users.id' ,'=' ,'payments.user_id')
                    ->where('users.name', 'LIKE', '%'.$search.'%')
                    ->Where('users.status',1)
                    ->orderBy('payments.created_at', 'desc');


            $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
                        ->get(['payments.slug as slug','payments.date','users.name','payments.amount','payments.created_at as created_at',
                              'payments.total_amount','payments.monthly_amount','payments.dues','payments.advance']);

        $data = array();

        if(!empty($posts))
        {
            foreach ($posts as $key=>$post)
            {
                $start = Carbon::parse($post->created_at);
                $now = Carbon::now();
                $days_count = $start->diffInDays($now);
                $nestedData['id'] = $key+1;
                $nestedData['name'] = $post->name;
                $nestedData['total_amount'] = "Rs"." ".$post->total_amount;
                $nestedData['amount'] = "Rs"." ".$post->amount;
                $nestedData['months'] = "Rs"." ".$post->monthly_amount;
                $nestedData['dues'] = "Rs"." ".abs($post->dues);
                $nestedData['advance'] = "Rs"." ".$post->advance;
                $nestedData['paid_date'] = date('Y-M-d', strtotime($post->date));
                $nestedData['action'] = '
                <div class="text-center">
                <button type="button" class="btn btn-xs btn-outline-info modalbtn" data-toggle="modal" data-target="#payment" data-type="edit" data-toggle="tooltip" data-placement="top" title="Edit Payment " data-url="'.route('admin.paymentedit.edit',$post->slug).'">
                <i class="fas fa-hand-holding-usd"></i>
                </button>

                </div>
                ';

                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),  // intval($request->input('draw'))
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );
        echo json_encode($json_data);
    }

    public function store(Request $request)
    {

        foreach ($request->datastring as $key => $datainput) {
            $request[$datainput['name']] = $datainput['value'];
        }

        $validator = Validator::make($request->all(), [
            'users' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails() || $request->amount == 0) {
            $noties = array(
                'message' => 'Please Fill up the Amount First.',
                'atype' => 'error',
                'aicon' => 'error'
            );
            return Response::json($noties);
        }

        DB::beginTransaction();
        try {
            $count = User_hasgroup::join('users','users.id','=','user_hasgroups.user_id')
            ->where('user_id',$request->users)->count();

            $fee = Userdetail::join('users','users.id','=','userdetails.user_id')
            ->where('user_id',$request->users)->value('fee');


            $offer_discount = User_hasoffer::join('users','users.id','=','user_hasoffers.user_id')
            ->join('packages','packages.id','=','user_hasoffers.offer_id')
            ->where('users.id',$request->users)
            ->where('user_hasoffers.status',1)
            ->value('packages.discount');



            if($count >= 4){
                $discount = Gdiscount::where('no_gymer',4)
                ->value('discount');

            }
            else if ($count < 4){
                $discount = Gdiscount::where('no_gymer',$count)
                       ->value('discount');
            }

            $d_offer = ($fee / 100) * $offer_discount;
            $d_group = ($fee / 100) * $discount;
            $total_discount = $d_offer + $d_group;


            $total_fee = $fee - $total_discount;


            $check_old_advance = Advance::where('user_id',$request->users)
                                        ->orderBy('id', 'DESC')
                                        ->value('initial_advance');

          $total = $request->amount;
          $month = date('m', strtotime( $request->date)) ;
          $year = date('Y', strtotime( $request->date)) ;


            $check_sum= Payment:: whereMonth('date', $month)
                            ->whereYear('date', $year)
                            ->where('user_id',$request->users)
                            ->sum('amount');

            $check_month = Payment:: whereMonth('date', $month)
                        ->whereYear('date', $year)
                        ->where('user_id',$request->users)
                        ->get();
                      
            if($check_old_advance < 0 )
            {
                if(count($check_month) != 0)
               {
                    $request['advance'] = $request->amount + ($check_old_advance) ;
                    if ($request['advance'] < 0)
                    {
                        $request['amount'] = $request->amount;
                        $dues =    $request['advance'];
                        $monthly_amount =  $request->amount;


                    }
                    else if ($request['advance'] > 0)
                    {
                        $request['amount'] = $request->amount;
                        $monthly_amount = $request['advance'];
                        $advance = $request['advance'];

                    }

                    else
                    {
                        $request['amount'] = $request->amount;

                    }
               }
               else
               {

                    $request['advance'] = $request->amount + ($check_old_advance) ;

                    if ($request['advance'] < 0)
                    {

                        $dues = $request['advance'];
                        $request['amount'] =$request->amount;


                    }
                    else if ($request['advance'] > 0)
                    {

                        $request['amount'] = $request->amount;
                        $monthly_amount = $total_fee;
                        $advance = $request['advance'];

                    }

                    else
                    {

                        $request['amount'] = $request->amount;
                        $monthly_amount =$request->amount;

                    }
                }
            }

            else if($check_old_advance == 0 )
            {

               if($check_sum >= $total_fee)
               {

                $request['amount'] = $request['amount'];
                $advance = $request['amount'];
                $request['advance'] = $advance;

               }
               else
               {

                    $request['advance'] =  $request->amount + ($check_old_advance) - $total_fee;

                    if ($request['advance'] > 0 )
                    {

                    $request['amount'] = $total_fee + $request['advance'];
                    $advance = $request['advance'];
                    $monthly_amount = $total_fee;
                    }
                    else if ($request['advance'] < 0)
                    {
                        $request['amount'] =$request->amount;
                        $dues = $request['advance'];

                    }
                    else
                    {

                        $request['amount'] =$request->amount;
                        $monthly_amount = $request['amount'];

                    }
                }
            }
            else
            //Check old avacnce >= 0

            {

                if(count($check_month) != 0)
               {

                $request['amount'] = $request['amount'];
                $advance = $request['amount'];
                $request['advance'] = $advance + $check_old_advance;

               }
               else
               {

                    $request['advance'] = ($request->amount) - $total_fee;
                //  dd($request['advance']);
                    if ($request['advance'] > 0)
                    {
                    $advance = $request['advance'];
                    $request['amount'] = $total_fee + $request['advance'];
                    $request['advance'] =$check_old_advance + $request['advance'] ;
                    $monthly_amount =$total_fee ;


                    }
                    else if ($request['advance'] < 0)
                    {
                    $request['advance'] = $check_old_advance + ($request['advance']);
                    $request['amount'] = $check_old_advance + $request->amount;
                    $dues = $check_old_advance + ($request['advance']);
                    $monthly_amount = $check_old_advance - $total_fee;

                    }
                    else if ($request['advance'] == 0)
                    {

                        $request['advance'] = $check_old_advance ;
                        $request['amount'] = $request->amount;
                        $advance = $check_old_advance;
                        $monthly_amount = $request->amount;

                    }
                }
            }

            $payment = Payment::updateOrCreate(
                                    [
                                        'id' => $request->data_id
                                    ],
                                    [
                                        'user_id' =>$request->users,
                                        'total_amount' => $total,
                                        'monthly_amount'=> $monthly_amount ?? 0,
                                        'dues'=> $dues ?? 0,
                                        'advance'=> $advance ?? 0,
                                        'amount' => $request->amount,
                                        'date' => $request->date,
                                        'slug' => rand(1,99999999),
                                    ]);
            Backupadvancetable::create(
                                    [
                                        'user_id' =>$request->users,
                                        'payment_id'=>$payment->id,
                                        'backup_advance'=>$request->backup_advance,
                                        'slug'=>rand(1,9999),
                                ]
                            );
            Advance::updateOrCreate(
                                    [
                                        'user_id' =>$request->users
                                    ],
                                    [
                                        'user_id' =>$request->users,
                                        'initial_advance' => $request->advance ?? '0',
                                        'slug' => rand(1,99999),
                                    ]);
            DB::commit();
            $noties = array(
                    'message' => 'Payment Added  Successfully!',
                    'atype' => 'success',
                    'aicon' => 'success'
                    );

        }
        catch (\Exception $e) {
            DB::rollback();
            $noties = array(
                    'message' => 'Your data could not store.',
                    'atype' => 'error',
                    'aicon' => 'error'
                );
        }
        return Response::json($noties);
    }


    public function edit(Request $request)
    {
        $count = User_hasgroup::join('users','users.id','=','user_hasgroups.user_id')
        ->where('users.slug',$request->payment)->count();

        $fee = Userdetail::join('users','users.id','=','userdetails.user_id')
                    ->where('users.slug',$request->payment)->value('fee');

        $offer_discount = User_hasoffer::join('packages','packages.id','=','user_hasoffers.offer_id')
        ->join('users','users.id','=','user_hasoffers.user_id')
        ->where('users.slug',$request->payment)
        ->Where('user_hasoffers.status',1)
        ->value('discount');

        if($count >= 4){
            $discount = Gdiscount::where('no_gymer',4)
            ->value('discount');

        }
        else if ($count < 4){
            $discount = Gdiscount::where('no_gymer',$count)
                    ->value('discount');
        }

        $add_discount =$discount + $offer_discount;
        $d_offer = ($fee / 100) * $offer_discount;
        $d_group = ($fee / 100) * $discount;

        $total_discount = $d_offer + $d_group;
        $total_fee = $fee - $total_discount;
        $user_info = User::where('slug', $request->payment)
                        ->with(['getUserDetail' => function ($query) {
                            $query->select('id',
                                'user_id',
                                'fee',
                                'discount',
                                'phone',
                                'image',
                            );
                        }])
                        ->select([
                            'id',
                            'slug',
                            'name',
                        ])
                        ->first();
        $payment_info = Payment::where('user_id', $user_info->id)
                            ->whereMonth('created_at', date('m'))
                            ->orderBy('id', 'DESC');

        $debit = $payment_info->sum('amount');
        $data_list = $payment_info->first();

        $data = Advance::where('user_id', $user_info->id)
                            ->orderBy('id', 'DESC')
                            ->value('initial_advance');

        if($data<0){
                $credit=$data;
        }
        else{
            $credit='0';
        }

        if($data>0){
                $remain=$data;
        }
        else{
            $remain='0';
        }

        $user_haspaymenttype =  User_haspaymenttype::join('users','users.id','=','user_haspaymenttypes.user_id')
        ->with(['anual_payment'])
        ->where('users.slug',$request->payment)
        ->Where('is_active',1)->get();

        $monthly_fee =  Userdetail::join('users','users.id','=','userdetails.user_id')
        ->where('users.slug',$request->payment)->value('userdetails.fee');

         $check_last_paid_month = Payment::join('users','users.id','=',   'payments.user_id')
                 ->where('users.slug',$request->payment)
                 ->exists();
       
         return view('backend.payment.create-edit',compact('data_list','user_info','credit','remain','debit','total_fee','user_haspaymenttype','monthly_fee','check_last_paid_month','data'));
    }

    public function update(Request $request)
    {

    }


    public function destroy(Request $request)
    {

        $data_destroy = Payment::find($request->payment);
        $data_destroy->delete();
        $notices = array(
            'aicon' => 'success',
            'atype' => 'info',
            'atitle' => 'Deleted Successfully!!',
            'message' => $data_destroy['getUser']->name.', Payment Record has been removed.'
        );

        return Response::json($notices);
    }


}
