<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advance;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view('backend.offer.index',compact('payments_alert','count_alert'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
       

        $posts = $posts->Where('status',1)->limit($limit)
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
                $nestedData['discount'] = $post->discount ."%";
                $nestedData['start_date'] = date('Y-M-d', strtotime($post->start_date));
                $nestedData['end_date'] = date('Y-M-d', strtotime($post->end_date));
                $nestedData['created_at'] = $days_count <= 30 ? $post->created_at->diffForHumans() : $post->created_at->format('F j, Y').'<br>'.$post->created_at->format('g:i a');
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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
