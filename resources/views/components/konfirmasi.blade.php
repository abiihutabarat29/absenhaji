<!-- Modal Delete -->
<div class="modal fade" id="modal-konfirmasi" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bxs-info-circle text-danger"></i> Mohon Perhatian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr class="m-2">
            <div class="modal-body">
                <div class="divider m-0 mb-3">
                    <div class="divider-text">Baca terlebih dahulu</div>
                </div>
                <li>Pastikan jumlah suara sah & jumlah suara tidak sah sudah sesuai dengan C1.</li>
                <li>Pastikan jumlah suara masuk sesuai dengan jumlah DPT atau tidak melebihi jumlah DPT pada TPS
                    tersebut.</li>
                <li>Pastikan kolom Cek Suara bernilai TRUE, jika masih FALSE, silahkan periksa dan edit kembali jumlah
                    suara dengan benar.</li>
                <li>Cek suara berstatus TRUE artinya jumlah suara masuk sudah sesuai dengan jumlah DPT atau tidak
                    melebihi jumlah DPT pada TPS tersebut, begitupun sebaliknya jika suara berstatus FALSE artinya
                    jumlah suara masuk tidak sesuai dengan jumlah DPT atau tidak
                    melebihi jumlah DPT pada TPS tersebut.
                </li>
                <li>Jika sudah yakin jumlah suara sah dan jumlah suara tidak sah sesuai dengan C1,
                    silahkan KONFIRMASI.</li>
                <li>Dengan menekan tombol KONFIRMASI, berarti anda sudah yakin data yang anda inputkan sudah benar dan
                    dapat dipertanggungjawabkan.</li>
                <li>Jika KONFIRMASI berhasil, maka data tidak akan bisa diubah kembali, tombol EDIT, DELETE
                    tidak akan tersedia lagi.</li>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tidak Dulu
                </button>
                <button type="button" class="btn btn-success" id="konfirmasiBtn">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>
