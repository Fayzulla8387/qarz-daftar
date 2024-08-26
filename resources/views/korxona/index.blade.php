@extends('master')
@section('content')

    <div class="card overflow-auto mt-5" style="box-shadow: 0px 0px 5px 5px #c3c3ca; color: black; border-top: 5px solid #0b0b5b; border-bottom: 2px solid #0d0d54">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Barcha Tashkilotlar ro'yhati</h3>
                <button class="btn btn-success" data-toggle="modal" data-target="#addKorxonaModal">Tashkilot Qo'shish</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table hover-active table-bordered" style="color: black;">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">T/R</th>
                        <th scope="col">Tashkilot nomi</th>
                        <th scope="col">Qarz miqdori</th>
                        <th scope="col">Amallar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($korxona as $key => $k)
                        <tr id="korxona-{{ $k->id }}" data-id="{{ $k->id }}">
                            <td>{{ $loop->index + 1 }}</td>
                            <td><a href="javascript:void(0);" onclick="loadQarzdorlar({{ $k->id }})">{{ $k->name }}</a></td>
                            <td>{{ $k->totalDebt() }}</td>
                          @if(\Illuminate\Support\Facades\Auth::user()->role=='admin')
                                <td>
                                    <button class="btn btn-primary btn-sm" data-id="{{ $k->id }}" data-name="{{ $k->name }}" data-toggle="modal" data-target="#editKorxonaModal" onclick="populateEditForm('{{ $k->id }}', '{{ $k->name }}')">Tahrirlash</button>
                                    <form action="{{ route('korxona.destroy', $k->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Siz rostdan ham ushbu korxonani oʻchirmoqchimisiz?')">O'chirish</button>
                                    </form>
                                </td>

                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="qarzdorlarList" class="mt-4"></div>
        </div>
        <div class="card-footer">
            <span style="font-size: 20px; font-weight: bolder; color: #4d1111" id="eslatma"></span>
        </div>
    </div>

    @include('korxona.modals.add_korxona')
    @include('korxona.modals.edit_korxona')

@endsection

<style>
    .selected-row {
        background-color: #c3e6cb !important;
    }
</style>

<script>
    let selectedRow = null;

    function populateEditForm(id, name) {
        document.getElementById('editKorxonaForm').action = '/korxona/' + id;
        document.getElementById('edit_korxona_id').value = id;
        document.getElementById('edit_korxona_name').value = name;
    }

    function loadQarzdorlar(id) {
        // Remove the selected class from the previously selected row
        if (selectedRow !== null) {
            selectedRow.classList.remove('selected-row');
        }

        // Add the selected class to the clicked row
        selectedRow = document.querySelector(`[data-id="${id}"]`);
        selectedRow.classList.add('selected-row');

        fetch(`/korxona/${id}/qarzdorlar`)
            .then(response => response.json())
            .then(data => {
                let html = `<h4>Qarzdorlar Ro'yhati</h4>`;
                html += '<table class="table table-bordered">';
                html += '<thead><tr><th>ID</th><th>Ism</th><th>Telefon</th><th>Qarz miqdori</th><th>Qaytarish muddati</th></tr></thead><tbody>';
                data.forEach(qarzdor => {
                    html += `<tr>
                        <td>${qarzdor.id}</td>
                        <td>${qarzdor.name}</td>
                        <td>${qarzdor.phone}</td>
                        <td>${qarzdor.debt}</td>
                        <td>${qarzdor.return_date}</td>
                    </tr>`;
                });
                html += '</tbody></table>';
                document.getElementById('qarzdorlarList').innerHTML = html;
            });
    }
</script>
