<?php

namespace App\Console\Commands;

use App\Models\OldTarix;
use App\Models\Qarzdor;
use App\Models\Tarix;
use Illuminate\Console\Command;

class Statistika extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:statistika';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Statistika tuzish';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sana=date('Y-m-d');
        $tarix=Tarix::whereDate('created_at','=',$sana)->get();
        $oldTarix=OldTarix::whereDate('created_at','=',$sana)->get();
        $jami=Qarzdor::all()->sum('debt');
        $olindi=0;
        $tolandi=0;
        foreach ($tarix as $item){
            if ($item->debt >0){
                $olindi+=$item->debt;
            }else{
                $tolandi+=abs($item->debt);
            }
        }
        foreach ($oldTarix as $item){
            if ($item->debt >0){
                $olindi+=$item->debt;
            }else{
                $tolandi+=abs($item->debt);
            }
        }
        \App\Models\Statistika::create([
            'date'=>$sana,
            'total_debt'=>$jami,
            'received_debt'=>$olindi,
            'paid_debt'=>$tolandi,
            'debtors_count'=>Qarzdor::all()->where('debt','>',0)->count()
        ]);
    }
}
