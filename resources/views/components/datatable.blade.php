@props(['menu'])
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-datatable table-responsive">
            <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">{{ $menu }}</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons">
                            <button type="button" class="dt-button btn btn-primary" id="create">
                                <span class="d-sm-inline-block">Tambah Data</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        {{ $slot }}
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
