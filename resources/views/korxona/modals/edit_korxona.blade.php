

<!-- Edit Korxona Modal -->
<div class="modal fade" id="editKorxonaModal" tabindex="-1" role="dialog" aria-labelledby="editKorxonaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKorxonaModalLabel">Tashkilotni Tahrirlash</h5>
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
                        <label for="edit_korxona_name">Tashkilot Nomi</label>
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
