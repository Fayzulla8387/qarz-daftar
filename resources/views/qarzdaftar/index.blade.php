@extends('master')
@section('izlash')

    <div class="d-flex align-items-center">
        <button data-bs-toggle="modal" data-bs-target="#modal_qarzdor_yaratish" type="button" class="btn m-1"
                style="color: #ffffff; background-color: #086f62"><i class="fa fa-user-plus">Yaratish</i></button>

        <div class="">
            <select id="izlash1" name="qarzdor">
                <option value="0" selected disabled>Qarzdor tanlang</option>

                @foreach($qarzdorlar as $qarzdor)
                    <option style="color: black; font-weight: bolder" value="{{$qarzdor['id']}}">{{$qarzdor['name']}}
                        - {{$qarzdor['phone']}}</option>

                @endforeach

                <option disabled value="">
                    ____________________________________________________________________________________
                </option>
            </select>
        </div>
    </div>
@endsection
@section('content')
    <div class="card" id="kattadiv"
         style="display: none; box-shadow: 0px 0px 5px 5px #c3c3ca; color: black; border-top: 5px solid #0b0b5b; border-bottom: 2px solid #0d0d54">
        <div class="card-header ">
            <div class="float-end">
                <div class="" style="">

                    <table>
                        <tr>
                            <th>
                                <button data-bs-toggle="modal" data-bs-target="#modal_qazberish"
                                        style="color: #ffffff;background-color: #1157c1;font-weight: bolder"
                                        type="button" class="btn m-1"><i class="fas fa-plus"></i> Qarz berish
                                </button>
                            </th>
                            <th>
                                <form action="{{route('tarix')}}" method="post"> @csrf
                                    <input type="hidden" name="qarzdor_id" class="qarzdor_id" value="">
                                    <button style="color: #ffffff;background-color: #4f3c71;font-weight: bolder"
                                            type="submit" class="btn  m-1"><i class="fa fa-file"></i> Tarix
                                    </button>
                                </form>
                            </th>
                         @if(\Illuminate\Support\Facades\Auth::user()->role=='admin')
                                <th>
                                    <button data-bs-toggle="modal" data-bs-target="#modal_qarzdor_tahrirlash"
                                            style="color: #ffffff;background-color: #037ea4;font-weight: bolder"
                                            type="button" class="btn m-1"><i class="fas fa-pen"></i> Tahrirlash
                                    </button>

                                </th>
                                <th>
                                    <button data-bs-toggle="modal" data-bs-target="#modal_qazbuzish"
                                            style="color: black;background-color: #e1bf07;font-weight: bolder" type="button"
                                            class="btn  m-1"><i class="fa fa-credit-card"></i> Qarz uzish
                                    </button>

                                </th>


                            @endif
                            <th>
                                <form id="form1" action="{{route('bitta-sms-jonat')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="qarzdor_id" class="qarzdor_id" value="">
                                    <button style="color: #ffffff;background-color: #0b0b5b;font-weight: bolder"
                                            type="submit" class="btn m-1"><i class="fa fa-paper-plane"></i> SMS
                                    </button>
                                </form>
                            </th>
                        </tr>
                    </table>

                </div>


            </div>

            <div class="">
                <h3><span style="font-weight: bold; color: #0b0b5b" id="ism_d"></span>ning qarzdorlik ma'lumoti</h3>
            </div>
        </div>
        <div class="card-body ">
            <div class="table-responsive">
                <table class="table hover-active  table-bordered" style="color: black;">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Telefon raqami</th>
                        <th scope="col">Qarz miqdori</th>
                        <th scope="col">Kutilayotgan qaytarish muddati</th>
                        <th scope="col">Korxona</th>
                        <th scope="col">Holati</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td id="telefon_d"></td>
                        <td id="qarz_d"></td>
                        <td id="muddat_d"></td>
                        <td id="korxona_id"></td>
                        <td id="holat_d" style="color: #0b7b08; font-weight: bold">
                        </td>
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>

        <div class="card-footer"><span style=" font-size: 20px;font-weight: bolder; color: #4d1111" id="eslatma"></span>
        </div>
    </div>

    <div class="card overflow-auto mt-5"
         style="box-shadow: 0px 0px 5px 5px #c3c3ca; color: black; border-top: 5px solid #0b0b5b; border-bottom: 2px solid #0d0d54">
        <div class="card-header ">
            <div class="d-flex justify-content-between">
                <h3> Bugun qarzini qaytarishi kerak bo'lgan qarzdorlar</h3>

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table hover-active  table-bordered" style="color: black;">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">T/R</th>
                        <th scope="col">Ismi</th>
                        <th scope="col">Telefon raqami</th>
{{--                        <th scope="col">Korxonasi</th>--}}
                        <th scope="col">Qarz miqdori</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bugungi_qarzdorlar as $key=>$bugun_q)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$bugun_q->name}}</td>
                            <td>{{($bugun_q->phone)}}</td>
{{--                            <td>{{($bugun_q->korxona ? $bugun_q->korxona->name : '')}}</td>--}}
                            <td>{{number_format($bugun_q->debt,0,'.',' ')}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>

        <div class="card-footer"><span style=" font-size: 20px;font-weight: bolder; color: #4d1111" id="eslatma"></span>
        </div>
    </div>

    <!-- Modal Qarz berish -->
    <div class="modal fade" id="modal_qazberish" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div style="border-top: 4px solid #0b0b5b;border-bottom: 4px solid #0b0b5b" class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title " id="exampleModalLabel">Qarz berish</h1>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('qarz_berish')}}" method="post">
                        @csrf
                        <input type="hidden" name="qarzdor_id" class="qarzdor_id" value="">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Qarz miqdori:</label>
                            <input type="number" name="qarz_miqdori" required class="form-control"
                                   id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Izoh:</label>
                            <input type="text" name="izoh" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Qaytarish muddati:</label>
                            <input type="date" name="qaytarish_muddati" required class="form-control qaytarish_muddati"
                                   id="exampleInputEmail1">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                            <button type="submit" class="btn "
                                    style="background-color: #0d0d54; color: white; font-weight: bolder"><i
                                    class="fa fa-save"></i> Saqlash
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal Qarz uzish -->
    <div class="modal fade" id="modal_qazbuzish" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div style="border-top: 4px solid #0b0b5b;border-bottom: 4px solid #0b0b5b" class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title " id="exampleModalLabel">Qarz uzish</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('qarz_uzish')}} " method="post">
                        @csrf
                        <input type="hidden" name="qarzdor_id" class="qarzdor_id" value="">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Qarz miqdori:</label>
                            <input type="number" name="qarz_miqdori" required class="form-control"
                                   id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Izoh:</label>
                            <input type="text" name="izoh" class="form-control" id="exampleInputEmail1">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                            <button type="submit" class="btn btn-primary"
                                    style="background-color: #0d0d54; color: white; font-weight: bolder"><i
                                    class="fa fa-save"></i> Saqlash
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal qarzdor yaratish -->
    <div class="modal fade" id="modal_qarzdor_yaratish" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div style="border-top: 4px solid #0b0b5b;border-bottom: 4px solid #0b0b5b" class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title " id="exampleModalLabel">Qarzdor yaratish</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('qarzdor_yaratish')}}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="1">
                        <div class="mb-3">
                            <label for="korxona_id" class="form-label">Tashkilot:</label>
                            <select name="korxona_id" class="form-control" id="korxona_id">
                                <option value="">Korxona tanlang</option>
                                @foreach($korxonalar as $korxona)
                                    <option value="{{ $korxona->id }}">{{ $korxona->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Ism:</label>
                            <input type="text" name="name" value="{{old('name')}}" required class="form-control"
                                   id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Telefon raqam:</label>
                            <input type="number" name="phone" value="{{old('phone')}}" required class="form-control"
                                   id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Qarz miqdori:</label>
                            <input type="number" name="debt" value="{{old('debt')}}" required class="form-control"
                                   id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Izoh:</label>
                            <input type="text" name="caption" value="{{old('caption')}}" class="form-control"
                                   id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Qaytarish muddati:</label>
                            <input type="date" name="return_date" value="{{old('return_date')}}" required
                                   class="form-control" id="exampleInputEmail1">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                            <button type="submit" class="btn btn-primary"
                                    style="background-color: #0d0d54; color: white; font-weight: bolder"><i
                                    class="fa fa-save"></i> Saqlash
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal qarzdor tahrirlash -->
    <div class="modal fade" id="modal_qarzdor_tahrirlash" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div style="border-top: 4px solid #0b0b5b;border-bottom: 4px solid #0b0b5b" class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title " id="exampleModalLabel">Qarzdorni tahrirlash</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('qarzdor_tahrirlash') }}" method="post">
                        @csrf
                        <input type="hidden" name="qarzdor_id" class="qarzdor_id" value="">
                        <div class="mb-3">
                            <label for="edit_ism" class="form-label">Ism:</label>
                            <input type="text" name="ism" required class="form-control" id="edit_ism">
                        </div>
                        <div class="mb-3">
                            <label for="korxona_id" class="form-label">Tashkilot:</label>
                            <select name="korxona_id" class="form-control" id="korxona_id">
                                <option value="">Korxona yo'q</option>
                                @foreach($korxonalar as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">

                            <label for="edit_tel" class="form-label">Telefon raqam:</label>
                            <input type="number" name="telefon" required class="form-control" id="edit_tel">
                        </div>
                        <div class="mb-3">
                            <label for="edit_limit" class="form-label">Limit:</label>
                            <input type="number" name="limit" class="form-control" id="edit_limit">
                        </div>
                        <div class="mb-3">
                            <label for="editing_status" class="form-label">Status:</label>
                            <select name="status_edit" class="form-control" id="editing_status">
                                <option value="1">Omonatdor</option>
                                <option value="2">Omonatdor emas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_izoh" class="form-label">Alohida izoh:</label>
                            <input type="text" name="izoh" class="form-control" id="edit_izoh">
                        </div>
                        <div class="mb-3">
                            <label for="qaytarish_muddati" class="form-label">Qaytarish muddati:</label>
                            <input type="date" name="qaytarish_muddati" required class="form-control qaytarish_muddati"
                                   id="qaytarish_muddati">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                            <button type="submit" class="btn btn-primary"
                                    style="background-color: #0d0d54; color: white; font-weight: bolder"><i
                                    class="fa fa-save"></i> Saqlash
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function () {

            $('#izlash1').val(0);
            @if(session('t_qarzdor_id'))

            $('#kattadiv').css('display', 'block');
            var izlash1 = {{session('t_qarzdor_id')}};
            $.ajax({
                type: "GET",
                url: "/qarzdor/" + izlash1,
                success: function (response) {
                    printData(response);
                }
            });
            @endif

            $('#izlash1').on('change', (function () {
                $('#kattadiv').css('display', 'block');
                var izlash1 = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "/qarzdor/" + izlash1,
                    success: function (response) {
                        printData(response);
                    }
                });
            }));
        });

        function printData(qarzdor) {
            $('#ism_d').text(qarzdor['name']);
            $('#nomer_id').text('1');
            $('.qarzdor_id').val(qarzdor['id']);
            $('#edit_ism').val(qarzdor['name']);
            $('#edit_tel').val(qarzdor['phone']);
            $('#edit_limit').val(qarzdor['limit']);
            $('#edit_izoh').val(qarzdor['caption']);
            if (qarzdor['caption'] != null) {
                $('#eslatma').text('Eslatma: ' + qarzdor['caption']);
            }
            if (qarzdor['status'] == 1) {
                $('#editing_status').val(1);
            } else {
                $('#editing_status').val(2);
            }
            $('.qaytarish_muddati').val(qarzdor['return_date']);

            qarzdor['phone'] = '' + qarzdor['phone'];
            $('#telefon_d').text(qarzdor['phone'][0] + qarzdor['phone'][1] + '-' + qarzdor['phone'][2] + qarzdor['phone'][3] + qarzdor['phone'][4] + '-' + qarzdor['phone'][5] + qarzdor['phone'][6] + '-' + qarzdor['phone'][7] + qarzdor['phone'][8]);
            var a = parseInt(qarzdor['debt']);
            $('#qarz_d').text((a.toLocaleString()).replaceAll(',', ' ') + ' so\'m');
            $('#muddat_d').text(qarzdor['return_date']);

            // Korxona ma'lumotlarini ko'rsatish
            if (qarzdor.korxona) {
                $('#korxona_id').text(qarzdor.korxona.name); // Korxona nomini ko'rsatish
            } else {
                $('#korxona_id').text('Korxona ma\'lum emas'); // Agar korxona bo'lmasa
            }

            if (qarzdor['status'] == 1) {
                $('#holat_d').text('Omonatdor');
                $('#holat_d').css('color', '#0b7b08');
            } else {
                $('#holat_d').text('Omonatdor emas');
                $('#holat_d').css('color', '#ff0000');
            }
        }
    </script>
@endsection
