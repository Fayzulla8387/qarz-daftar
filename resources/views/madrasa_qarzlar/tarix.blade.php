@extends('master')
@section('content')
    <div class="card " style="box-shadow: 0px 0px 5px 5px #bdbdc0;border-top: 5px solid #0b136f; border-bottom: 5px solid #0b136f">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title " style="color: black; font-weight: bold">{{$qarzdor['name']}}ning qarzlar tarixi</h3>
        </div>
        <div class="card-body">
            <table class="table table-borederd border-1">
               <thead style="background-color: #0e1574; font-style: italic; color: white; font-weight: bolder"> <tr>
                    <th>T/R</th>
                    <th>Qarz miqdori</th>
                    <th>Izoh</th>
                    <th>Holati</th>
                    <th>Sana</th>
                </tr>
               </thead>
                <tbody style="color: black; font-weight: bold">

                @foreach($tarixlar as $key=>$qarz)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{number_format($qarz['debt'],0,'.',' ')}} so'm</td>
                        <td>{{$qarz['caption']}}</td>
                        @if($qarz['debt']>0)
                            <td style="font-weight: bold; color: #7d024c">Qarz olindi</td>
                        @else
                            <td style="font-weight: bold; color: #068e18">Qarz to'landi</td>
                        @endif
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
