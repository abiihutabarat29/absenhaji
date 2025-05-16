@extends('layouts.app')
@section('content')
    <x-datatable link="javascript:void(0)" menu="{{ $menu }}">
        <th style="width:5%">No</th>
        <th style="width:20%">Kelompok</th>
        <th>Nama</th>
        <th class="text-center" style="width: 15%">Action</th>
    </x-datatable>
@endsection
@section('modal')
    <x-modal size="">
        <x-dropdown name="kelompok_id" label="Kelompok" opsi="true">
            @foreach ($kelompok as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
            @endforeach
        </x-dropdown>
        <x-input type="text" name="name" label="Nama" opsi="true"></x-input>
    </x-modal>
    <x-delete></x-delete>
@endsection
@section('script')
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            var myTable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: true,
                scrollCollapse: true,
                paging: true,
                ajax: {
                    url: '{{ route('peserta.index') }}'
                },
                columns: [{
                        "data": null,
                        "orderable": false,
                        "searchable": false,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "kelompok",
                        name: "kelompok",
                    }, {
                        data: "name",
                        name: "name",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            // Create
            var createHeading = "Tambah Peserta";
            createModel(createHeading);

            // Edit
            var editUrl = "{{ route('peserta.index') }}";
            var editHeading = "Edit Peserta";
            var field = ['kelompok_id', 'name'];
            editModel(editUrl, editHeading, field);

            // Save
            saveBtn("{{ route('peserta.store') }}", myTable);

            // Delete
            var fitur = "Peserta";
            var editUrl = "{{ route('peserta.index') }}";
            var deleteUrl = "{{ route('peserta.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)
        });
    </script>
@endsection
