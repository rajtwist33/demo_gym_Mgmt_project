<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Advance;
use App\Models\Package;
use App\Models\User_hasoffer;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User_haspaymenttype;

class DailyRunforpaymenttypeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyRunforpaymenttypeCron:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $date = Carbon::parse($now)->toDateString();
        Package::whereDate('end_date', '<', $date)->update(
            [
                'status'=>0,
            ]
        );

      
        $datas= User_haspaymenttype::WhereDate('end_date', '<', $date)->get();
            foreach($datas as $data){
                Advance::where('user_id',$data->user_id)->update(
                    [
                        'initial_advance'=>0,
                    ]      
                );
                User::where('id',$data->user_id)->update(
                    ['join_date'=> $now->format('Y-m-d'),]
                );
         User_haspaymenttype::WhereDate('end_date', '<', $date)->update(
            [
                'is_active' => 0,
            ]
         );
    }

        
    
    }
}
