<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Models\Shift;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Route;

class ShiftController extends Controller
{
    public function index()
    {       
      
         return view('superadminbackend.shift.index');
    }
    public function create(){
        $data_list = [];
        return view('superadminbackend.shift.create-edit',compact('data_list')); 
    }

    public function show(Request $request)
    { 
     $columns = array(
        0 => 'id', 
        1 => 'shift_name',
        2 => 'starttime',
        3 => 'endtime',
        4 => 'created_at',
        5 => 'action',
    );
        
        $totalData = Shift::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {       
            $posts = Shift::offset($start);
        }
        else 
        {
            $search = $request->input('search.value'); 
            $posts = Shift::where('shift_name', 'LIKE', '%'.$search.'%')
                            ->offset($start);

            $totalFiltered = Shift::where('shift_name', 'LIKE', '%'.$search.'%');
            
            $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
                       ->orderBy($order,$dir)
                       ->get();
     
        $data = array();

        if(!empty($posts))
        {
            $edit_url = "";
            $edit_it = "d-none";
            $destroy_url = "";
            $destroy_it = "d-none";
            foreach ($posts as $key=>$post)
            {
                if(Route::has("superadmin.shift.edit")){
                    $edit_it = "";
                    $edit_url = route('superadmin.shift.edit',$post->slug); 
                }
                if(Route::has("superadmin.shift.destroy")){
                    $destroy_it = "";
                    $destroy_url = route('superadmin.shift.destroy', [$post->id]); 
                }
                $start = Carbon::parse($post->created_at);
                $now = Carbon::now();
                $days_count = $start->diffInDays($now);

                $nestedData['id'] = $key+1;
                $nestedData['shift_name'] = $post->shift_name;
                $nestedData['starttime'] = date('g:i a', strtotime($post->starttime));
                $nestedData['endtime'] = date('g:i a', strtotime($post->endtime));
                $nestedData['created_at'] = $days_count <= 30 ? date('Y-M-d', strtotime($post->created_at)).' '.'('. ($post->created_at->diffForHumans()).')' : $post->created_at->format('F j, Y').'<br>'.$post->created_at->format('g:i a');
                $nestedData['action'] = '
                <div class="text-center">
                <button type="button" class="btn btn-xs btn-outline-info modalbtn '.$edit_it.'" data-toggle="modal" data-target="#myModal" data-type="edit" data-url="'.$edit_url.'">
                  <i class="fa fa-edit"></i>
                </button>
                
                <form action="'.$destroy_url.'"
                       method=POST
                       class="d-inline-block delete-confirm"
                       title="Permanent Delete"
                       data-type="destroy">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-xs btn-outline-danger '.$destroy_it.'" type="submit"><i class="fa fa-trash"></i></button>
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

        
        $request->validate([
                    'shift_name' => 'required',
                    'starttime' => 'required',
                    'endtime' => 'required',
        ]);
      
            Shift::updateOrCreate(
                [
                    'id' => $request->data_id
                ],
                [
                'shift_name' => $request->shift_name,
                'slug' => Str::slug($request->name),
                'starttime' => $request->starttime,
                'endtime' => $request->endtime,
                'slug' => rand(1,99999999),
            ]);
            $noties = array(
                'message' => 'Shift Created Successfully!',
                'atype' => 'success',
                'aicon' => 'success'
            );
        return Response::json($noties);
        
    }
    public function edit(Request $request)
    {
        $data_list = Shift::where('slug', $request->shift)->first();
        
        return view('superadminbackend.shift.create-edit',compact('data_list'));
    }
    public function update(Request $request, $id)
    {
    }

    public function destroy(Request $request)
    {
        $data_destroy = Shift::find($request->shift);
        $data_destroy->delete();
        $notices = array(
            'aicon' => 'success',
            'atype' => 'info',
            'atitle' => 'Deleted Successfully!!',
            'message' => $data_destroy->shift_name.', has been removed.'
        );

        return Response::json($notices);
    }
}


