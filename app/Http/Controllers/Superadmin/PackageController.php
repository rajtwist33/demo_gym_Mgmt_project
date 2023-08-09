<?php

namespace App\Http\Controllers\Superadmin;

use Carbon\Carbon;
use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;


class PackageController extends Controller
{
    public function index()
    {
         return view('superadminbackend.offer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
      

        $data_list = [];
        return view('superadminbackend.offer.create-edit',compact('data_list')); 
    }

    public function show(Request $request)
    { 
        $columns = array(
                        0 => 'id', 
                        1 => 'name',
                        2=>'created_at'
                    );
        
        $totalData = Package::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {       
            $posts = Package::offset($start);
        }
        else 
        {
            $search = $request->input('search.value'); 
            $posts = Package::where('name', 'LIKE', '%'.$search.'%')
                            ->offset($start);

            $totalFiltered = Package::where('name', 'LIKE', '%'.$search.'%');
            
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
                $nestedData['name'] = $post->name;
                $nestedData['discription'] = $post->discription;
                $nestedData['discount'] = $post->discount."%";
                $nestedData['start_date'] = date('Y-M-d', strtotime($post->start_date));
                $nestedData['end_date'] = date('Y-M-d', strtotime($post->end_date));
                $nestedData['status'] = $post->status == 1 ? 'Active' : 'Expired';
                $nestedData['created_at'] = $days_count <= 30 ?  date('Y-M-d', strtotime($post->created_at)).'('. ($post->created_at->diffForHumans()).')' : $post->created_at->format('F j, Y').'<br>'.$post->created_at->format('g:i a');
                $nestedData['action'] = '
                <div class="text-center">
                <button type="button" class="btn btn-xs btn-outline-info modalbtn" data-toggle="modal" data-target="#myModal" data-type="edit" data-url="'.route('superadmin.offer.edit',$post->slug).'">
                  <i class="fa fa-edit"></i>
                </button>
                <form action="'.route('superadmin.offer.destroy', [$post->id]).'"
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
            'name'=>'required'
        ]);

            Package::updateOrCreate(
                [
                    'id' => $request->data_id
                ],
                [
                'name' => $request->name,
                'description'=>$request->description,
                'discount'=>$request->discount,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'status'=>1,
                'slug' => rand(1,99999999),
                ]
        );

        $noties = array(
            'message' => $request->name.', submitted successfully!',
            'atype' => 'success',
            'aicon' => 'success'
        );
        return Response::json($noties);
    }

  
    public function edit(Request $request)
    {
       

        $data_list = Package::where('slug', $request->offer)->first();
        return view('superadminbackend.offer.create-edit',compact('data_list'));
    }

   
    public function update(Request $request, $id)
    {
      
    }

   
    public function destroy(Request $request)
    {
        $data_destroy = Package::find($request->offer);
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
