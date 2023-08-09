<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\User;

use App\Models\Shift;
use App\Models\Advance;
use App\Models\Userdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Gdiscount;
use App\Models\Payment;
use App\Models\User_hasgroup;
use App\Models\User_hasoffer;
use App\Models\User_haspaymenttype;

class PdfController extends Controller
{
    public function index(){
        $shifts = Shift::get();
        $payments_alert = Advance::with('getUserdetail')->join('users','users.id','=','advances.user_id')
                ->where('users.status' ,1)
                ->where('advances.initial_advance','<' , 0)
            ->get();

    $count_alert = Advance::with('getUserdetail')->join('users','users.id','=','advances.user_id')
            ->where('users.status' ,1)
            ->where('advances.initial_advance','<' , 0)
            ->count();
        return view('backend.pdf.index',
                compact('payments_alert',
                'count_alert','shifts'));
    }

    public function gymerdues(Request $request){

        $shifts= Shift::where('id',$request->shift)->first();
     
       
         $date = Carbon::now()->format('Y-M-d');
        $dues = Advance::with('getUser','getUserdetail')
                ->where('initial_Advance' ,'<' , 0)
                ->where('shift_id',$request->shift)->get(); 
       
        
        $pdf = PDF::LoadView('backend.pdf.gymerdues',compact('shifts','dues','date'));
             return $pdf->stream(); 
       
    }

    public function print_profile(Request $request ,$id)
    {
            $date =Carbon::now()->format('Y-M-d');
            $datas = Userdetail::with('users','shifts')->where('user_id',$request->id)->first();
            $total_amount = Payment::where('user_id',$request->id)->sum('amount');
            $total = round($total_amount);
            $offers = User_hasoffer::with('offer')->where('user_id',$request->id)
                        ->Where('status',1)->first();
            $payment_types = User_haspaymenttype::with('anual_payment')->where('user_id',$request->id)->first();
            $discount_groups = User_hasgroup::where('user_id',$request->id)->count();
            $group_percent = Gdiscount::where('no_gymer',$discount_groups)->value('discount');
            // dd($group_percent);

            $pdf = PDF::LoadView('backend.pdf.printprofile',compact('datas','total','offers',
            'payment_types','discount_groups','date','group_percent'));
            return $pdf->download('abc.pdf'); 
            // return view('backend.pdf.printprofile',compact('datas','total','offers',
            // 'payment_types','discount_groups','date'));
    }

    public function show(Request $request)
    {
                $columns = array(
                    0 => 'id', 
                    1 => 'name',
                    2 => 'phone',
                    3 => 'address',
                    4 => 'role',
                    5 => 'crated_at',
                    6=>  'action',
                );

        $totalData = User::where('role','5')->count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {       
        $posts = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                            ->join('roles', 'roles.id', '=', 'userdetails.role_id') 
                            ->where('userdetails.role_id','5')     
                            ->where('users.status','1')        
                            ->orderBy('users.updated_at', 'desc')
                            ->offset($start);
        }
        else 
        {
        $search = $request->input('search.value'); 
        $posts = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                            ->join('roles', 'roles.id', '=', 'userdetails.role_id') 
                            ->where('userdetails.role_id','5')
                            ->where('users.status','1')     
                            ->where('users.name', 'LIKE', '%'. $search.'%') 
                            ->orWhere('userdetails.address', 'LIKE', '%'. $search.'%')     
                            ->orWhere('userdetails.phone', 'LIKE', '%'. $search.'%')   
                            ->orderBy('users.updated_at', 'desc')
                            ->offset($start);

        $totalFiltered = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                            ->join('roles', 'roles.id', '=', 'userdetails.role_id') 
                            ->where('userdetails.role_id','5')
                            ->where('users.status','1')   
                            ->where('users.name', 'LIKE', '%'. $search.'%') 
                            ->orWhere('userdetails.address', 'LIKE', '%'. $search.'%')     
                            ->orWhere('userdetails.phone', 'LIKE', '%'. $search.'%')   
                            ->orderBy('users.updated_at', 'desc');
                            
        $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
                    ->orderBy($order,$dir)
                    ->get(['users.id','users.created_at','user_id','name','role_id','role_name','phone','address','users.slug as slug']);


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
            $nestedData['phone'] = $post->phone;
            $nestedData['address'] = $post->address;
            $nestedData['role'] = $post->role_name;
            $nestedData['created_at'] =  $days_count <= 30 ? $post->created_at->diffForHumans() : $post->created_at->format('F j, Y').'<br>'.$post->created_at->format('g:i a');
            $nestedData['action'] = '
            <div class="text-center">                       
            <a href="'.route('admin.print.profile',$post->id).'" class="btn btn-xs btn-outline-primary"><i class="fa fa-print"data-toggle="tooltip" data-placement="top" title=" Print Profile"></i></a>

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

  
}
