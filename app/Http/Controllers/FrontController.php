<?php

namespace App\Http\Controllers;

use App\Models\Korxona;
use App\Models\OldTarix;
use App\Models\Qarzdor;
use App\Models\SmsTarix;
use App\Models\Statistika;
use App\Models\Tarix;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontController extends Controller
{
    public function qarzdor($id){
        return response()->json(Qarzdor::with('korxona')->find($id));
    }

    public function balansim(){
        try {
            $b=" ".number_format(\Napa\R19\Sms::limits()['data']['balance'],0,'.',' ')." so'm";

        }catch (\Exception $e){
            $b="aniqlab bo'lmadi";
        }
        return redirect()->back()->with('success',$b);
}
    public function dashboard()
    {


        $users = User::all();
        $tarix = Tarix::all();
        $tarixold = OldTarix::all();
        $data = [];
        $allsum = 0;
        foreach ($users as $user) {
            $data[$user->id]['user'] = $user;
            $data[$user->id]['berdi'] = 0;
            $data[$user->id]['name'] = $user->name;
            foreach ($tarix as $item) {
                if ($item->user_id == $user->id and $item->debt > 0) {
                    $data[$user->id]['berdi'] += $item->debt;
                    $allsum += $item->debt;
                }
            }
            foreach ($tarixold as $item) {
                if ($item->user_id == $user->id and $item->debt > 0) {
                    $data[$user->id]['berdi'] += $item->debt;
                    $allsum += $item->debt;
                }
            }
        }
        foreach ($data as $key => $datum) {
            if ($datum['berdi'] != 0) {
                $data[$key]['foiz'] = round($datum['berdi'] / $allsum * 100);
            } else {
                $data[$key]['foiz'] = 0;
            }
        }

        $names = "";
        foreach ($data as $key => $datum) {
            $names .= '"' . $datum['name'] . '",';
        }
        $vals = "";
        foreach ($data as $key => $datum) {
            $vals .= $datum['foiz'] . ',';
        }
        $names = substr($names, 0, -1);
        $vals = substr($vals, 0, -1);


        $stats = Statistika::all()->sortByDesc('date');
        $stat = $stats->first();
        $tarix = Tarix::whereDate('created_at', '=', $stat->date)->get();
        $tarixold = OldTarix::whereDate('created_at', '=', $stat->date)->get();

        return view('dashboard.dashboard',
            [
                'stats' => $stats,
                'stat' => $stat,
                'tarix' => $tarix,
                'tarixold' => $tarixold,
                'data' => $data,
                'names' => $names,
                'vals' => $vals,
            ]);
    }

    public function dashboard2(Request $request)
    {
        $stats = Statistika::all()->sortByDesc('date');
        $stat = $stats->where('date', $request->date)->first();
        if ($stat == null) {
            return redirect()->route('dashboard')->withErrors('Bunday sanadagi statistika mavjud emas');
        }
        $users = User::all();
        $tarix = Tarix::all();
        $tarixold = OldTarix::all();
        $data = [];
        $allsum = 0;
        foreach ($users as $user) {
            $data[$user->id]['user'] = $user;
            $data[$user->id]['berdi'] = 0;
            $data[$user->id]['name'] = $user->name;
            foreach ($tarix as $item) {
                if ($item->user_id == $user->id and $item->debt > 0) {
                    $data[$user->id]['berdi'] += $item->debt;
                    $allsum += $item->debt;
                }
            }
            foreach ($tarixold as $item) {
                if ($item->user_id == $user->id and $item->debt > 0) {
                    $data[$user->id]['berdi'] += $item->debt;
                    $allsum += $item->debt;
                }
            }
        }
        foreach ($data as $key => $datum) {
            if ($datum['berdi'] != 0) {
                $data[$key]['foiz'] = round($datum['berdi'] / $allsum * 100);
            } else {
                $data[$key]['foiz'] = 0;
            }
        }

        $names = "";
        foreach ($data as $key => $datum) {
            $names .= '"' . $datum['name'] . '",';
        }
        $vals = "";
        foreach ($data as $key => $datum) {
            $vals .= $datum['foiz'] . ',';
        }
        $names = substr($names, 0, -1);
        $vals = substr($vals, 0, -1);

        $tarix = Tarix::whereDate('created_at', '=', $stat->date)->get();
        $tarixold = OldTarix::whereDate('created_at', '=', $stat->date)->get();

        return view('dashboard.dashboard', [
            'stats' => $stats,
            'stat' => $stat,
            'tarix' => $tarix,
            'tarixold' => $tarixold,
            'data' => $data,
            'names' => $names,
            'vals' => $vals,
        ]);
    }

    public function madrasa_qarzlar()
    {

        $qarzdorlar = Qarzdor::all('id','name','phone','type')
            ->where('type', 2);


        $bugungi_qarzdorlar = Qarzdor::all('type','name','phone','debt','return_date')
            ->where('type', 2)
            ->where('return_date', date('Y-m-d'));

        return view('madrasa_qarzlar.index', [
            'qarzdorlar' => (object)$qarzdorlar,
            'bugungi_qarzdorlar' => $bugungi_qarzdorlar,
        ]);
    }

    public function qarzdaftar()
    {

        $qarzdorlar = Qarzdor::all('id','name','phone','type')
            ->where('type', 1);


        $korxonalar=Korxona::all('id','name');

        $bugungi_qarzdorlar = Qarzdor::all('type','name','phone','debt','return_date')
            ->where('type', 1)
            ->where('return_date', date('Y-m-d'));

        return view('qarzdaftar.index', [
            'qarzdorlar' => (object)$qarzdorlar,
            'bugungi_qarzdorlar' => $bugungi_qarzdorlar,
            'korxonalar'=>$korxonalar
        ]);
    }

    public function royhat()
    {

        $qarzdorlar = Qarzdor::with('korxona')
            ->where('debt', '>', 0)
            ->orderBy('return_date')
            ->get(['id', 'type', 'name', 'phone', 'debt', 'return_date', 'sms_count', 'korxona_id']);

        return view('royhat.index', [
            'qarzdorlar' => $qarzdorlar,
        ]);
    }

    public function sms()
    {
        $smslar = SmsTarix::orderBy('id', 'desc')
            ->paginate(50);

        return view('sms.index', compact('smslar'));
    }

    public function muddati_otgan()
    {
        return view('muddati_otgan.index');
    }

    public function tarix($id)
    {
        return view('qarzdaftar.tarix', [
            'id' => $id,
        ]);

    }

    public function profile()
    {

        return view('profile', [
            'dukon' => auth()->user()
        ]);
    }

    public function profile_update(Request $request)
    {
        $user = Auth::user();
        $a = User::all()
            ->where('id', '!=', auth()->user()->id)
            ->where('name', $request->name)->count();

        if ($a > 0) {
            return redirect()->back()->withErrors('Bunday do\'kon nomi mavjud');
        }
        $a = User::all()
            ->where('id', '!=', auth()->user()->id)
            ->where('email', $request->email)
            ->count();

        if ($a > 0) {
            return redirect()->back()->withErrors('Bunday email bo\'yicha do\'kon mavjud');
        }
        if (!Hash::check($request->parol_current, $user->password)) {

            return redirect()->back()->withErrors('Parol noto\'g\'ri');
        }
        if ($request->parol_new_1 == null and $request->parol_new_2 == null) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return redirect()->back()->with('success', 'Ma\'lumotlar muvaffaqiyatli yangilandi');
        } else {
            if ($request->parol_new_1 != $request->parol_new_2) {
                return redirect()->back()->withErrors('Takroriy parol noto\'g\'ri kiritildi');
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->parol_new_1);
            $user->save();
        }
        return redirect()->route('profile')->with('success', 'Profil muvaffaqiyatli yangilandi');
    }


    public function getQarzdorlar($id)
    {
        if ($id == 'none') {
            $qarzdorlar = Qarzdor::whereNull('korxona_id')->where('debt', '>', 0)->get();
        } else {
            $qarzdorlar = Qarzdor::where('korxona_id', $id)->where('debt', '>', 0)->get();
        }
        return response()->json($qarzdorlar);
    }
}
