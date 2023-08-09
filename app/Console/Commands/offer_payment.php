<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User_hasoffer;
use Illuminate\Support\Carbon;
use App\Models\Advance;
use App\Models\Userdetail;
use App\Models\User;

class offer_payment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offer_payment:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Offers run Daily';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $offer_discount = User_hasoffer::join('packages','packages.id','=','user_hasoffers.offer_id')
                ->join('users','users.id','=','user_hasoffers.user_id')
                ->Where('user_hasoffers.status',1)
                ->get('user_id');
              
        $payments = Userdetail::join('advances','advances.user_id' ,'=','userdetails.user_id')
            ->join('users','users.id','=','userdetails.user_id')
            ->where('users.status',1)
            ->WhereIn('users.id',$offer_discount)
            ->get(['users.id','users.name','userdetails.fee as fee',
            'userdetails.user_id as user_id','advances.initial_advance as advance',
            'advances.user_id as id','users.join_date as join_date']);
         

  foreach($payments as $payment)
    {                  
        //offer fee          
            $offer_d = User_hasoffer::join('packages','packages.id','=','user_hasoffers.offer_id')
            ->join('users','users.id','=','user_hasoffers.user_id')
            ->where('users.id',$payment->user_id)
            ->Where('user_hasoffers.status',1)
            ->value('discount');    
         
            $fdate = $payment->join_date;
          
            $start = Carbon::parse($fdate)->format('Y-m-d');
            $count_days = now()->diffInDays(Carbon::parse($start));
            $offer_fee = Userdetail::where('user_id',$payment->user_id)->value('fee');
            $d_offer = ($offer_fee / 100) * $offer_d;   
            $day_differecnce = $count_days - 30;    
            $offer_actual_fee = $offer_fee - $d_offer;        
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
                                    'initial_advance' => ($payment->advance)-($actual_fee),
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
                                'initial_advance' => ($payment->advance)- ($actual_fee),
                            ]);    
                        }            
                    }
                }
                       
        }   
               
    
}
}

