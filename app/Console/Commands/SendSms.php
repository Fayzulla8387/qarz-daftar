<?php

namespace App\Console\Commands;

use App\Models\Qarzdor;
use App\Models\SmsTarix;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use mrmuminov\eskizuz\Eskiz;
use Nakroma\Cereal;
use Napa\R19\Sms;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       // Log::info('sms yuborish ishladi '.date('Y-m-d H:i:s'));
        $qarzdorlar= Qarzdor::all()->where('debt','>',0)->where('return_date','<=',date('Y-m-d'))->where('sms_count',0);
        foreach ($qarzdorlar as $item) {
            if ($item->phone=='123456789') {
                continue;
            }
            try{
                $time=Cereal::generate(['length' => '10','delimiter'=>'']);
                while (SmsTarix::where('sms_id',$time)->first()){
                    $time=Cereal::generate(['length' => '10','delimiter'=>'']);
                }
                $text="Hurmatli mijoz !  Ruslan Kafedan ".$item->debt." so'm qarzingizni to'lash muddati keldi. Bugunoq to'lashni unutmang !
Murojaat uchun: tel:";//telefon nomer;
                $eskiz = new Eskiz('ESKIZDAN_OLGAN_EMAILNI_QOYASAN', 'ESKIZ_BARGAN_KEY_NI_QOYASAN');
                $auth = $eskiz->requestAuthLogin();
                $nm=(string)$item->phone;
                $nm=$nm[0].$nm[1];
                if ($nm=='91' || $nm=='90'){
                    $sendsinglesms = $eskiz->requestSmsSend('4546', $text, '998' . $item->phone, "$time", 'https://plusmarket.uz/api/call');

                }else{
                    $sendsinglesms = $eskiz->requestSmsSend('PLUS_MARKET', $text, '998' . $item->phone, "$time", 'https://plusmarket.uz/api/call');

                } $tz=$sendsinglesms->getResponse();

                SmsTarix::create([
                    'phone' => $item->phone,
                    'text' =>"Qarzdorlik eslatmasi jo'natildi",
                    'status' =>$tz->status,
                    'sms_id'=>$time,

                ]);

            }catch (\Exception $e){
                Log::error($e->getMessage());
            }

        }
    }
}
