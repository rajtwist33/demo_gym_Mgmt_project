<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\User;
use App\Models\Payment;
use App\Models\Userdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class InactivegymerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('superadminbackend.inactive_gymer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
                                ->where('users.status','0')        
                                ->orderBy('users.updated_at', 'desc')
                                ->offset($start);
        }
        else 
        {
            $search = $request->input('search.value'); 
            $posts = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                                ->join('roles', 'roles.id', '=', 'userdetails.role_id') 
                                ->where('userdetails.role_id','5')
                                ->where('users.status','0')     
                                ->where('users.name', 'LIKE', '%'. $search.'%') 
                                ->orWhere('userdetails.address', 'LIKE', '%'. $search.'%')     
                                ->orWhere('userdetails.phone', 'LIKE', '%'. $search.'%')   
                                ->orderBy('users.updated_at', 'desc')
                                ->offset($start);

            $totalFiltered = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                                ->join('roles', 'roles.id', '=', 'userdetails.role_id') 
                                ->where('userdetails.role_id','5')
                                ->where('users.status','0')   
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
                $nestedData['created_at'] =  $days_count <= 30 ? date('Y-M-d', strtotime($post->created_at)).''.'('. ($post->created_at->diffForHumans()).')' : $post->created_at->format('F j, Y').'<br>'.$post->created_at->format('g:i a');
                $nestedData['action'] = '
                <div class="text-center">                   
                <button type="button" class="btn  btn-outline-info modalbtn modalbtn" data-toggle="modal" data-target="#myModal" data-type="edit" data-toggle="tooltip" data-placement="top" title=" View Transaction" data-url="'.route('superadmin.active_gymer.edit',$post->id).'">
                <i class="fas fa-clipboard"></i>
              </button>    
                <form action="'.route('superadmin.inactive_gymer.destroy', [$post->id]).'"
                        method=POST
                        class="d-inline-block active_gymer"
                        title=" Inactive Gymer"
                        data-type="active_gymer">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn  btn-outline-danger" data-toggle="tooltip" data-placement="top" title=" Active Gymer" type="submit"><i class="fas fa-exchange-alt"></i></button>
                </form>
                <form action="'.route('superadmin.deletegymer.destroy', [$post->id]).'"
                method=POST
                class="d-inline-block delete_gymer"
                title=" Delete Gymer"
                data-type="delete_gymer">
            <input type="hidden" name="_token" value="'.csrf_token().'">
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn  btn-outline-danger" data-toggle="tooltip" data-placement="top" title=" Permanent Delete" type="submit"><i class="fas fa-trash"></i></button>
        </form>
              
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data_list = User::with('getUserDetail')->where('id', $request->active_gymer)->first();
        $payments = Payment::where('user_id', $request->active_gymer)->Latest()->get();
  
        return view('superadminbackend.inactive_gymer.create-edit',compact('data_list','payments'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      dd($request->all());
        $data = User::where('id',$request->inactive_gymer);
        $data::query()->delete();
        $notices = array(
            'aicon' => 'success',
            'atype' => 'info',
            'atitle' => 'Deleted Successfully!!',
            'message' => $data->name.', has been Deleted Permanently.'
        );

        return Response::json($notices);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $now = Carbon::now()->format('Y-m-d');

        $data = User::find($request->inactive_gymer);
        
        $data->update([
            'status'=> 1,
            'join_date'=>$now,
           
        ]);
        
        $notices = array(
            'aicon' => 'success',
            'atype' => 'info',
            'atitle' => 'Gymer Active Successfully!!',
            'message' => $data->name.', has been Active.'
        );

        return Response::json($notices);
    }
}
