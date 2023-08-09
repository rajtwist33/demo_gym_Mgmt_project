<?php

namespace App\Http\Controllers\Superadmin;
use Carbon\Carbon;
use App\Models\Gdiscount;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class GroupDiscounController extends Controller
{
    public function index()
    {       
         return view('superadminbackend.groupdiscount.index');
    }
    public function create(){
        $data_list = [];
        return view('superadminbackend.groupdiscount.create-edit',compact('data_list')); 
    }

    public function show(Request $request)
    { 
     $columns = array(
        0 => 'id', 
        1 => 'no_gymer',
        2 => 'discount',
        3 => 'created_at',
        4 => 'action',
    );
        
        $totalData = Gdiscount::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {       
            $posts = Gdiscount::offset($start);
        }
        else 
        {
            $search = $request->input('search.value'); 
            $posts = Gdiscount::where('no_gymer', 'LIKE', '%'.$search.'%')
                            ->offset($start);

            $totalFiltered = Gdiscount::where('no_gymer', 'LIKE', '%'.$search.'%');
            
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
                $nestedData['no_gymer'] = $post->no_gymer.' '.'persons';                
                $nestedData['discount'] = $post->discount."%";                
                $nestedData['created_at'] = $days_count <= 30 ?  date('Y-M-d', strtotime($post->created_at)).'  '.'('. ($post->created_at->diffForHumans()).')'  : $post->created_at->format('F j, Y').'<br>'.$post->created_at->format('g:i a');
                $nestedData['action'] = '
                <div class="text-center">
                <button type="button" class="btn btn-xs btn-outline-info modalbtn" data-toggle="modal" data-target="#myModal" data-type="edit" data-url="'.route('superadmin.groupdiscount.edit',$post->slug).'">
                  <i class="fa fa-edit"></i>
                </button>
                <form action="'.route('superadmin.groupdiscount.destroy', [$post->id]).'"
                       method=POST
                       class="d-inline-block delete-confirm"
                       title="Permanent Delete"
                       data-type="destroy">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-xs btn-outline-danger" type="submit"><i class="fa fa-trash"></i></button>
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
                    'no_gymer' => 'required',
                    'discount' => 'required',           
        ]);
      
        Gdiscount::updateOrCreate(
                [
                    'id' => $request->data_id
                ],
                [
                'no_gymer' => $request->no_gymer,  
                'discount' => $request->discount,
                'slug' => rand(1,99999999),
               
            ]);
            $noties = array(
                'message' => 'Groupdiscount Created Successfully!',
                'atype' => 'success',
                'aicon' => 'success'
            );
        return Response::json($noties);
        
    }
    public function edit(Request $request)
    {
        $data_list = Gdiscount::where('slug', $request->groupdiscount)->first();
        return view('superadminbackend.groupdiscount.create-edit',compact('data_list'));
    }
    public function update(Request $request, $id)
    {
    }

    public function destroy(Request $request)
    {
        $data_destroy = Gdiscount::find($request->groupdiscount);
        $data_destroy->delete();
        $notices = array(
            'aicon' => 'success',
            'atype' => 'info',
            'atitle' => 'Deleted Successfully!!',
            'message' => $data_destroy->no_gymer.', has been removed.'
        );
        return Response::json($notices);
    }
}
