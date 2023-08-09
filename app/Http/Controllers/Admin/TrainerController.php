<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use App\Models\Gender;
use App\Models\Advance;
use App\Models\Bloodtype;
use App\Models\Userdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class TrainerController extends Controller
{
    public function index()
    {
        $payments_alert = Advance::with('getUserdetail')->join('users', 'users.id', '=', 'advances.user_id')
            ->where('users.status', 1)
            ->where('advances.initial_advance', '<', 0)
            ->get();

        $count_alert = Advance::with('getUserdetail')->join('users', 'users.id', '=', 'advances.user_id')
            ->where('users.status', 1)
            ->where('advances.initial_advance', '<', 0)
            ->count();
        return view('backend.trainer.index', compact('payments_alert', 'count_alert'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data_list = [];
        $shifts = Shift::get();
        $blood_types = Bloodtype::get();
        $reffered_by = User::where('role', '4')->get();
        $genders = Gender::get();
        return view('backend.trainer.create-edit', compact('data_list', 'genders', 'shifts', 'blood_types', 'reffered_by'));
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
            6 => 'payment',
            7 =>  'action',
        );

        $totalData = User::where('role', '4')->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if (empty($request->input('search.value'))) {
            $posts = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                ->join('roles', 'roles.id', '=', 'userdetails.role_id')
                ->where('userdetails.role_id', '4')
                ->where('users.status', '1')
                ->orderBy('users.updated_at', 'desc')
                ->offset($start);
        } else {
            $search = $request->input('search.value');
            $posts = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                ->join('roles', 'roles.id', '=', 'userdetails.role_id')
                ->where('userdetails.role_id', '4')
                ->where('users.status', '1')
                ->where('users.name', 'LIKE', '%' . $search . '%')
                ->orWhere('userdetails.address', 'LIKE', '%' . $search . '%')
                ->orWhere('userdetails.phone', 'LIKE', '%' . $search . '%')
                ->orderBy('users.updated_at', 'desc')
                ->offset($start);

            $totalFiltered = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                ->join('roles', 'roles.id', '=', 'userdetails.role_id')
                ->where('userdetails.role_id', '4')
                ->where('users.status', '1')
                ->where('users.name', 'LIKE', '%' . $search . '%')
                ->orWhere('userdetails.address', 'LIKE', '%' . $search . '%')
                ->orWhere('userdetails.phone', 'LIKE', '%' . $search . '%')
                ->orderBy('users.updated_at', 'desc');

            $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
            ->orderBy($order, $dir)
            ->get(['users.id', 'users.created_at', 'user_id', 'name', 'role_id', 'role_name', 'phone', 'address', 'users.slug as slug']);


        $data = array();

        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                $start = Carbon::parse($post->created_at);
                $now = Carbon::now();
                $days_count = $start->diffInDays($now);
                $nestedData['id'] = $key + 1;
                $nestedData['name'] = $post->name;
                $nestedData['phone'] = $post->phone;
                $nestedData['address'] = $post->address;
                $nestedData['role'] = $post->role_name;
                $nestedData['created_at'] = $days_count <= 30 ? date('Y-M-d', strtotime($post->created_at)) . '' . '(' . ($post->created_at->diffForHumans()) . ')' : $post->created_at->format('F j, Y') . '<br>' . $post->created_at->format('g:i a');

                $nestedData['payment'] =
                    ' <div class="text-center">
                <button type="button" class="btn btn-outline-success modalbtn" data-toggle="modal" data-target="#trainerpayment" data-type="trainerpayment" data-toggle="tooltip" data-placement="top" title=" Payment Here" data-url="' . route('admin.trainerpayment.edit', $post->id) . '">
                <i class="fas fa-hand-holding-usd"></i>
                </button>

                <a href="' . route('admin.trainerpayment.show', $post->id) . '" class="btn  btn-outline-success"><i class="fas fa-receipt"data-toggle="tooltip" data-placement="top" title=" Payment History"></i></a>

                   </div>';
                $nestedData['action'] = '
                <div class="text-center">
                <a href="' . route('admin.trainershift.edit', $post->id) . '" class="btn btn-sm btn-outline-dark" style="font-size:130%;"><i class="fa fa-user"data-toggle="tooltip" data-placement="top" title=" Trainer Profile"></i></a>
                <button type="button" class="btn btn-xs btn-outline-info modalbtn" style="font-size:130%;" data-toggle="modal" data-target="#myModal" data-type="edit" data-url="' . route('admin.trainer.edit', $post->slug) . '">
                    <i class="fa fa-edit"></i>
                </button>
                <form action="' . route('admin.trainer.destroy', [$post->id]) . '"
                        method=POST
                        class="d-inline-block delete-confirm"
                        title="Permanent Delete"
                        data-type="delete_trainer">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-xs btn-outline-danger" style="font-size:130%;" type="submit"><i class="fa fa-trash"></i></button>
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

        if ($request->data_id == null) {
            $check_user = Validator::make($request->all(), [
                'phone' => 'required|unique:userdetails,phone',
            ]);

            if ($check_user->fails()) {
                $noties = array(
                    'message' => 'This Trainer has already registered with this  given  Phone Number.',
                    'atype' => 'error',
                    'aicon' => 'error'
                );
                return Response::json($noties);
            }
        }

        if (!empty($request->image)) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/trainer'), $filename);
        }

        DB::beginTransaction();
        try {
            $data_parent = User::updateOrCreate(
                [
                    'id' => $request->data_id
                ],
                [
                    'name' => $request->name,
                    'slug' => rand(1, 9999), // username
                    'email' => $request->email,
                    'password' => Hash::make($request->phone),
                    'role' => 4,
                    'join_date' => $request->join_date,
                ]
            );
            Userdetail::updateOrCreate(
                [
                    'user_id' => $request->data_id
                ],
                [
                    'user_id' => $data_parent->id,
                    'role_id' => 4,
                    'nagrita_no' => $request->nagrita_no,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'blood_type' => $request->blood_type ?? 9,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'shift_id' => null,
                    'reffered_by' => $data_parent->id,
                    'weight' => $request->weight,
                    'height' => $request->height,
                    'card_no' => $request->card_no,
                    'payment' => $request->payment_amount,
                    'parent_name' => $request->parent_name,
                    'gaurdian_number' => $request->parent_number,
                    'gaurdian_address' => $request->parent_address,
                    'image' =>  $request->image != '' ? $filename : 'avatar.png',
                    'insurence' => $request->insurence == 'on' ? true : false,
                ]
            );

            DB::commit();
            $noties = array(
                'message' => 'Trainer Submitted Successfully!',
                'atype' => 'success',
                'aicon' => 'success'
            );
        } catch (\Exception $e) {
            DB::rollback();
            $noties = array(
                'message' => 'Your data could not store.',
                'atype' => 'error',
                'aicon' => 'error'
            );
        }
        return Response::json($noties);
    }
    public function edit(Request $request)
    {
        $data_list = User::where('slug', $request->trainer)->with('getUserDetail')->first();
        $shifts = Shift::get();
        $blood_types = Bloodtype::get();
        $reffered_by = User::whereIn('role', ['4', '5'])->get();
        $genders = Gender::get();
        return view('backend.trainer.create-edit', compact('data_list', 'genders', 'shifts', 'blood_types', 'reffered_by'));
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy(Request $request)
    {
        $data_destroy = User::with('getUserDetail')->find($request->trainer);
        if (file_exists('uploads/trainer/' . $data_destroy['getUserDetail']->image)) {
            unlink('uploads/trainer/' . $data_destroy['getUserDetail']->image);
        }
        $data_destroy->delete();
        $notices = array(
            'aicon' => 'success',
            'atype' => 'info',
            'atitle' => 'Deleted Successfully!!',
            'message' => $data_destroy->name . ', has been removed.'
        );

        return Response::json($notices);
    }
}
