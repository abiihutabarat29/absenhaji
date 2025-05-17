@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-lg-12 order-0">
            @if ($tugas->isNotEmpty())
                <div class="row mb-5">
                    @foreach ($tugas as $item)
                        @php
                            $statusSelesai = $konfirmasi[$item->id] ?? 0;
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body mb-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title mb-1">{{ $item->title }}</h5>
                                        @if ($statusSelesai == 1)
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum Selesai</span>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1 mb-2">
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</small>
                                    </div>
                                    <p class="card-text">{{ $item->keterangan }}</p>
                                    @if (Auth::user()->role == 1)
                                        <a href="{{ route('absensi.check', Crypt::encrypt($item->id)) }}"
                                            class="btn btn-primary">Lihat</a>
                                    @else
                                        @if ($statusSelesai == 1)
                                            <a href="{{ route('absensi.check', Crypt::encrypt($item->id)) }}"
                                                class="btn btn-primary">Lihat</a>
                                        @else
                                            <a href="{{ route('absensi.check', Crypt::encrypt($item->id)) }}"
                                                class="btn btn-primary">Kerjakan</a>
                                        @endif
                                    @endif
                                </div>
                                <footer class="blockquote-footer">
                                    dibuat oleh : Bapak {{ $item->user->name }}
                                </footer>
                            </div>
                        </div>
                    @endforeach
                    @if (Auth::user()->role == 1)
                        <div class="buy-now">
                            <button type="button" class="dt-button btn btn-primary btn-buy-now" id="create">Buat
                                Tugas</button>
                        </div>
                    @endif
                </div>
            @else
                @if (Auth::user()->role == 1)
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-warning text-center text-danger" role="alert">
                                Belum ada tugas ...
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <button type="button" class="dt-button btn btn-primary" id="create">Buat Tugas</button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-warning text-center text-danger" role="alert">
                                Belum ada tugas ...
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
@section('modal')
    <x-modal size="">
        <x-input type="text" name="title" label="Judul" opsi="true"></x-input>
        <x-textarea name="keterangan" label="Keterangan" opsi="true"></x-textarea>
    </x-modal>
@endsection
@section('script')
    <script type="text/javascript">
        // Create
        var createHeading = "{{ $menu }}";
        createModel(createHeading);

        // Save
        saveBtn("{{ route('absensi.store') }}");

        // Edit
        var editUrl = "{{ route('absensi.index') }}";
        var editHeading = "Perbaharui Tugas";
        var field = ['title'];
        editModel(editUrl, editHeading, field);
    </script>
@endsection
