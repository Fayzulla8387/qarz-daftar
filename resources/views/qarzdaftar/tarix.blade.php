@extends('master')
@section('content')
    <style>.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: #2ad07c;
            color: white;
        }</style>
    <div class="card " style="box-shadow: 0px 0px 5px 5px #bdbdc0;border-top: 5px solid #0b136f; border-bottom: 5px solid #0b136f">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title " style="color: black; font-weight: bold">{{$qarzdor['name']}}ning qarzlar tarixi</h3>
            <a href="{{route('eskitarix',$qarzdor['id'])}}" class="btn btn-primary"><h3><i class="fa fa-book"></i> Eski tarixni ko'rish</h3></a>
        </div>
        <div class="card-body">
            <table class="table table-borederd border-1 table-hover hover-bg-red">
               <thead style="background-color: #0e1574; font-style: italic; color: white; font-weight: bolder; font-size: 20px;"> <tr>
                    <th>T/R</th>
                    <th class="w-25">Qarz miqdori</th>
                    <th class="" style=" width: 100px;">Izoh</th>
                    <th>Holati</th>
                   <th>Do'kon</th>

                   <th>Sana</th>
                </tr>
               </thead>
                <tbody style="color: black; font-weight: bold">

                @foreach($tarixlar as $key=>$qarz)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{number_format($qarz['debt'],0,'.',' ')}} so'm</td>
                        <td>@php if (strlen($qarz['caption']>30)){
    $strr="";
    for($i=0;$i<strlen($qarz['caption']);$i++){
        if ($i%30==0){
            $strr.="<br>";
        }
        $strr.=$qarz['caption'][$i];
    }
    echo $strr;
} else{
    echo $qarz['caption'];
} @endphp</td>
                        @if($qarz['debt']>0)
                            <td style="font-weight: bolder; color: #7d024c">Qarz olindi</td>
                        @else
                            <td style="font-weight: bolder; color: #068e18">Qarz to'landi</td>
                        @endif
                        <td> {{$qarz->user->name}}</td>
                        <td>{{$qarz['created_at']}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>

                        <td colspan="5" style="text-align: center; font-weight: bold; color: #0e1574">Joriy holatdagi qarzdorlik miqdori: {{number_format($qarzdor['debt'],0,'.',' ')}} so'm</td>

                </tfoot>
            </table>
        </div>
    </div>
@endsection
