<div class="container-xxl mt-3">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Filter</h5>
            <hr class="m-0">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-10">
                            {{ $slot }}
                        </div>
                        <div class="col-md-2">
                            <div class="mt-1">
                                <div class="dt-buttons">
                                    <button type="button" class="dt-button btn btn-warning mt-4" id="exportPdf">
                                        <span class="d-sm-inline-block">Export PDF</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
