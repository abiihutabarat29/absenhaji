@extends('layouts.app')
@section('content')
    <form id="ajaxForm" class="form-horizontal">
        @csrf
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-lg-12 order-0">
                <div class="card">
                    <h5 class="card-header">DAFTAR HADIR - {{ strtoupper($tugas->title) }}</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless border-bottom">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" style="width:5%">No</th>
                                    <th class="text-nowrap">Nama</th>
                                    <th class="text-nowrap text-center">Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peserta as $item)
                                    @php
                                        $absen = $absensis->firstWhere('peserta_id', $item->id);
                                        $konfirmasi = \App\Models\KonfirmasiTugas::where('tugas_id', $tugas->id)
                                            ->where('user_id', Auth::id())
                                            ->first();

                                        $isSelesai = $konfirmasi && $konfirmasi->status == 1;
                                    @endphp
                                    <tr>
                                        <td class="text-nowrap">{{ $loop->iteration }}</td>
                                        <td class="text-nowrap">{{ $item->name }}</td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox"
                                                    name="absensi[{{ $item->id }}]" value="1"
                                                    {{ $absen && $absen->status ? 'checked' : '' }}
                                                    {{ $isSelesai || Auth::user()->role == 1 ? 'disabled' : '' }}>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mt-4">
                                @if (Auth::user()->role == 2 && !$isSelesai)
                                    <button type="submit" class="btn btn-primary me-2" id="submitBtn">
                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                            aria-hidden="true"></span>
                                        <span class="btn-text">Simpan</span>
                                    </button>
                                    <button type="button" class="btn btn-success me-2" id="selesaiBtn">
                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                            aria-hidden="true"></span>
                                        <span class="btn-text">Selesai</span>
                                    </button>
                                @endif
                                <a href="{{ route('absensi.index') }}" class="btn btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#ajaxForm').on('submit', function(e) {
                e.preventDefault();

                var $submitBtn = $('#submitBtn');
                var $spinner = $submitBtn.find('.spinner-border');
                var $btnText = $submitBtn.find('.btn-text');

                $spinner.removeClass('d-none');
                $btnText.css('display', 'none');

                $.ajax({
                    url: "{{ route('absensi.absen.store', $tugas->id) }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            alertToastr(response.success);
                        }
                        $spinner.addClass('d-none');
                        $btnText.css('display', 'inline');

                        setTimeout(function() {
                            window.location.href = "{{ route('absensi.index') }}";
                        }, 1500);
                    },
                    error: function(response) {
                        $spinner.addClass('d-none');
                        $btnText.css('display', 'inline');
                        $('.text-danger').text('');

                        const res = response.responseJSON;

                        if (res?.errors) {
                            $.each(res.errors, function(key, value) {
                                let field = key + '-error';
                                $('.' + field).text(value[0]);

                                setTimeout(function() {
                                    $('.' + field).text('');
                                }, 3000);
                            });
                        } else if (res?.error) {
                            alertToastrError(res.error, 'error');
                        } else {
                            alertToastrError('Terjadi kesalahan yang tidak diketahui.',
                                'error');
                        }
                    }

                });
            });

            $('#selesaiBtn').on('click', function() {
                var $selesaiBtn = $(this);
                var $spinner = $selesaiBtn.find('.spinner-border');
                var $btnText = $selesaiBtn.find('.btn-text');

                $spinner.removeClass('d-none');
                $btnText.css('display', 'none');

                $.ajax({
                    url: "{{ route('absensi.konfirmasi', $tugas->id) }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.success) {
                            alertToastr(response.success);
                            setTimeout(function() {
                                window.location.href = "{{ route('absensi.index') }}";
                            }, 1500);
                        }

                        $spinner.addClass('d-none');
                        $btnText.css('display', 'inline');
                    },
                    error: function(response) {
                        $spinner.addClass('d-none');
                        $btnText.css('display', 'inline');

                        const res = response.responseJSON;
                        if (res?.error) {
                            alertToastrError(res.error);
                        } else {
                            alertToastrError('Terjadi kesalahan saat konfirmasi tugas.');
                        }
                    }
                });
            });

        });
    </script>
@endsection
