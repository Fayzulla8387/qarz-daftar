@extends('master')
@section('content')

    <div class="card overflow-auto mt-5" style="box-shadow: 0px 0px 5px 5px #c3c3ca; color: black; border-top: 5px solid #0b0b5b; border-bottom: 2px solid #0d0d54">
        <div class="card-header ">
            <div class="d-flex justify-content-between">
                <h3>Barcha Korxona va Tashkilotlar ro'yhati</h3>
                <button class="btn btn-success" data-toggle="modal" data-target="#addKorxonaModal">Korxona Qo'shish</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table hover-active table-bordered" style="color: black;">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">T/R</th>
                        <th scope="col">Korxona nomi</th>
                        <th scope="col">Qarz miqdori</th>
                        <th scope="col">Amallar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($korxona as $key => $k)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td><a href="">{{ $k->name }}</a></td>
                            <td>  {{ $k->totalDebt() }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-id="{{ $k->id }}" data-name="{{ $k->name }}" data-toggle="modal" data-target="#editKorxonaModal" onclick="populateEditForm('{{ $k->id }}', '{{ $k->name }}')">Tahrirlash</button>
                                <form action="{{ route('korxona.destroy', $k->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Siz rostdan ham ushbu korxonani oʻchirmoqchimisiz?')">O'chirish</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <span style="font-size: 20px; font-weight: bolder; color: #4d1111" id="eslatma"></span>
        </div>
    </div>

    <!-- Add Korxona Modal -->
    <div class="modal fade" id="addKorxonaModal" tabindex="-1" role="dialog" aria-labelledby="addKorxonaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addKorxonaModalLabel">Yangi Korxona Qo'shish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('korxona.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="korxona_name">Korxona Nomi</label>
                            <input type="text" class="form-control" id="korxona_name" name="korxona_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Korxona Modal -->
    <div class="modal fade" id="editKorxonaModal" tabindex="-1" role="dialog" aria-labelledby="editKorxonaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKorxonaModalLabel">Korxona Tahrirlash</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <form id="editKorxonaForm" action="{{ route('korxona.update', ['korxona' => 0]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_korxona_id" name="korxona_id">
                        <div class="form-group">
                            <label for="edit_korxona_name">Korxona Nomi</label>
                            <input type="text" class="form-control" id="edit_korxona_name" name="korxona_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

    <script>
        function populateEditForm(id, name) {
            document.getElementById('editKorxonaForm').action = '/korxona/' + id;
            document.getElementById('edit_korxona_id').value = id;
            document.getElementById('edit_korxona_name').value = name;
        }
    </script>
