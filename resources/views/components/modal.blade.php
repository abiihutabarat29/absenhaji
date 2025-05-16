<!-- Modal -->
@props(['size'])
<div class="modal fade" id="ajaxModel" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog {{ $size }}">
        <form id="ajaxForm" name="ajaxForm" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr class="m-0 mt-2">
            <div class="modal-body">
                <div class="alert alert-danger" role="alert" style="display: none;"></div>
                <input type="hidden" name="hidden_id" id="hidden_id">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Kembali
                </button>
                <button type="button" class="btn btn-primary" id="saveBtn">Simpan</button>
            </div>
        </form>
    </div>
</div>
