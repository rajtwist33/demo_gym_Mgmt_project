<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\User_hasgroup;
use App\Models\User_hasoffer;
use App\Models\User_haspaymenttype;
use App\Http\Controllers\Controller;
class User_offerController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

    $data =  User_hasgroup::where('user_id',$request->user)->value('user_id');
    $demo = User_haspaymenttype::where('user_id',$request->user)->where('is_active',1)->value('user_id');
    $check_offer = User_hasoffer::where('user_id',$request->user)
                ->where('status',1)
                ->value('user_id');
    if($data != $request->user && $demo != $request->user && $check_offer != $request->user)
    {
        User_hasoffer::create([
        'user_id'=>$request->user,
        'offer_id'=>$request->offer,
        'status'=>1,
        'slug' => rand(1,9999),
        ]);

    }
    else
    {

        return redirect()->back()->with('info', 'Cannot Assign Offer To This Gymer');

    }
         return redirect()->back()->with('success', 'Offer Successfully Added');

}

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy(Request $request,$slug)
    {
        $data = User_hasoffer::where('slug', $slug)->update([
            'status'=> 0,
        ]);

        return redirect()->back()->with('danger', 'Offer has been Successfully Removed');
    }
}
