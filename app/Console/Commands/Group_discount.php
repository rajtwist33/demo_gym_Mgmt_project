<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User_hasgroup;
use App\Models\Userdetail;
use App\Models\Gdiscount;
use Illuminate\Support\Carbon;
use App\Models\Advance;

class Group_discount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Group_discount:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Group_discount is provided';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = User_hasgroup::groupBy('user_id')
            ->selectRaw('count(*) as total, user_id')
            ->get(['total','user_id']);
       
         $user_in_group = User_hasgroup::groupBy('user_id')
            ->get('user_id');
     
            $payments = Userdetail::join('advances','advances.user_id' ,'=','userdetails.user_id')
                    ->join('users','users.id','=','userdetails.user_id')
                    ->where('users.status',1)
                    ->whereIn('users.id',$user_in_group)
                    ->get(['users.id','users.name','userdetails.fee as fee',
                    'userdetails.user_id as user_id','advances.initial_advance as advance',
                    'advances.user_id as id','users.join_date as join_date']);
               
           
              
            foreach($payments as $payment)
            {    
                
                foreach($count as $c){
                $number = $c->total;
                }
            
                if($number >= 4)
                {
                    $discount = Gdiscount::where('no_gymer',4)
                    ->value('discount');
                    
                }
                else if ($number < 4)
                {
                    $discount = Gdiscount::where('no_gymer',$number)
                    ->value('discount');   
                    
                }
                $fdate = $payment->join_date;
                $start = Carbon::parse($fdate)->format('Y-m-d');
                $count_days = now()->diffInDays(Carbon::parse($start));
                $d_offer = ($payment->fee / 100) * $discount;   
                $day_differecnce = $count_days - 30;    
                $offer_actual_fee = $payment->fee - $d_offer;      
                $fee_perday =($offer_actual_fee)/30;
                $actual_fee = round($fee_perday * $count_days);
                $total_fee = round($fee_perday * $day_differecnce);
              
               
                    if($count_days >= 30)
                    {
                        if($payment->user_id == $payment->id)
                        {       
                            
                            Advance::query()->where('user_id', $payment->id)
                            ->update([
                                    'user_id' =>  $payment->id,
                                    'initial_advance' =>($payment->advance) - ($offer_actual_fee),
                                ]);
                            
                        }
                    }
                    else if($count_days < 30)
                    {
                        if($payment->user_id == $payment->id)
                        { 
                            if($payment->advance == 0)
                            {
                              
                                Advance::query()->where('user_id', $payment->id)
                                ->update([
                                        'user_id' =>  $payment->id,
                                        'initial_advance' =>($payment->advance) -($actual_fee),
                                    ]);   
                            }
                            else if($payment->advance < 0)
                            {
                            Advance::query()->where('user_id', $payment->id)
                            ->update([
                                    'user_id' =>  $payment->id,
                                    'initial_advance' => ($payment->advance)- ($actual_fee),
                                ]);    
                            }            
                            else if($payment->advance > 0)
                            {
                            Advance::query()->where('user_id', $payment->id)
                            ->update([
                                    'user_id' =>  $payment->id,
                                    'initial_advance' => ($payment->advance) - ($actual_fee),
                                ]);    
                            }            
                        }
                    }                 
            
        }
    }
}
