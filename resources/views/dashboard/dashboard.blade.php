@extends('master')
@section('content')
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Statistika - {{ date('d.m.Y',strtotime($stat->date))}}</h3>
    </div>
    <div class="row overflow-auto">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-success py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xl mb-1"><span>Barcha qarzlar</span>
                            </div>
                            <div class="text-dark fw-bold h5 mb-0"><span>{{number_format($stat->total_debt,'0','.',' ') }} so'm</span>
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-success py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xl mb-1"><span>Qarz olindi</span>
                            </div>
                            <div class="text-dark fw-bold h5 mb-0"><span>{{number_format($stat->received_debt,'0','.',' ')}} so'm</span>
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-success py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xl mb-1"><span>Qarz to'landi</span>
                            </div>
                            <div class="text-dark fw-bold h5 mb-0"><span>{{number_format($stat->paid_debt,'0','.',' ')}} so'm</span>
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-success py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xl mb-1"><span>Qarzdorlar</span>
                            </div>
                            <div class="text-dark fw-bold h5 mb-0"><span>{{number_format($stat->debtors_count,'0','.',' ')}} ta</span>
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row overflow-auto">
        <div class="col-lg-7 col-xl-8">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-primary fw-bold m-0">Qarzlar olish va berish statistikasi</h6>

                </div>
                <div class="card-body " style="height: 450px;">
                    <div id="chartContainer" style=""></div>

                </div>
            </div>
        </div>

    </div>
    <div class="row overflow-auto">
        <div class="col-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="text-primary fw-bold m-0">Bajarilgan amaliyotlar</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr style="color: #ffffff; font-size: 20px; font-weight: bold; background-color: #22074d">
                            <th>T/R</th>
                            <th>Qarzdor</th>
                            <th>Miqdor</th>
                            <th>Holat</th>
                            <th>Vaqt</th>
                        </tr>
                        @php($i=0)
                        @foreach($tarixold as $item)
                            <tr style="color: #051238; font-size: 20px; font-weight: bold">
                                <th>{{$loop->iteration}}</th>
                                @php($i+=1)
                                <th>{{$item->qarzdor->name}}</th>
                                <th>{{number_format($item->debt,0,'.',' ')}}</th>
                                <th>@if($item->debt > 0)
                                        <span class="badge bg-danger">Qarz berilgan</span>

                                    @else
                                        <span class="badge bg-success">Qarz to'langan</span>

                                    @endif</th>
                                <th>{{date("H:i:s",strtotime($item->created_at))}}</th>
                            </tr>
                        @endforeach
                        @foreach($tarix as $item)
                            <tr style="color: #051238; font-size: 20px; font-weight: bold">
                                <th>{{$loop->iteration +$i}}</th>
                                <th>{{$item->qarzdor->name}}</th>
                                <th>{{number_format($item->debt,0,'.',' ')}}</th>
                                <th>@if($item->debt > 0)
                                        <span class="badge bg-danger">Qarz berilgan</span>
                                    @else
                                        <span class="badge bg-success">Qarz to'langan</span>

                                    @endif</th>
                                <th>{{date("H:i:s",strtotime($item->created_at))}}</th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row overflow-auto">
        <div class="col-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="text-primary fw-bold m-0">Oxirgi 3 oy statistikasi</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr style="color: #ffffff; font-size: 20px; font-weight: bold; background-color: #22074d">
                            <th>T/R</th>
                            <th>Sana</th>
                            <th>Jami qarzlar</th>
                            <th>Qarz olindi</th>
                            <th>Qarz to'landi</th>
                            <th>Qarzdorlar soni</th>
                        </tr>

                        @foreach($stats as $item)
                            <tr style="color: #051238; font-size: 20px; font-weight: bold">
                                <th>{{$loop->iteration }}</th>
                                <th>{{$item->date}}</th>
                                <th>{{number_format($item->total_debt,0,'.',' ')}}</th>
                                <th>{{number_format($item->received_debt,0,'.',' ')}}</th>
                                <th>{{number_format($item->paid_debt,0,'.',' ')}}</th>
                                <th>{{$item->debtors_count}}</th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('izlash')
    <form action="{{route('statistika_custom')}}" class="form d-flex overflow-auto p-2 align-items-center" method="post">
        <label class="text-lg m-2  " for="sanain"> <span>Sana:</span></label>
        <input type="date" class="form-control m-2" required id="sanain" name="date">
        @csrf
        <button type="submit" class="btn btn-primary m-2 ">Ko'rish</button>
        <a href="{{route('balansim')}}" class="m-1 btn btn-outline-primary " > Balans</a>

    </form>

@endsection
@section('js')
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "So'nggi 15 kun"
                },
                axisX: {
                    valueFormatString: "DD MMM",
                    crosshair: {
                        enabled: true,
                        snapToDataPoint: true
                    }
                },
                axisY: {
                    title: "Qarz miqdori",
                    crosshair: {
                        enabled: true
                    }
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    verticalAlign: "bottom",
                    horizontalAlign: "left",
                    dockInsidePlotArea: true,
                    itemclick: toogleDataSeries
                },
                data: [{
                    type: "line",
                    showInLegend: true,
                    name: "Qarz olindi",
                    markerType: "square",
                    xValueFormatString: "DD MMM, YYYY",
                    color: "#F08080",
                    dataPoints: [
                            @foreach($stats as  $item)
                        @if($loop->iteration > 15) @break @endif
                        {x: new Date((new Date({{date('Y,m,d',strtotime($item->date))}})).setMonth((new Date({{date('Y,m,d',strtotime($item->date))}})).getMonth() - 1)), y: {{$item->received_debt}}},
                        @endforeach
                    ]
                },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "Qarz to'landi",
                        lineDashType: "dash",
                        dataPoints: [
                            @foreach($stats as $item)
                                @if($loop->iteration > 15) @break @endif
                            {x: new Date((new Date({{date('Y,m,d',strtotime($item->date))}})).setMonth((new Date({{date('Y,m,d',strtotime($item->date))}})).getMonth() - 1)), y: {{$item->paid_debt}}},
                           @endforeach
                        ]
                    }]
            });
            chart.render();
console.log(new Date((new Date({{date('Y,m,d',strtotime('2017-12-03'))}})).setMonth((new Date({{date('Y,m,d',strtotime('2017-12-03'))}})).getMonth() - 1)));
            function toogleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }

        }
    </script>

@endsection
