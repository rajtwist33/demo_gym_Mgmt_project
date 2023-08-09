<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\AnualPayment;
use Illuminate\Support\Facades\Response;

class Annual_PaymentController extends Controller
{
    public function index()
    {
         return view('superadminbackend.payment_type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
      

        $data_list = [];
        return view('superadminbackend.payment_type.create-edit',compact('data_list')); 
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
                $nestedData['created_at'] = $days_count <= 30 ?  date('Y-M-d', strtotime($post->created_at)).' '.'('. ($post->created_at->diffForHumans()).')'  : $post->created_at->format('F j, Y').'<br>'.$post->created_at->format('g:i a');
                $nestedData['action'] = '
                <div class="text-center">
                <button type="button" class="btn btn-xs btn-outline-info modalbtn" data-toggle="modal" data-target="#myModal" data-type="edit" data-url="'.route('superadmin.annual_payment.edit',$post->slug).'">
                  <i class="fa fa-edit"></i>
                </button>
                <form action="'.route('superadmin.annual_payment.destroy', [$post->id]).'"
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
       
       $monthly_discount = ($request->set_amount/100) * $request->discount;
       $monthly_amount = $request->set_amount - $monthly_discount;
      
       $total_amount = $request->no_month * $monthly_amount;
      
        $request->validate([
            'name'=>'required'
        ]);

       
            AnualPayment::updateOrCreate(
                [
                    'id' => $request->data_id
                ],
                [
                'payment_name' => $request->name,
                'set_amount'=>$request->set_amount,
                'no_month'=>$request->no_month,
                'total_amount'=>$total_amount,
                'monthly_amount'=>$monthly_amount,
                'discount'=>$request->discount,
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
       
        $data_list = AnualPayment::where('slug', $request->annual_payment)->first();
        return view('superadminbackend.payment_type.create-edit',compact('data_list'));
    }

   
    public function update(Request $request, $id)
    {
      
    }

   
    public function destroy(Request $request)
    {
        $data_destroy = AnualPayment::find($request->annual_payment);
        $data_destroy->delete();
        $notices = array(
            'aicon' => 'success',
            'atype' => 'info',
            'atitle' => 'Deleted Successfully!!',
            'message' => $data_destroy->payment_name.', has been removed.'
        );

        return Response::json($notices);
    }
}
