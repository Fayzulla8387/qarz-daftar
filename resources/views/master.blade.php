<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PlusMarket</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('select2/theme.default.min.css')}}">
    <style>  @yield('css')</style>


</head>

<body id="page-top" class="overflow-auto" style="">
<div id="wrapper">
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion p-0"
         style="background-color: #051238">
        <div class="container-fluid d-flex flex-column p-0"><a href="{{route('dashboard')}}"
                                                               class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0">
                <div class="sidebar-brand-icon"><img class="rounded-circle" alt="logo"
                                                     src="{{asset('assets/img/logo.jpg')}}" data-holder-rendered="true"
                                                     style="width: 50px; height: 50px;"></div>
                <div class="sidebar-brand-text mx-2"><span style="font-size: 18px;">Demo</span></div>
            </a>
            <hr class="sidebar-divider my-1" style="width:88%; border: 1px solid white">
            <ul class="navbar-nav text-light " id="accordionSidebar" style="font-size: 100px;">

                <li class="nav-item "><a class="nav-link @if(request()->routeIs('dashboard')) active @endif   "
                                         href="{{route('dashboard')}}"><i style="font-size: 20px;"
                                                                          class=" fas fa-tachometer-alt"></i><span
                            style="font-size: 18px;">Statistika</span></a></li>
                <li class="nav-item"><a class="nav-link @if(request()->routeIs('qarzdaftar')) active @endif"
                                        href="{{route('qarzdaftar')}}"><i style="font-size: 20px;"
                                                                          class="fas fa-book"></i><span
                            style="font-size: 18px;">Qarz daftar</span></a></li>
{{--                <li class="nav-item"><a class="nav-link @if(request()->routeIs('madrasa_qarzlar')) active @endif"--}}
{{--                                        href="{{route('madrasa_qarzlar')}}"><i style="font-size: 20px;"--}}
{{--                                                                               class="fas fa-book"></i><span--}}
{{--                            style="font-size: 18px;">Madrasa qarzlar</span></a></li>--}}
                <li class="nav-item"><a class="nav-link @if(request()->routeIs('royhat')) active @endif"
                                        href="{{route('royhat')}}"><i style="font-size: 20px;" class="fas fa-table"></i><span
                            style="font-size: 18px;">Ro'yhat</span></a></li>
                <li class="nav-item"><a class="nav-link @if(request()->routeIs('sms')) active @endif"
                                        href="{{route('sms')}}"><i style="font-size: 20px;" class="fas fa-sms"></i><span
                            style="font-size: 18px;">Sms</span></a></li>
            </ul>
            <div class="text-center d-none d-md-inline">
                <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
            </div>
        </div>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i
                            class="fas fa-bars"></i></button>
                    @yield('izlash')
                    <ul class="navbar-nav flex-nowrap ms-auto">


                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                                                       aria-expanded="false" data-bs-toggle="dropdown"
                                                                       href="#"><span
                                        class="d-none d-lg-inline me-2 text-gray-600 small">{{auth()->user()->name}}</span><img
                                        class="border rounded-circle img-profile"
                                        src="{{asset('assets/img/logo2.png')}}"></a>
                                <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                    <a class="dropdown-item" href="{{route('profile')}}"><i
                                            class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Sozlamalar</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{route('logout')}}" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i
                                                class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Chiqish
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright">
                    @if(date('Y') == 2022)
                        <span>Copyright © Plusmarket {{date('Y')}}
                            @else
                                <span>Copyright © Plusmarket 2022 - {{date('Y')}}
                                    @endif</span>
                        </span></div>
            </div>
        </footer>
    </div>


    <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
</div>
<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/chart.min.js')}}"></script>
<script src="{{asset('assets/js/bs-init.js')}}"></script>
<script src="{{asset('assets/js/theme.js')}}"></script>
<script src="{{asset('select2/jquery.min.js')}}"></script>
<script src="{{asset('select2/select2.min.js')}}"></script>
<script src="{{asset('select2/jquery.tablesorter.min.js')}}"></script>
<script src="{{asset('select2/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('select2/canvasjs.min.js')}}"></script>
<script>

    function incrAllFontSize() {
        $("*").each(function (index, elem) {
            var $this = $(this);//caching for perf. opt.

            var curr = $this.css("fontSize");//get the fontSize string
            if (curr != "" && curr != undefined) {//check if it exist
                curr = curr.replace(/px$/, "");//get rid of "px" in the string

                var float_curr = parseFloat(curr);//convert string to float
                float_curr += 1//actual incr

                var new_val = "" + float_curr + "px";//back to string
                $this.css("fontSize", new_val);//set the fontSize string
            }
        });
    }

    $(document).ready(function () {
        $('#izlash1').select2({width: 'resolve'});
        $('#table1').tablesorter();
        incrAllFontSize();

    });
</script>

@yield('js')
<script>
    let errors = @json($errors->all());
    @if($errors->any())
    console.log(errors);
    let msg = '';
    for (let i = 0; i < errors.length; i++) {
        msg += (i + 1) + '-xatolik ' + errors[i] + '\n';
        // msg += errors[i] + '\n';
    }
    console.log(msg);
    if (msg != '') {
        Swal.fire({
            icon: 'error',
            title: 'Xatolik',
            text: msg,
            confirmButtonText: 'ok',
        })
    }
    @endif
</script>
@if(session('success'))

    <script>
        var msg = @json(session('success'));
        Swal.fire({
            icon: 'success',
            text: msg,
            confirmButtonText: 'ok',
        })
    </script>
@endif
<style>
    input {
        height: 40px;
        font-size: 25px;
        color: black;
        font-weight: bolder;
    }

    input:focus {
        border: 2px solid #0b2e13;
        box-shadow: 0 0 10px #719ECE;
        color: #0e6042;
        font-weight: bolder;
    }

    input[type='text'] {
        height: 50px;
        font-size: 30px;
        color: black;
        font-weight: bolder;
    }

    input[type='text']:focus {
        border: 2px solid #0b2e13;
        box-shadow: 0 0 10px #719ECE;
        color: #0e6042;
        font-weight: bolder;
    }

    input[type='number']:focus {
        border: 2px solid #0b2e13;
        box-shadow: 0 0 10px #719ECE;
        color: #0e6042;
        font-weight: bolder;
    }

    input[type='date']:focus {
        border: 2px solid #0b2e13;
        box-shadow: 0 0 10px #719ECE;
        color: #0e6042;
        font-weight: bolder;
    }

    input[type='number'] {
        height: 50px;
        font-size: 30px;
        color: black;
        font-weight: bolder;
    }

    input[type='date'] {
        height: 50px;
        font-size: 30px;
        color: black;
        font-weight: bolder;
    }

    body {
        color: black;
        font-weight: bolder;
    }

</style>
</body>

</html>
