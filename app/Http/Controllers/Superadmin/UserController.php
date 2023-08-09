<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        return view('superadminbackend.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create(){
        $roles=Role::select('role_name')->get();
        $data_list = [];
        return view('superadminbackend.users.create-edit',compact('data_list','roles')); 
    }

    public function show(Request $request)
    { 
    $columns = array(
                    0 => 'id', 
                    1 => 'name',
                    2 => 'email',
                    3 => 'role',
                    4 =>'password',
                    5 => 'created_at',
                    6 => 'action',
                    7 =>'pass_name',
                );
    
    $totalData = User::where('role','2')->count();
    $totalFiltered = $totalData; 
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');


    if(empty($request->input('search.value')))
    {       
        $posts = User::offset($start);
    }
    else 
    {
        $search = $request->input('search.value'); 
        $posts = User::where('name', 'LIKE', '%'.$search.'%')->orwhere('email', 'LIKE', '%'.$search.'%')
                        ->offset($start);

        $totalFiltered = User::where('name', 'LIKE', '%'.$search.'%')->orwhere('email', 'LIKE', '%'.$search.'%');
        
        $totalFiltered = $totalFiltered->count();
    }

    $posts = $posts->where('role','2')->limit($limit)
                    ->orderBy($order,$dir)
                    ->with('roles')
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
            $nestedData['name'] = $post->name;
            $nestedData['role'] = $post['roles']->role_name;
            $nestedData['email'] = $post->email;
            $nestedData['password'] = $post->password;
            $nestedData['created_at'] = $days_count <= 30 ? date('Y-M-d', strtotime($post->created_at)).''.'('. ($post->created_at->diffForHumans()).')' : $post->created_at->format('F j, Y').'<br>'.$post->created_at->format('g:i a');
            $nestedData['action'] = '
            <div class="text-center">
            <button type="button" class="btn btn-sm btn-outline-info modalbtn" data-toggle="modal" data-target="#myModal" data-type="edit" data-url="'.route('superadmin.users.edit',$post->slug).'">
                <i class="fa fa-edit"></i>
            </button>
            <form action="'.route('superadmin.users.destroy', [$post->id]).'"
                    method=POST
                    class="d-inline-block delete-confirm"
                    title="Permanent Delete"
                    data-type="destroy">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input name="_method" type="hidden" value="DELETE">
                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fa fa-trash"></i></button>
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


public function store(Request $request)
{
    foreach ($request->datastring as $key => $datainput) {
        $request[$datainput['name']] = $datainput['value'];
    }
   if($request->data_id == ''){
        User::create(
            [
            'name' => $request->admin_name,
            'role' => '2',
            'slug' => rand(1,99999999),
            'email' => $request->email,
            'pass_name'=>$request->password,
            'password'=>Hash::make($request->password),
            'join_date' =>Carbon::now()->format('Y-m-d'),
        ]);
    }
     if($request->data_id != ''){
      
            User::where('id',$request->data_id)->update(
                [
                    'name' => $request->admin_name,
                    'role' => '2',
                    'slug' => rand(1,99999999),
                    'email' => $request->email,
                    'pass_name'=>$request->password,
                    'password'=>Hash::make($request->password),
                    'join_date' =>Carbon::now()->format('Y-m-d'),
                ]
                );
    }
        $noties = array(
            'message' => 'User Submitted Successfully!',
            'atype' => 'success',
            'aicon' => 'success'
        );
    return Response::json($noties);
    
}
public function edit(Request $request)
{
    $data_list = User::where('slug', $request->user)->first();
   
    return view('superadminbackend.users.create-edit',compact('data_list'));
}


public function update(Request $request, $id)
{
    foreach ($request->datastring as $key => $datainput) {
        $request[$datainput['name']] = $datainput['value'];
    }    
    $request->validate([
                'mode' => 'required',
               
    ]);

        User::Create(
            [
            'mode' => $request->check,
            ]);
          
        $noties = array(
            'message' => 'Dark Mode Changes!',
            'atype' => 'success',
            'aicon' => 'success'
        );

    return Response::json($noties);
    
}


public function destroy(Request $request)
{
    $data_destroy = User::find($request->user);
    $data_destroy->delete();
    $notices = array(
        'aicon' => 'success',
        'atype' => 'info',
        'atitle' => 'Deleted Successfully!!',
        'message' => $data_destroy->name.', has been removed.'
    );

    return Response::json($notices);
}


}
