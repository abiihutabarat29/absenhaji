@props(['menu', 'user', 'online', 'jadwal'])
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-datatable table-responsive">
            <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">{{ $menu }} <span
                                class="badge bg-label-primary">{{ $online }} / {{ $user }}</span>
                        </h5>
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
