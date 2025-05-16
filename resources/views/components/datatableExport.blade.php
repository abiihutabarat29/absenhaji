@props(['menu', 'jadwal'])
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-datatable table-responsive">
            <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">{{ $menu }}</h5>
                    </div>
                </div>
            </div>
            <table class="table table-striped" id="datatable">
                {{ $slot }}
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
