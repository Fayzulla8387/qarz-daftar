<?php

namespace App\Http\Controllers;

use App\Models\OldTarix;
use App\Models\Qarzdor;
use App\Models\SmsTarix;
use App\Models\Tarix;
use Illuminate\Console\View\Components\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Nakroma\Cereal;
use Napa\R19\Sms;

use mrmuminov\eskizuz\Eskiz;

class QarzConteroller extends Controller
{

    public function qarzdor_yaratish(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required  | min:9 | max:9',
            'debt' => 'required',
            'return_date' => 'required | date | date_format:Y-m-d',
            "korxona_id" => 'nullable',
        ]);
        if ($request->phone!='123456789') {
            if (Qarzdor::all()->where('phone', $request->phone)->count() > 0) {
                return redirect()->back()->withErrors('Bunday raqamli qarzdor mavjud');
            }
        }else{
            if (Qarzdor::all()->where('name', $request->name)->count() > 0) {
                return redirect()->back()->withErrors('Ism ham raqam ham bir xil boshqa qazdor mavjud');
            }
        }
        $a=Qarzdor::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'debt' => $request->debt,
            'return_date' => $request->return_date,
            'type'=>$request->type,
            'korxona_id' => $request->korxona_id,
        ]);
        Tarix::create([
            'qarzdor_id' => $a->id,
            'debt' => $request->debt,
            'caption' => $request->caption,
            'user_id' => auth()->user()->id,
        ]);
        if ($request->phone!='123456789') {/// not number
            try {
                $sms_r_d = date('d.m.Y', strtotime($request->return_date));

                $time = Cereal::generate(['length' => '10', 'delimiter' => '']);
                while (SmsTarix::where('sms_id', $time)->first()) {
                    $time = Cereal::generate(['length' => '10', 'delimiter' => '']);
                }
                $text = "PLUS MARKET do'konidan " . $request->debt . " qarz olindi. Qaytarish muddati " . $sms_r_d;
                $eskiz = new Eskiz('ESKIZDAN_OLGAN_EMAILNI_QOYASAN', 'ESKIZ_BARGAN_KEY_NI_QOYASAN');
                $auth = $eskiz->requestAuthLogin();
                $nm=(string)$request->phone;
                $nm=$nm[0].$nm[1];
                if ($nm=='91' || $nm=='90'){
                    $sendsinglesms = $eskiz->requestSmsSend('4546', $text, '998' . $request->phone, "$time", 'https://plusmarket.uz/api/call');

                }else{
                    $sendsinglesms = $eskiz->requestSmsSend('PLUS_MARKET', $text, '998' . $request->phone, "$time", 'https://plusmarket.uz/api/call');

                }
                $tz = $sendsinglesms->getResponse();

                SmsTarix::create([
                    'phone' => $request->phone,
                    'text' => "Qarz olingani haqida",
                    'status' => $tz->status,
                    'sms_id' => $time,

                ]);

            } catch (\Exception $exception) {
                return redirect()->back()->withErrors('Qarzdor yaratildi ammo Sms yuborilmadi')->with('t_qarzdor_id', $a->id);
            }
        }
        return redirect()->back()->with('success', 'Qarzdor yaratildi')->with('t_qarzdor_id', $a->id);

    }

    public function qarz_berish(Request $request)
    {

        $request->validate([
            'qarzdor_id' => 'required',
            'qarz_miqdori' => 'required',
            'qaytarish_muddati' => 'required | date | date_format:Y-m-d',
        ]);
        if (Tarix::where('qarzdor_id',$request->qarzdor_id)->where('debt',$request->qarz_miqdori)->where('caption',$request->izoh)->where('created_at', '>', now()->subSeconds(60))->exists()){
            return redirect()->back()->withErrors('Ushbu qarz 1 marta berildi, yana berish uchun 1 daqiqa kuting')->with('t_qarzdor_id', $request->qarzdor_id);
        }
        $qarzdor = Qarzdor::find($request->qarzdor_id);
        if ($qarzdor->status==2){
            return redirect()->back()->withErrors("Qarzdor bloklangan, qarz berish uchun holati `Omonatdor` bo'lishi shart")->with('t_qarzdor_id', $request->qarzdor_id);
        }
        if ($qarzdor->limit!=0 and $qarzdor->limit<$request->qarz_miqdori+$qarzdor->debt){
            return redirect()->back()->withErrors('Qarzdorning limiti '.number_format($qarzdor->limit,0,'.',' ').' so\'m')->with('t_qarzdor_id', $request->qarzdor_id);
        }
        $qarzdor->debt = $qarzdor->debt + $request->qarz_miqdori;
        $qarzdor->return_date = $request->qaytarish_muddati;
        $qarzdor->save();
        Tarix::create([
            'qarzdor_id' => $request->qarzdor_id,
            'debt' => $request->qarz_miqdori,
            'caption' => $request->izoh,
            'user_id' => auth()->user()->id,
        ]);
        if ($qarzdor->phone!='123456789') {
            try {
                $sms_r_d = date('d.m.Y', strtotime($qarzdor->return_date));

                $time = Cereal::generate(['length' => '10', 'delimiter' => '']);
                while (SmsTarix::where('sms_id', $time)->first()) {
                    $time = Cereal::generate(['length' => '10', 'delimiter' => '']);
                }
                $text = "PLUS MARKET do'konidan " . $request->qarz_miqdori . " qarz olindi. Joriy qarzdorlik " . $qarzdor->debt . " Qaytarish muddati " . $sms_r_d;
                $eskiz = new Eskiz('ESKIZDAN_OLGAN_EMAILNI_QOYASAN', 'ESKIZ_BARGAN_KEY_NI_QOYASAN');
                $auth = $eskiz->requestAuthLogin();
                $nm=(string)$qarzdor->phone;
                $nm=$nm[0].$nm[1];
                if ($nm=='91' || $nm=='90'){
                    $sendsinglesms = $eskiz->requestSmsSend('4546', $text, '998' . $qarzdor->phone, "$time", 'https://plusmarket.uz/api/call');

                }else{
                    $sendsinglesms = $eskiz->requestSmsSend('PLUS_MARKET', $text, '998' . $qarzdor->phone, "$time", 'https://plusmarket.uz/api/call');

                }
                $tz = $sendsinglesms->getResponse();

                SmsTarix::create([
                    'phone' => $qarzdor->phone,
                    'text' => "Qarz olingani haqida",
                    'status' => $tz->status,
                    'sms_id' => $time,

                ]);

            } catch (\Exception $exception) {
                return redirect()->back()->withErrors('Qarz berildi ammo Sms yuborilmadi'.$exception->getMessage())->with('t_qarzdor_id', $request->qarzdor_id);
            }
        }
        return redirect()->back()->with('success', 'Qarz berildi')->with('t_qarzdor_id', $request->qarzdor_id);
    }

    public function qarz_uzish(Request $request)
    {
        $request->validate([
            'qarzdor_id' => 'required',
            'qarz_miqdori' => 'required'
        ]);
        if (Tarix::where('qarzdor_id',$request->qarzdor_id)->where('debt',-1*$request->qarz_miqdori)->where('caption',$request->izoh)->where('created_at', '>', now()->subSeconds(60))->exists()){
            return redirect()->back()->withErrors('Ushbu qarz 1 marta to\'landi, yana to\'lash uchun 1 daqiqa kuting')->with('t_qarzdor_id', $request->qarzdor_id);
        }
        $qarzdor = Qarzdor::find($request->qarzdor_id);
        if ($qarzdor->debt<$request->qarz_miqdori){
            return redirect()->back()->withErrors('Qarzdorning qarzi '.$qarzdor->debt.' so\'m, Siz '.$request->qarz_miqdori."so'm kiritdingiz")->with('t_qarzdor_id', $request->qarzdor_id);
        }
        $qarzdor->debt = $qarzdor->debt - $request->qarz_miqdori;
        $qarzdor->save();
        $qarzdor=Qarzdor::find($request->qarzdor_id);


        Tarix::create([
            'qarzdor_id' => $request->qarzdor_id,
            'debt' => -1*$request->qarz_miqdori,
            'caption' => $request->izoh,
            'user_id' => auth()->user()->id,
        ]);
        if($qarzdor->debt==0){
            $qarzdor->return_date=null;
            $qarzdor->sms_count=0;
            $tarixold=Tarix::where('qarzdor_id',$request->qarzdor_id)->get();
            foreach ($tarixold as $item){
                OldTarix::create([
                    'id'=>$item->id,
                    'qarzdor_id'=>$item->qarzdor_id,
                    'debt'=>$item->debt,
                    'caption'=>$item->caption,
                    'user_id'=>$item->user_id,
                    'created_at'=>$item->created_at,
                    'updated_at'=>$item->updated_at,

                ]);
                Tarix::where('qarzdor_id',$request->qarzdor_id)->delete();

            }
            if ($qarzdor->phone!='123456789') {

                try {
                    $time = Cereal::generate(['length' => '10', 'delimiter' => '']);
                    while (SmsTarix::where('sms_id', $time)->first()) {
                        $time = Cereal::generate(['length' => '10', 'delimiter' => '']);
                    }
                    $text = "PLUS MARKET do'konidagi barcha qarzlaringiz to'landi. Doimiy xaridorimiz bo'lib qoling !";
                    $eskiz = new Eskiz('ESKIZDAN_OLGAN_EMAILNI_QOYASAN', 'ESKIZ_BARGAN_KEY_NI_QOYASAN');
                    $eskiz->requestAuthLogin();
                    $nm=(string)$qarzdor->phone;
                    $nm=$nm[0].$nm[1];
                    if ($nm=='91' || $nm=='90'){
                        $sendsinglesms = $eskiz->requestSmsSend('4546', $text, '998' . $qarzdor->phone, "$time", 'https://plusmarket.uz/api/call');

                    }else{
                        $sendsinglesms = $eskiz->requestSmsSend('PLUS_MARKET', $text, '998' . $qarzdor->phone, "$time", 'https://plusmarket.uz/api/call');

                    } $tz = $sendsinglesms->getResponse();

                    SmsTarix::create([
                        'phone' => $qarzdor->phone,
                        'text' => "Barcha qarz to'langani haqida",
                        'status' => $tz->status,
                        'sms_id' => $time,

                    ]);

                } catch (\Exception $exception) {
                    return redirect()->back()->withErrors('Qarz uzildi ammo Sms yuborilmadi')->with('t_qarzdor_id', $request->qarzdor_id);
                }
            }
        }else{
            if ($qarzdor->phone!='123456789') {

                try {
                    $sms_r_d = date('d.m.Y', strtotime($qarzdor->return_date));

                    $time = Cereal::generate(['length' => '10', 'delimiter' => '']);
                    while (SmsTarix::where('sms_id', $time)->first()) {
                        $time = Cereal::generate(['length' => '10', 'delimiter' => '']);
                    }
                    $text = "PLUS MARKET do'koniga " . $request->qarz_miqdori . " qarz to'landi . Joriy qarzdorlik " . $qarzdor->debt . " Qaytarish muddati " . $sms_r_d;
                    $eskiz = new Eskiz('ESKIZDAN_OLGAN_EMAILNI_QOYASAN', 'ESKIZ_BARGAN_KEY_NI_QOYASAN');
                    $eskiz->requestAuthLogin();
                    $nm=(string)$qarzdor->phone;
                    $nm=$nm[0].$nm[1];
                    if ($nm=='91' || $nm=='90'){
                        $sendsinglesms = $eskiz->requestSmsSend('4546', $text, '998' . $qarzdor->phone, "$time", 'https://plusmarket.uz/api/call');

                    }else{
                        $sendsinglesms = $eskiz->requestSmsSend('PLUS_MARKET', $text, '998' . $qarzdor->phone, "$time", 'https://plusmarket.uz/api/call');

                    }   $tz = $sendsinglesms->getResponse();

                    SmsTarix::create([
                        'phone' => $qarzdor->phone,
                        'text' => "Qarz to'langani haqida",
                        'status' => $tz->status,
                        'sms_id' => $time,

                    ]);

                } catch (\Exception $exception) {
                    return redirect()->back()->withErrors('Qarz to\'landi ammo Sms yuborilmadi')->with('t_qarzdor_id', $request->qarzdor_id);
                }
            }
        }
        $qarzdor->save();
        return redirect()->back()->with('success', 'Qarz uzildi')->with('t_qarzdor_id', $request->qarzdor_id);
    }
    public function qarzdor_tahrirlash(Request $request){

        $request->validate([
            'qarzdor_id' => 'required',
            'ism' => 'required',
            'telefon' => 'required  | min:9 | max:9',
            'limit' => 'required',
            'qaytarish_muddati' => 'required | date | date_format:Y-m-d',
            'korxona_id'=>"nullable"
        ]);
        $qarzdor = Qarzdor::find($request->qarzdor_id);
        if($qarzdor->phone != $request->telefon){
            if (Qarzdor::all()
                    ->where('phone', $request->telefon)
                    ->where('phone','!=','123456789')
                    ->count() > 0) {
                return redirect()->back()->withErrors( 'Bunday raqamli qarzdor mavjud')->with('t_qarzdor_id', $request->qarzdor_id);
            }
        }
            $qarzdor->name = $request->ism;
            $qarzdor->phone = $request->telefon;
            $qarzdor->limit = $request->limit;
            $qarzdor->caption = $request->izoh;
            $qarzdor->return_date = $request->qaytarish_muddati;
            $qarzdor->status = $request->status_edit;
            $qarzdor->korxona_id = $request->korxona_id;
            $qarzdor->save();
            return redirect()->back()->with('success', 'Ma\'lumotlar tahrirlandi')->with('t_qarzdor_id', $request->qarzdor_id);

    }
    public function tarix(Request $request)
    {
        $request->validate([
            'qarzdor_id' => 'required',
        ]);
        $qarzdor = Qarzdor::find($request->qarzdor_id);
        $tarixlar = Tarix::all()->where('qarzdor_id', $request->qarzdor_id);
        return view('qarzdaftar.tarix', compact('tarixlar','qarzdor'));
    }

    public function eskitarix($id){
        $qarzdor = Qarzdor::find($id);
        $tarixlar = OldTarix::all()->where('qarzdor_id', $id);
        return view('qarzdaftar.eskitarix', compact('tarixlar','qarzdor'));
    }

    public function bittaSmsJonat(Request $request){
        $request->validate([
            'qarzdor_id' => 'required',
        ]);
        $qarzdor=Qarzdor::find($request->qarzdor_id);
        if ($qarzdor->phone=='123456789'){
            return redirect()->back()->withErrors('Telefon raqam kiritilmagan')->with('t_qarzdor_id', $request->qarzdor_id);
        }
        $time=Cereal::generate(['length' => '10','delimiter'=>'']);
        while (SmsTarix::where('sms_id',$time)->first()){
            $time=Cereal::generate(['length' => '10','delimiter'=>'']);
        }
        $qarz=$qarzdor->debt;
        $text="Hurmatli mijoz ! PLUS MARKET do'konidan ".$qarz." so'm qarzingizni to'lash muddati keldi. Bugunoq to'lashni unutmang ! Murojaat uchun: tel:888069999 ";
        try {
            $eskiz = new Eskiz('ESKIZDAN_OLGAN_EMAILNI_QOYASAN', 'ESKIZ_BARGAN_KEY_NI_QOYASAN');
            $auth = $eskiz->requestAuthLogin();
            $nm=(string)$qarzdor->phone;
            $nm=$nm[0].$nm[1];
            if ($nm=='91' || $nm=='90'){
                $sendsinglesms = $eskiz->requestSmsSend('4546', $text, '998' . $qarzdor->phone, "$time", 'https://plusmarket.uz/api/call');

            }else{
                $sendsinglesms = $eskiz->requestSmsSend('PLUS_MARKET', $text, '998' . $qarzdor->phone, "$time", 'https://plusmarket.uz/api/call');

            }   $tz=$sendsinglesms->getResponse();

            SmsTarix::create([
                'phone' => $qarzdor->phone,
                'text' =>"Qarzdorlik eslatmasi jo'natildi",
                'status' =>$tz->status,
                'sms_id'=>$time,

            ]);

        }catch (\Exception $e){

            return redirect()->back()->withErrors('Sms jo\'natishda xatolik, iltimos qaytadan urinib ko\'ring')->with('t_qarzdor_id', $request->qarzdor_id);
        }

        return redirect()->back()->with('success', 'Sms jo\'natildi')->with('t_qarzdor_id', $request->qarzdor_id);
    }

    public function tanlanganlara_jonat(Request $request){
        if ($request->qarzdorlar==null){
            return redirect()->back()->withErrors('Qarzdorlar tanlanmadi');
        }
        $qarzdorlar=$request->qarzdorlar;

        foreach ($qarzdorlar as $idsi=>$qarzdor){

            $qarzdor=Qarzdor::find($idsi);
            if ($qarzdor->phone=='123456789'){
                continue;
            }
            $time=Cereal::generate(['length' => '10','delimiter'=>'']);
            while (SmsTarix::where('sms_id',$time)->first()){
                $time=Cereal::generate(['length' => '10','delimiter'=>'']);
            }
            $qarz=$qarzdor->debt;
            $text="Hurmatli mijoz ! PLUS MARKET do'konidan ".$qarz." so'm qarzingizni to'lash muddati keldi. Bugunoq to'lashni unutmang ! Murojaat uchun: tel:888069999 ";
            try {
                $eskiz = new Eskiz('ESKIZDAN_OLGAN_EMAILNI_QOYASAN', 'ESKIZ_BARGAN_KEY_NI_QOYASAN');
                $auth = $eskiz->requestAuthLogin();
                $nm=(string)$qarzdor->phone;
                $nm=$nm[0].$nm[1];
                if ($nm=='91' || $nm=='90'){
                    $sendsinglesms = $eskiz->requestSmsSend('4546', $text, '998' . $qarzdor->phone, "$time", 'https://plusmarket.uz/api/call');

                }else{
                    $sendsinglesms = $eskiz->requestSmsSend('PLUS_MARKET', $text, '998' . $qarzdor->phone, "$time", 'https://plusmarket.uz/api/call');

                }  $tz=$sendsinglesms->getResponse();

                    SmsTarix::create([
                        'phone' => $qarzdor->phone,
                        'text' =>"Qarzdorlik eslatmasi jo'natildi",
                        'status' =>$tz->status,
                        'sms_id'=>$time,

                    ]);

            }catch (\Exception $e){

                return redirect()->back()->withErrors('Sms jo\'natishda xatolik, iltimos qaytadan urinib ko\'ring');
            }

        }
        return redirect()->back()->with('success', 'Sms jo\'natildi');

    }

    public function reklama_sms(Request $request){
        $request->validate([
            'telefon_nomer' => 'required | min:9 | max:9',
        ]);
        $text="PLUS MARKET da barcha mahsulotlar, oziq-ovqat, o'yinchoq, kanstovar va ovqatlanish uchun Kafe mavjud. Sizni kutamiz! Aloqa:888069999 https://t.me/plusmarket_N1";

   try{
       $time=Cereal::generate(['length' => '10','delimiter'=>'']);
       while (SmsTarix::where('sms_id',$time)->first()){
           $time=Cereal::generate(['length' => '10','delimiter'=>'']);
       }
       $eskiz = new Eskiz('ESKIZDAN_OLGAN_EMAILNI_QOYASAN', 'ESKIZ_BARGAN_KEY_NI_QOYASAN');
       $auth = $eskiz->requestAuthLogin();
       $nm=(string)$request->telefon_nomer;
       $nm=$nm[0].$nm[1];
       if ($nm=='91' || $nm=='90'){
           $sendsinglesms = $eskiz->requestSmsSend('4546', $text, '998' .$request->telefon_nomer, "$time", '/');

       }else{
           $sendsinglesms = $eskiz->requestSmsSend('PLUS_MARKET', $text, '998' .$request->telefon_nomer, "$time", '/');

       } $tz=$sendsinglesms->getResponse();

       SmsTarix::create([
           'phone' =>$request->telefon_nomer,
           'text' =>"Reklama sms jo'natildi",
           'status' =>$tz->status,
           'sms_id'=>$time,

       ]);
   }catch (\Exception $e){

return redirect()->back()->withErrors('Sms jo\'natishda xatolik, iltimos qaytadan urinib ko\'ring');
}
        return redirect()->back()->with('success', 'Sms jo\'natildi');

    }


    public function call(Request $request){

        $id=$request->user_sms_id;
        $sms=SmsTarix::where('sms_id',$id)->first();
        $sms->status=$request->status;
        $sms->save();
        if ($request->status=='DELIVRD' and $sms->text=='Qarzdorlik eslatmasi jo\'natildi'){
            $qarzdor=Qarzdor::where('phone',$sms->phone)->first();
            $qarzdor->sms_count=$qarzdor->sms_count+1;
            if ($qarzdor->sms_count==5){
                $qarzdor->status=2;
            }
            $qarzdor->save();
        }elseif ($request->status=='DELIVRD' and $sms->text=="Barcha qarz to'langani haqida"){
            $qarzdor=Qarzdor::where('phone',$sms->phone)->first();
            $qarzdor->sms_count=0;
            $qarzdor->save();
        }
        return response()->json(['success'=>'ok']);


    }

}
