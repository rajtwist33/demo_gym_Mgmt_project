<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Advance;
use App\Models\Payment;
use App\Models\AnualPayment;
use Illuminate\Http\Request;
use App\Models\User_hasgroup;
use App\Models\User_hasoffer;
use App\Models\User_haspaymenttype;
use App\Http\Controllers\Controller;

class AnualpaymenttypeController extends Controller
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
        return view('backend.anual_payment.index',compact('payments_alert','count_alert'));
    }


    public function create()
    {
        //
    }

    public function show(Request $request)
    {
        $columns = array(
                        0 => 'id',
                        1 => 'name',
                        2 => 'set_amount',
                        3 =>'discount',
                        4 => 'no_month',
                        5 => 'discount',
                        6 => 'total_amount',
                        7 => 'monthly_amount',
                        8=>'created_at'
                    );

        $totalData = AnualPayment::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {
            $posts = AnualPayment::offset($start);
        }
        else
        {
            $search = $request->input('search.value');
            $posts = AnualPayment::where('payment_name', 'LIKE', '%'.$search.'%')
                            ->offset($start);

            $totalFiltered = AnualPayment::where('payment_name', 'LIKE', '%'.$search.'%');

            $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
                       ->orderBy($order,$dir)
                       ->get();

        $data = array();

        if(!empty($posts))
        {
            foreach ($posts as $key=>$post)
            {
                $start = Carbon::parse($post->created_at);
                $now = Carbon::now();
                $days_count = $start->diffInDays($now);
                $nestedData['id'] = $key+1;
                $nestedData['name'] = $post->payment_name;
                $nestedData['set_amount'] = 'Rs'.' '.$post->set_amount;
                $nestedData['no_month'] = $post->no_month.' '.'months';
                $nestedData['discount'] = $post->discount."%";
                $nestedData['total_amount'] = 'Rs'.' '.$post->total_amount;
                $nestedData['monthly_amount'] ='Rs'.' '. $post->monthly_amount;
                $nestedData['created_at'] = $days_count <= 30 ? $post->created_at->diffForHumans() : $post->created_at->format('F j, Y').'<br>'.$post->created_at->format('g:i a');
                $nestedData['action'] = '
                <div class="text-center">
                <button type="button" class="btn btn-xs btn-outline-info modalbtn" data-toggle="modal" data-target="#myModal" data-type="edit" data-url="'.route('superadmin.annual_payment.edit',$post->slug).'">
                  <i class="fa fa-edit"></i>
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

        $fetch = AnualPayment::where('id',$request->payment_type)->value('no_month');
        $date = Carbon::now();
        $add_date= Carbon::now()->addMonth($fetch);
        $data =  User_hasgroup::where('user_id',$request->user)->value('user_id');
        $demo = User_hasoffer::where('user_id',$request->user)
                ->Where('status',1)->value('user_id');
        $check_paymenttype=User_haspaymenttype::where('user_id',$request->user)
                            ->Where('is_active',1)->value('user_id');
        if($data != $request->user && $demo != $request->user && $check_paymenttype != $request->user ){

            User_haspaymenttype::create([
                'user_id'=>$request->user,
                'paymenttype_id'=>$request->payment_type,
                'start_date'=>$date,
                'end_date'=>$add_date,
                'slug' => rand(1,99999999),
            ]);

         }

         else{
            return redirect()->back()->with('info','Cannot Assign Payment To This Gymer');

           }

        $check = User_haspaymenttype::where('user_id',$request->user)->Where('is_active',1)->value('user_id');
        $initaial_advance=Advance::where('user_id',$request->user)->value('initial_advance');

        $date = Payment::where('user_id',$request->user)->value('date');
        $today_date = date('Y-m-d');

        if($date == $today_date){

            if($check == $request->user)
            {

                $anual_data = User_haspaymenttype::join('users','users.id','=','user_haspaymenttypes.user_id')
                ->join('anual_payments','anual_payments.id','=','user_haspaymenttypes.paymenttype_id')
                ->where('user_haspaymenttypes.user_id',$request->user)
                ->where('user_haspaymenttypes.is_active',1)
                ->get(['anual_payments.total_amount as total']);

                Payment::where('user_id',$request->user)->update([
                    'user_id' => $check,
                    'total_amount' =>  $anual_data[0]->total,
                    'amount' =>  $anual_data[0]->total,
                    'monthly_amount' => 0,
                    'dues' => 0,
                    'advance' => 0,
                    'date'=> Carbon::now()->format('Y-m-d'),

                ]);

            }
        }
        else
        {
            if($check == $request->user)
            {

                $anual_data = User_haspaymenttype::join('users','users.id','=','user_haspaymenttypes.user_id')
                ->join('anual_payments','anual_payments.id','=','user_haspaymenttypes.paymenttype_id')
                ->where('user_haspaymenttypes.user_id',$request->user)
                ->where('user_haspaymenttypes.is_active',1)
                ->get(['anual_payments.total_amount as total']);

                Payment::create([
                    'user_id' => $check,
                    'total_amount' =>  $anual_data[0]->total,
                    'amount' =>  $anual_data[0]->total,
                    'monthly_amount' => 0,
                    'dues' => 0,
                    'advance' => 0,
                    'date'=> Carbon::now()->format('Y-m-d'),

                ]);

            }
    }
       return redirect()->back()->with('success', 'New Payment Type Added');
    }


    public function edit($id)
    {
        //
    }


public function update(Request $request, $id)
    {
        //
    }


    public function destroy(Request $request,$slug)
    {

        User_haspaymenttype::where('slug', $slug)->update(
            ['is_active'=>0,]
        );

        return redirect()->back()->with('danger', 'Payment Type has Successfully Removed');
    }
}
