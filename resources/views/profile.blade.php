@extends('master')
@section('content')
<div class="card" style="padding: 15px; box-shadow: 0px 0px 10px 10px #d7d4d4">
    <h2 class="text text-primary">Ma'lumotlarni o'zgartirish</h2>
    <form action="{{route('profile_update')}}" class="form" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Do'kon nomi:</label>
            <input type="text" name="name" value="{{$dukon->name}}" required class="form-control" id="">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email:</label>
            <input type="email" name="email" value="{{$dukon->email}}" required class="form-control" id="">
        </div>
        <h3 class="text text-primary">Parolni o'zgaritish</h3>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Hozirgi parol:</label>
            <input type="text" name="parol_current" value="{{old('parol_current')}}" required class="form-control" id="">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Yangi parol:</label>
            <input type="text" name="parol_new_1" value="{{old('parol_new_1')}}"  class="form-control" id="">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Yangi parolni qayta kiriting:</label>
            <input type="text" name="parol_new_2" value="{{old('parol_new_2')}}"  class="form-control" id="">
        </div>
        <button type="submit" class="btn btn-primary">Saqlash</button>

    </form>

</div>
@endsection
