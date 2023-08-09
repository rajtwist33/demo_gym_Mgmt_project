<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Advance;
use App\Models\Gdiscount;
use App\Models\Userdetail;
use App\Models\User_hasgroup;
use App\Models\User_hasoffer;
use App\Models\User_haspaymenttype;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class normal_payment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'normal_payment:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly Basis Gymer Payment';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $counts = User_hasgroup::get(['user_id']);
        $offers = User_hasoffer::Where('status',1)->get('user_id');
        $user_haspayments = User_haspaymenttype::Where('is_active',1)->get('user_id');
             
        $payments = Userdetail::join('advances','advances.user_id' ,'=','userdetails.user_id')
                ->join('users','users.id','=','userdetails.user_id')
                ->WhereNotIn('users.id',$counts)
                ->WhereNotIn('users.id',$offers)
                ->WhereNotIn('users.id',$user_haspayments)
                ->where('users.status',1)
                ->get(['users.id','users.name','userdetails.fee as fee',
                'userdetails.user_id as user_id','advances.initial_advance as advance',
                'advances.user_id as id','users.join_date as join_date']);
                
   
    
       
        foreach($payments as $payment)
        {
            
            $fdate = $payment->join_date;
            $start = Carbon::parse($fdate)->format('Y-m-d');
            $count_days = now()->diffInDays(Carbon::parse($start));
            $day_differecnce = $count_days - 30;
            $user_fee = $payment->fee;
            $fee_perday =($user_fee/30);
            $actual_fee = round($fee_perday * $count_days);
            $total_fee = round($fee_perday * $day_differecnce);
          
            // if($count_days >= 30 && $count_days < 60)
            // {
            //     if($payment->user_id == $payment->id)
            //     {       
            //         if($payment->advance < 0 ){
            //             Advance::query()->where('user_id', $payment->id)
            //             ->update([
            //                     'user_id' =>  $payment->id,
            //                     'initial_advance' =>($payment->advance) - ( $total_fee),
            //                 ]);
            //         }  
            //         else if($payment->advance >= 0 ){ 
            //             Advance::query()->where('user_id', $payment->id)
            //             ->update([
            //                     'user_id' =>  $payment->id,
            //                     'initial_advance' =>($payment->advance) - ($total_fee),
            //                 ]);
            //         }   
                    
            //     }
            // }
             if($count_days >= 30)
            {
                if($payment->user_id == $payment->id)
                {       
                    
                    Advance::query()->where('user_id', $payment->id)
                    ->update([
                            'user_id' =>  $payment->id,
                            'initial_advance' =>($payment->advance) - ($payment->fee),
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
                            'initial_advance' => ($payment->advance) - ($actual_fee),
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

