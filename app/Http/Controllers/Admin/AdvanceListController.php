<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Advance;
use App\Models\Userdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AdvanceListController extends Controller
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
                            
         return view('backend.advancelist.index',compact('payments_alert','count_alert'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
       
    }

    public function show(Request $request)
    { 
        $columns = array(
                        0 => 'id', 
                        1 => 'name',
                        2 => 'initial_advance',
                        3 => 'crated_at',
                        4=>  'action',
                    );
        
        $totalData = Advance::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {       
            $posts = Advance::join('users','users.id' ,'=', 'advances.user_id')
                             ->offset($start);
        }
        else 
        {
            $search = $request->input('search.value'); 
            $posts = Advance::join('users','users.id' ,'=', 'advances.user_id')
                            ->where('users.name', 'LIKE', '%'.$search.'%')
                            ->offset($start);
                        
                    
            $totalFiltered = $posts;

            $totalFiltered = $totalFiltered->count();
            }
        
                $posts = $posts->limit($limit)
                            ->orderBy($order,$dir)
                            ->get(['users.name as name','advances.initial_advance as advances',
                                    'advances.updated_at','advances.slug','advances.id']);
              
             
                $data = array();

        if(!empty($posts))
        {
            foreach ($posts as $key=>$post)
            {
                $start = Carbon::parse($post->updated_at);
                $now = Carbon::now();
                $days_count = $start->diffInDays($now);
                $nestedData['id'] = $key+1;
                $nestedData['name'] = $post->name;
                $nestedData['initial_advance'] = "Rs"." ".$post->advances;
                $nestedData['updated_at'] = $days_count <= 30 ? $post->updated_at->diffForHumans() : $post->updated_at->format('F j, Y').'<br>'.$post->updated_at->format('g:i a');
                $nestedData['action'] = '
                <div class="text-center">
                <button type="button" class="btn btn-sm btn-outline-info modalbtn" data-toggle="modal" data-target="#myModal" data-type="payment" data-toggle="tooltip" data-placement="top" title="Place your Advance Here" data-url="'.route('admin.advancelist.edit',$post->slug).'">
                <i class="fas fa-coins"></i>
                </button> 
                 </div>
                ';
                
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
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
           'startdate'=> 'required',
           'enddate'=> 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            $noties = array(
                'message' => 'Your validation is incorrect.',
                'atype' => 'error',
                'aicon' => 'error'
            );
            return Response::json($noties);
        }
      
        Advance::where('slug', $request->advancelist)->with('getUser')->first()
        ->update([

         'user_id'=> $request->data_id,
         'startdate'=> $request->startdate,
         'enddate'=> $request-> enddate,
          'initial_advance'=> $request->initial_advance,
          'remaining_advance'=> $request->initial_advance,
     
        
        ]);
            $noties = array(
                    'message' => 'Advance Payment Updated  Successfully!',
                    'atype' => 'success',
                    'aicon' => 'success'
                    );
        
        
        return Response::json($noties);
    }

    public function edit(Request $request)
    {
        $data_advance=Advance::where('slug', $request->advancelist)->with('getUser')->first();
        return view('backend.advancelist.create-edit',compact('data_advance'));
    }
  
    public function update(Request $request)
    {
      
         Advance::where('slug', $request->advancelist)
        ->update([

         'user_id'=> $request->data_id,
         'startdate'=> $request->startdate,
         'enddate'=> $request-> enddate,
          'initial_advance'=> $request->initial_advance,
          'remaining_advance'=> $request->initial_advance,
     
        
        ]);

        

            $noties = array(
                    'message' => 'Advance Payment Updated  Successfully!',
                    'atype' => 'success',
                    'aicon' => 'success'
                    );
        
        
        return Response::json($noties);
    }
    

    public function destroy(Request $request)
    {
        $data_destroy = Advance::find($request->advancelist);
        $data_destroy->delete();
        $notices = array(
            'aicon' => 'success',
            'atype' => 'info',
            'atitle' => 'Deleted Successfully!!',
            'message' => $data_destroy['getUser']->name.', has been removed.'
        );

        return Response::json($notices);
    }
}
