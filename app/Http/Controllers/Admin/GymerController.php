<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use App\Models\Gender;
use App\Models\Advance;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Bloodtype;
use App\Models\Userdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User_hasoffer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class GymerController extends Controller
{
    public function index(Request $request)
    {
        $payments_alert = Advance::with('getUserdetail')->join('users', 'users.id', '=', 'advances.user_id')
            ->where('users.status', 1)
            ->where('advances.initial_advance', '<', 0)
            ->get();

        $count_alert = Advance::with('getUserdetail')->join('users', 'users.id', '=', 'advances.user_id')
            ->where('users.status', 1)
            ->where('advances.initial_advance', '<', 0)
            ->count();
        $offer_alerts = Package::Where('status', 1)->get();
        return view('backend.gymer.index', compact('payments_alert', 'count_alert', 'offer_alerts'));
    }


    public function create()
    {
        $data_list = [];
        $shifts = Shift::get();
        $blood_types = Bloodtype::get();
        $reffered_by = User::whereIn('role', ['4', '5'])->get();
        $genders = Gender::get();
        $offers = Package::Where('status', 1)->get();
        return view('backend.gymer.create-edit', compact('data_list', 'genders', 'shifts', 'blood_types', 'reffered_by', 'offers'));
    }

    public function show(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'phone',
            3 => 'address',
            4 => 'role',
            5 => 'payment',
            6 => 'crated_at',
            7 =>  'action',
        );

        $totalData = User::where('role', '5')->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                ->join('roles', 'roles.id', '=', 'userdetails.role_id')
                ->where('userdetails.role_id', '5')
                ->where('users.status', '1')
                ->orderBy('users.updated_at', 'desc')
                ->offset($start);
        } else {
            $search = $request->input('search.value');
            $posts = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                ->join('roles', 'roles.id', '=', 'userdetails.role_id')
                ->where('users.name', 'LIKE', '%' . $search . '%')
                ->orWhere('userdetails.address', 'LIKE', '%' . $search . '%')
                ->orWhere('userdetails.phone', 'LIKE', '%' . $search . '%')
                ->Where('users.status', '1')
                ->where('userdetails.role_id', '5')
                ->orderBy('users.updated_at', 'desc')
                ->offset($start);

            $totalFiltered = Userdetail::join('users', 'users.id', '=', 'userdetails.user_id')
                ->join('roles', 'roles.id', '=', 'userdetails.role_id')
                ->where('users.name', 'LIKE', '%' . $search . '%')
                ->orWhere('userdetails.address', 'LIKE', '%' . $search . '%')
                ->Where('users.status', '1')
                ->where('userdetails.role_id', '5')
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
                $nestedData['payment'] = ' <div class="text-center">
                            <button type="button" class="btn btn-outline-success modalbtn" data-toggle="modal" data-target="#payment" data-type="payment" data-toggle="tooltip" data-placement="top" title=" Payment Here" data-url="' . route('admin.payment.edit', $post->slug) . '">
                            <i class="fas fa-hand-holding-usd"></i>
                            </button>
                            <a href="' . route('admin.payment_history.show', $post->id) . '" class="btn  btn-outline-success"><i class="fas fa-receipt"data-toggle="tooltip" data-placement="top" title=" Payment History"></i></a>

                               </div>';
                $nestedData['created_at'] =  $days_count <= 30 ? date('Y-M-d', strtotime($post->created_at)) . ' ' . '(' . ($post->created_at->diffForHumans()) . ')' : $post->created_at->format('F j, Y') . '<br>' . $post->created_at->format('g:i a');

                $nestedData['action'] = '
                <div class="text-center">
                      <a href="' . route('admin.users_profile.edit', $post->slug) . '" class="btn btn-sm btn-outline-dark"><i class="fa fa-user"data-toggle="tooltip" data-placement="top" title=" User Profile"></i></a>
                    <button type="button" class="btn btn-sm btn-outline-warning modalbtn" data-toggle="modal" data-target="#myModal" data-type="edit" data-toggle="tooltip" data-placement="top" title=" Edit Data" data-url="' . route('admin.gymer.edit', $post->slug) . '">
                        <i class="fa fa-edit"></i>
                    </button>
                 <form action="' . route('admin.gymer.destroy', [$post->id]) . '"
                            method=POST
                            class="d-inline-block delete-confirm"
                            title="Permanent Delete"
                            data-type="destroy">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title=" Inactive Gymer" type="submit"><i class="fas fa-exchange-alt"></i></button>
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
                    'message' => 'This Gymer has already registered with this given  Phone Number.',
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
            $file->move(public_path('uploads/gymer'), $filename);
        }

        $check_payment =  Payment::where('user_id', $request->data_id)->get();
        $total_payment = $request->fee + $request->admission;
        DB::beginTransaction();
        try {
            $data_parent = User::updateOrCreate(
                [
                    'id' => $request->data_id
                ],
                [
                    'name' => $request->name,
                    'slug' => rand(1, 9999),
                    'email' => $request->email,
                    'password' => Hash::make($request->phone),
                    'role' => 5,
                    'dumy_join_date' => $request->join_date,
                    'join_date' => $request->join_date,
                ]
            );


            if ($request->data_id == Null) {
                Advance::create([
                    'user_id' => $data_parent->id,
                    'shift_id' => $request->shift_id,
                    'initial_advance' => 0,
                    'slug' => rand(1, 9999),
                ]);
            }
            Userdetail::updateOrCreate(
                [
                    'user_id' => $request->data_id
                ],
                [
                    'user_id' => $data_parent->id,
                    'role_id' => 5,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'blood_type' => $request->blood_type ?? 9,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'shift_id' => $request->shift_id,
                    'reffered_by' => $data_parent->id,
                    'weight' => $request->weight,
                    'height' => $request->height,
                    'fee' => $request->fee,
                    'discount' => $request->discount,
                    'admission' => $request->admission,
                    'physical_description' => $request->physical_description,
                    'break_notify' => $request->break_notify,
                    'parent_name' => $request->parent_name,
                    'gaurdian_name' => $request->gaurdian_name,
                    'gaurdian_number' => $request->gaurdian_number,
                    'card_no' => $request->card_no,
                    'image' =>  $request->image != '' ? $filename : 'avatar.png',
                    'insurence' => $request->insurence == 'on' ? true : false,
                ]
            );
            if ($request->offer_id != null) {
                User_hasoffer::updateOrCreate(
                    [
                        'user_id' => $request->data_id
                    ],
                    [
                        'user_id' => $data_parent->id,
                        'offer_id' => $request->offer_id,
                        'status' => 1,
                        'slug' => rand(1, 9999),
                    ]
                );
            }
            DB::commit();
            $noties = array(
                'message' => 'Gymer Submitted  Successfully!',
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
        $data_list = User::where('slug', $request->gymer)->with(['getUserDetail', 'user_hasoffer'])->first();
        $shifts = Shift::get();
        $blood_types = Bloodtype::get();
        $reffered_by = User::whereIn('role', ['4', '5'])->get();
        $genders = Gender::get();
        $offers = Package::Where('status', 1)->get();

        return view('backend.gymer.create-edit', compact('data_list', 'genders', 'shifts', 'blood_types', 'reffered_by', 'offers'));
    }

    public function update(Request $request, $id)
    {

        return view('backend.payment.create-edit');
    }


    public function destroy(Request $request)
    {

        $data_destroy = User::with('getUserDetail')->find($request->gymer);
        if (file_exists('uploads/gymer/' . $data_destroy['getUserDetail']->image)) {
            unlink('uploads/gymer/' . $data_destroy['getUserDetail']->image); // delete image
        }
        User::with('getUserDetail')->find($request->gymer)->update(
            [
                'status' => 0,
            ]
        );
        $notices = array(
            'aicon' => 'success',
            'atype' => 'info',
            'atitle' => 'Deleted Successfully!!',
            'message' => $data_destroy->name . ', has been Inactive.'
        );

        return Response::json($notices);
    }
}
