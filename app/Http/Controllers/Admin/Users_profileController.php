<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Advance;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Gdiscount;
use App\Models\Userdetail;
use App\Models\AnualPayment;
use Illuminate\Http\Request;
use App\Models\User_hasgroup;
use App\Models\User_hasoffer;
use Illuminate\Support\Carbon;
use App\Models\User_haspaymenttype;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class Users_profileController extends Controller
{
    public function index()
    {

    }

    public function create(Request $request)
    {


    }

    public function show(Request $request)
    {

        $columns = array(
                        0 => 'id',
                        1 => 'name',
                        2 => 'amount',
                        3 => 'force_discount',
                        4 => 'total',
                        5 => 'paid_date',
                        6=>  'action',
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
                    ->orderBy('payments.created_at', 'desc')
                    ->get(['payments.slug as slug','payments.date','users.name','payments.amount','payments.force_discount','payments.created_at as created_at',
                        'payments.created_at as created_at','payments.total']) ;

        }
        else
        {
            $search = $request->input('search.value');
            $posts = Payment::join('users','users.id' ,'=' ,'payments.user_id')
                    ->where('users.name', 'LIKE', '%'.$search.'%')
                    ->orderBy('payments.created_at', 'desc')
                    ->get(['payments.slug as slug','payments.date','users.name','payments.amount','payments.force_discount','payments.created_at as created_at','payments.total']);

            $totalFiltered = $totalFiltered;
        }

        $posts = $posts;

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
                $nestedData['amount'] = $post->amount;
                $nestedData['force_discount'] = $post->force_discount;
                $nestedData['total'] = $post->total;
                $nestedData['paid_date'] = $post->date;
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

        $demo = User_haspaymenttype::where('user_id',$request->user)->where('is_active',1)->value('user_id');
        $data =  User_hasoffer::where('user_id',$request->user)
                ->Where('status',1)->value('user_id');
        $validate = User_hasgroup::Where('user_group',$request->user_group)->Where('user_id',$request->user_group)->exists();
        $users = $request->demos;
        $usergroups = $request->demos;
        $usergroups[] = $request->user_group;

        if($data != $request->user && $demo != $request->user )
        {
            if($validate == false)
            {

                foreach($usergroups as $usergroup)
                {
                    User_hasgroup::create([
                        'user_id' => $request->user_group,
                        'user_group'=> $usergroup,
                        'slug' =>rand(1,9999),
                    ]);
                }
            }

            foreach($users as $user)
            {
                foreach($usergroups as $usergroup)
                {
                     User_hasgroup::create([
                        'user_id' => $user,
                        'user_group' => $usergroup,
                        'slug' => rand(1,9999)
                     ]);

                }
            }
        }
        else
        {

            return redirect()->back()->with('info', 'Cannot Assign Any Gymer To This Group');
        }

        return redirect()->back()->with('success', 'Gymer added into Group');
    }


    public function edit(Request $request,$users_profile)
    {

        $datas = Userdetail::join('users','users.id','=','userdetails.user_id')
        ->where('users.slug',$users_profile)->get();


        $selected_offer = User_hasoffer::join('users','users.id','=','user_hasoffers.user_id')
                        ->where('user_hasoffers.status',1)
                        ->where('users.slug',$users_profile)
                        ->get('user_hasoffers.user_id');

        $selected_group = User_hasgroup::join('users','users.id','=','user_hasgroups.user_id')
                        ->where('users.slug',$users_profile)
                        ->get('user_hasgroups.user_group');


            $users = Userdetail::join('users','users.id','=','userdetails.user_id')
                    ->join('shifts','shifts.id','=','userdetails.shift_id')
                    ->where('role',5)
                    ->WhereNotIn('users.id',$selected_offer)
                    ->where('status',1)
                    ->WhereNotIn('users.id',$selected_group)
                    ->Where('users.slug', '!=',$users_profile)
                    ->get();

            $user_group = Userdetail::join('users','users.id','=','userdetails.user_id')
                    ->join('shifts','shifts.id','=','userdetails.shift_id')
                    ->Where('users.slug', '=',$users_profile)
                    ->value('users.id');


        $user_hasgroup =User_hasgroup::join('users','users.id','=','user_hasgroups.user_id')
                ->with(['user_hasgroup','user_contact'])
                ->where('users.slug',$users_profile)
                ->get(['user_hasgroups.slug as slug','user_hasgroups.user_group','user_hasgroups.id']);

        $count = User_hasgroup::join('users','users.id','=','user_hasgroups.user_id')
                    ->where('users.slug',$users_profile)->count();

        $fee = Userdetail::join('users','users.id','=','userdetails.user_id')
                    ->where('users.slug',$users_profile)->value('fee');
        $offer_discount = User_hasoffer::join('packages','packages.id','=','user_hasoffers.offer_id')
                ->join('users','users.id','=','user_hasoffers.user_id')
                ->where('users.slug',$users_profile)
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

        $offers = Package::Where('status',1)->get();
        $user_hasoffer = User_hasoffer::join('users','users.id','=','user_hasoffers.user_id')
            ->with(['offer'])
            ->where('users.slug',$users_profile)
            ->Where('user_hasoffers.status',1)
            ->get(['user_hasoffers.slug as slug','user_hasoffers.offer_id','user_hasoffers.created_at']);

        $payment_types = AnualPayment::all();

        $user_haspaymenttype = User_haspaymenttype::join('users','users.id','=','user_haspaymenttypes.user_id')
            ->with(['anual_payment'])
            ->where('users.slug',$users_profile)
            ->Where('user_haspaymenttypes.is_active',1)
            ->get(['user_haspaymenttypes.slug as slug','user_haspaymenttypes.paymenttype_id','user_haspaymenttypes.start_date','user_haspaymenttypes.end_date']);

        $payments_alert = Advance::with('getUserdetail')->join('users','users.id','=','advances.user_id')
                            ->where('users.status' ,1)
                            ->where('advances.initial_advance','<' , 0)
                            ->get();

        $count_alert = Advance::with('getUserdetail')->join('users','users.id','=','advances.user_id')
                            ->where('users.status' ,1)
                            ->where('advances.initial_advance','<' , 0)
                            ->count();
        return view('backend.users-profile.create-edit',compact(['datas','users','user_group','user_hasgroup','total_fee',
                    'fee','discount','add_discount','offers','user_hasoffer',
                    'payment_types','user_haspaymenttype','payments_alert','count_alert']));
    }

    public function update(Request $request)
    {

    }

    public function destroy(Request $request,$slug)
    {

        $data = User_hasgroup::where('slug', $slug);
        $data -> delete();
        return redirect()->back()->with('danger', 'Gymer Successfully Deleted From Group');
    }

}
