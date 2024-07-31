@extends('master')
@section('content')
    <div class="card " style="box-shadow: 0px 0px 5px 5px #bdbdc0;border-top: 5px solid #0b136f; border-bottom: 5px solid #0b136f">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title " style="color: black; font-weight: bold">Yuborilgan SMSlar</h3>
            <button data-bs-toggle="modal" data-bs-target="#modal_reklama_sms" class="btn m-1" style="background-color: #0b136f; color: white"><i class="fa fa-paper-plane"></i> Reklama SMS yuborish </button>
        </div>
        <div class="card-body">
            <table class="table table-borederd border-1">
                <thead style="background-color: #0e1574; font-style: italic; color: white; font-weight: bolder"> <tr>
                    <th>T/R</th>
                    <th>Telefon raqam</th>
                    <th>Xabar turi</th>
                    <th>Holati</th>
                    <th>Sana</th>
                </tr>
                </thead>
                <tbody style="color: black; font-weight: bold">
                @foreach($smslar as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->phone}}</td>
                        <td>{{$item->text}}</td>
                        @if($item->status == 'DELIVRD')
                            <td><span class="badge bg-success">Yuborildi</span></td>
                        @elseif($item->status == 'waiting')
                            <td><span class="badge bg-warning">Kutilmoqda</span></td>
                        @else
                            <td><span class="badge bg-danger">Yuborilmadi {{$item->status}} </span></td>
                        @endif
                        <td>{{$item->created_at}}</td>
                    </tr>
                @endforeach


                </tbody>
                <tfoot>



                </tfoot>
            </table>
            {{$smslar->links()}}
            <div class="modal fade" id="modal_reklama_sms" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Reklama SMS yuborish</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('reklama_sms')}}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Telefon raqami:</label>
                                    <input type="number" required name="telefon_nomer" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                                    <button type="submit" class="btn btn-primary">Yuborish</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
