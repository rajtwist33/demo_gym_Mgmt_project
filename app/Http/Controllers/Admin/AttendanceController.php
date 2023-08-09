<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use App\Models\Gender;
use App\Models\Bloodtype;
use App\Models\Attendance;
use App\Models\Userdetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        
        $attendances=Attendance::with('getShift')->get();
        $userdetails=Userdetail::with(['users','shifts'])->get();
        $shifts=Shift::get();
        $data_list = [];
        $dates = Carbon::now()->toDateString();
        return view('backend.attendance.index',compact('attendances','shifts','data_list','dates','userdetails'));
    }

    public function create(Request $request)
    {
        
    }

    public function show(Request $request)
    { 
       
        // dd($posts);

        $columns = array(
                        0 => 'shift_name', 
                        1 => 'name',
                        2 => 'action',
                        3 => 'remark',
                    );
        
        $totalData = Userdetail::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        $search = $request->input('search.value'); 
        if(empty($request->input('search.value')))
        {       
            $posts = Userdetail::join('shifts', 'shifts.id', '=', 'userdetails.shift_id')
            ->join('users', 'users.id', '=', 'userdetails.user_id')       
            ->get(['user_id','name','shift_id','shift_name']);
                      
            if ($request->data_s != null) {
                $posts = Userdetail:: join('shifts', 'shifts.id', '=', 'userdetails.shift_id')                    
                    ->join('users', 'users.id', '=', 'userdetails.user_id')
                    ->where('shift_id', $request->data_s)
                    ->get();
                 }

            if ($request->data_d != null) {                   
                $posts = Userdetail::join('attendances', 'attendances.id', '=', 'userdetails.id')
                ->join('users', 'users.id', '=', 'userdetails.user_id')
                ->join('shifts','shifts.id', '=', 'attendances.shift_id')
                ->where('attendances.date', $request->data_d)
                ->get(['attendances.user_id','users.name','attendances.shift_id','shifts.shift_name','attendances.date']);
             }   
                       
        }
        else 
        {
            $search = $request->input('search.value'); 
            $posts = Userdetail::join('shifts', 'shifts.id', '=', 'userdetails.shift_id')
                    ->join('users', 'users.id', '=', 'userdetails.user_id')
                    ->where('users.name', 'LIKE', '%'. $search.'%') 
                    ->orWhere('shifts.shift_name', 'LIKE', '%'. $search.'%')
                    ->get(['user_id','users.name as name','shift_id','shifts.shift_name as shift_name']); 
              
            if ($request->data_s != null) {
                $posts = Userdetail:: join('shifts', 'shifts.id', '=', 'userdetails.shift_id')                    
                    ->join('users', 'users.id', '=', 'userdetails.user_id')
                    ->where('shift_id', $request->data_s)
                    ->get(['user_id','name','shift_id','shift_name']);       
                    }       
    
            if ($request->data_d != null) {                   
                $posts = Userdetail::join('attendances', 'attendances.id', '=', 'userdetails.id')
                ->join('users', 'users.id', '=', 'userdetails.user_id')
                ->join('shifts','shifts.id', '=', 'attendances.shift_id')
                ->where('attendances.date', $request->data_d)
                ->get(['attendances.user_id','users.name','attendances.shift_id','shifts.shift_name','attendances.date']);
                }   
            

            $totalFiltered = $totalFiltered;
        }
        if ($request->data_s != null && $request->input('search.value')) {
            $posts = Userdetail::join('shifts', 'shifts.id', '=', 'userdetails.shift_id')
            ->join('users', 'users.id', '=', 'userdetails.user_id')
            ->where('userdetails.shift_id',$request->data_s)
            ->where('users.name', 'LIKE', '%'. $search.'%') 
            ->get(['user_id','users.name as name','shift_id','shifts.shift_name as shift_name']); 
            }

        $posts = $posts;
              
        $data = array();

        if(!empty($posts))
        {
            foreach ($posts as $key=>$post)
            {
            
                $nestedData['shift_name'] = $post->shift_name;
                $nestedData['name'] = $post->name;
                $nestedData['action'] = '
                <div class="text-center"> 
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success " data-type="attendance">
                        <input type="checkbox" class="custom-control-input attendance" id="'.$post->id.'" checked data-of="'.$post->id.'">
                        <label class="custom-control-label" for="'.$post->id.'"></label>
                    </div>
                    <input type="hidden" class="attend attendance_val'.$post->id.'" name="attend['.$post->id.']" id="attendance_val'.$post->id.'" value="1">
                </div>
                ';
           
                $nestedData['remark'] = ' 
                <div class="text-center"> 
                    <div>
                        <input type="text" class="form-control remark" name="remark['.$post->id.']" id="remark" autocomplete="off">
                        <input type="hidden" class="form-control dataval" name="data['.$post->id.']" id="dataval" value="'.$post->id.'">
                        <input type="hidden" class="form-control shiftval" name="shift['.$post->id.']" id="shiftval" value="'.$post->shift_id.'">
                       
                    </div>
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
        foreach ($request->dataval as $key => $value) {
            Attendance::create(
                [   
                    'shift_id' => $request->s_shift[$key]['value'],
                    'user_id' => $value['value'],
                    'status' => $request->datastring[$key]['value'] ? true : false,
                    'remark' => $request->remark[$key]['value'],
                    'date' => $request->s_date == date('Y-m-d') ? date('Y-m-d H:i:s') : $request->s_date.' '.date('H:i:s'),
                ]
            );
        }

        $noties = array(
            'message' => 'Attendance Created  Successfully!',
            'atype' => 'success',
            'aicon' => 'success'
        );
        return Response::json($noties);
        
    }

   

   
    public function edit(Request $request)
    {
        $data_list = Attendance::with('getShift')->where('slug', $request->attendance)->first();
        return view('backend.attendance.attendance',compact('data_list'));
    }

    public function update(Request $request)
    {
        //
    }

   
    public function destroy(Request $request)
    {
        $data_destroy = Attendance::find($request->attendance);
        $data_destroy->delete();
        $notices = array(
            'aicon' => 'success',
            'atype' => 'info',
            'atitle' => 'Deleted Successfully!!',
            'message' => $data_destroy['getShift']->shift_name.', has been removed.'
        );

        return Response::json($notices);
    }
   
}
