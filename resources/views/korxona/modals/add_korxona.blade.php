
<!-- Add Korxona Modal -->
<div class="modal fade" id="addKorxonaModal" tabindex="-1" role="dialog" aria-labelledby="addKorxonaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKorxonaModalLabel">Yangi Tashkilot Qo'shish</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('korxona.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="korxona_name">Tashkilot Nomi</label>
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
